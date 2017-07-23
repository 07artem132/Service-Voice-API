<?php

namespace Api\Listeners;

use Api\Events\CronJobError;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogCronJobError
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
     * @param  CronJobError  $event
     * @return void
     */
    public function handle(CronJobError $event)
    {
        //
    }
}
