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

    public $name;
    public $runtime;
    public $rundate;
    public $task_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($name, $runtime, $rundate)
    {
        $this->name = $name;
        $this->runtime = $runtime;
        $this->rundate = $rundate;
        $this->task_id = Task::where('name', '=', $name)->first()->id;
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
