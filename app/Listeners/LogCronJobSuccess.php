<?php

namespace Api\Listeners;

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
     * @param  CronJobSuccess  $event
     * @return void
     */
    public function handle(CronJobSuccess $event)
    {
        //
    }
}
