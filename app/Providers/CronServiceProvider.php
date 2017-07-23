<?php

namespace Api\Providers;

use Api\Task;
use \Liebig\Cron\Cron;
use Illuminate\Support\ServiceProvider;

class CronServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $Tasks = Task::Active()->orderBy('priority')->get();

        foreach ($Tasks as $Task) {
            Cron::add($Task->name, $Task->frequency, [$c = new $Task->class_name, 'CronCallback'], (bool)$Task->is_enabled);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
