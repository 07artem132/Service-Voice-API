<?php

namespace Api\Listeners;

use Api\Task;
use Api\TaskLog;
use Api\Events\CronJobSuccess;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCronJobSuccess
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CronJobSuccess $event
     * @return void
     */
    public function handle(CronJobSuccess $event)
    {

        $task_logs = new TaskLog;
        $task_logs->task_id = $event->task_id;
        $task_logs->status = 1;
        $task_logs->message = 'Задание выполненно успешно';
        $task_logs->run_time = $event->runtime;
        $task_logs->save();

        $TaskStatus = task::find($event->task_id);

        $TaskStatus->last_run = date('Y-m-d H:i:s', $event->rundate);

        $TaskStatus->save();

    }
}
