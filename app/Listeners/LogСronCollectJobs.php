<?php

namespace Api\Listeners;

use Api\Events\CronCollectJobs;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogСronCollectJobs
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
     * @param  CronCollectJobs  $event
     * @return void
     */
    public function handle(CronCollectJobs $event)
    {
        //
    }
}
