<?php

namespace Api\Events;

use Api\Task;
use Api\TaskLog;
use Api\TaskStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CronJobError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $return, $runtime, $rundate)
    {
        $Task = Task::where('name', '=', $name)->first();

        $task_logs = new TaskLog;
        $task_logs->task_id = $Task->id;
        $task_logs->status = 0;
        $task_logs->message = $return;
        $task_logs->run_time = $runtime;
        $task_logs->save();

        $TaskStatus = TaskStatus::find($Task->id);

        $TaskStatus->last_run = date('Y-m-d H:i:s', $rundate);

        $TaskStatus->save();

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
