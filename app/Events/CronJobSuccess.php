<?php

namespace Api\Events;

use Api\Task;
use Api\TaskLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CronJobSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $runtime, $rundate)
    {
        $Task = Task::where('name', '=', $name)->first();

        $task_logs = new TaskLog;
        $task_logs->task_id = $Task->id;
        $task_logs->status = 1;
        $task_logs->message = 'Задание выполненно успешно';
        $task_logs->run_time = $runtime;
        $task_logs->save();
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
