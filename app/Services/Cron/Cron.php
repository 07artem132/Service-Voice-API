<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 27.06.2017
 * Time: 18:04
 */

namespace Api\Services\Cron;

use Api\Task;
use Api\TaskStatus;
use Api\TaskLog;

class Cron
{
    public function ActualTaskRun()
    {
        $ActualTasks = $this->GetActualTasks();

        if ($ActualTasks[0]->Tasks === null)
            return;

        foreach ($ActualTasks as $task) {
            $this->TaskRunDbStatus($task->Tasks->id);

            $taskStartTime = microtime(true);

            try {
                $RunTask = new $task->class_name;
                unset($RunTask);

            } catch (\Exception $e) {
                $this->TaskEndDbStatus($task->Tasks->id);
                $this->UpdateLastRun($task->Tasks->id);
                $this->LogAdd($task->id, 0, 'Задача [' . $task->name . '] ошибка:' . $e->getMessage());

                continue;
            }

            $tun_time = microtime(true) - $taskStartTime;

            $this->TaskEndDbStatus($task->Tasks->id);
            $this->UpdateLastRunAndNextDue($task->Tasks->id, $task->frequency);
            $this->LogAdd($task->id, 1, 'Задача [' . $task->name . '] выполнена', $tun_time);
        }

        return null;
    }

    private function GetActualTasks()
    {
        $ActualTasks = Task::with(['Tasks' => function ($query) {
            // Костыль, мы добавляем 5 секунд дабы невелировать "задержку" крона
            $query->where('next_due', '<=', date('Y-m-d H:i:s', time() + 5));
        }])->Active()->orderBy('priority')->get();

        return $ActualTasks;
    }

    private function LogAdd($task_id, $status, $message, $run_time = null)
    {
        $task_logs = new TaskLog;

        $task_logs->task_id = $task_id;
        $task_logs->status = $status;
        $task_logs->message = $message;
        $task_logs->run_time = $run_time;

        $task_logs->save();

        return;
    }

    private function TaskRunDbStatus($id)
    {
        $TaskStatus = TaskStatus::find($id);

        $TaskStatus->in_progress = 1;

        $TaskStatus->save();
    }

    private function TaskEndDbStatus($id)
    {
        $TaskStatus = TaskStatus::find($id);

        $TaskStatus->in_progress = 0;

        $TaskStatus->save();
    }

    private function UpdateLastRun($id)
    {
        $TaskStatus = TaskStatus::find($id);

        $TaskStatus->last_run = date('Y-m-d H:i:s');

        $TaskStatus->save();
    }

    private function UpdateLastRunAndNextDue($id, $frequency)
    {

        $TaskStatus = TaskStatus::find($id);

        $TaskStatus->last_run = date('Y-m-d H:i:s');
        $TaskStatus->next_due = date('Y-m-d H:i:00', time() + ($frequency * 60));

        $TaskStatus->save();

    }
}