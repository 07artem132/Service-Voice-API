<?php

namespace Api\Providers;

use Api\Services\Cron\Cron;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Api\Http\Controllers\TestController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \Cron::add('CRON API', '* * * * *', function () {
            $CronAPI = new Cron();
            $CronAPI->ActualTaskRun();

            return null;
        });


        //      \Debugbar::enable();

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // \Debugbar::disable();
    }
}
