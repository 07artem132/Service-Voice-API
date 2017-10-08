<?php

namespace Api\Providers;

use Api\Events\CronBeforeRun;
use Api\Events\CronJobSuccess;
use Api\Events\CronLocked;
use Api\Events\CronAfterRun;
use Api\Events\CronCollectJobs;
use Api\Events\CronJobError;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'Api\Listeners\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\Failed' => [
            'Api\Listeners\LogFailedLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'Api\Listeners\LogSuccessfulLogout',
        ],
        'Illuminate\Auth\Events\Authenticated' => [
            'Api\Listeners\LogAuthenticated',
        ],
        'Api\Events\CronCollectJobs' => [
            'Api\Listeners\LogСronCollectJobs',
        ],
        'Api\Events\CronBeforeRun' => [
            'Api\Listeners\LogCronBeforeRun',
        ],
        'Api\Events\CronJobError' => [
            'Api\Listeners\LogCronJobError',
        ],
        'Api\Events\CronJobSuccess' => [
            'Api\Listeners\LogCronJobSuccess',
        ],
        'Api\Events\CronAfterRun' => [
            'Api\Listeners\LogCronAfterRun',
        ],
        'Api\Events\CronLocked' => [
            'Api\Listeners\LogCronLockedFile',
        ],
        'Illuminate\Cache\Events\CacheHit' => [
            'Api\Listeners\LogCacheHit',
        ],
        'Illuminate\Cache\Events\CacheMissed' => [
            'Api\Listeners\LogCacheMissed',
        ],
        'Illuminate\Cache\Events\KeyWritten' => [
            'Api\Listeners\LogKeyWritten',
        ],
        'Illuminate\Cache\Events\KeyForgotten' => [
            'Api\Listeners\LogKeyForgotten',
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        ///Переобернули события старого типа в более удобный тип

        Event::listen('cron.collectJobs', function () {
            Event::fire(new CronCollectJobs());
        });
        Event::listen('cron.beforeRun', function ($RunDate) {
            Event::fire(new CronBeforeRun($RunDate));
        });
        Event::listen('cron.jobError', function ($name, $return, $runtime, $rundate) {
            Event::fire(new CronJobError($name, $return, $runtime, $rundate));
        });
        Event::listen('cron.jobSuccess', function ($name, $runtime, $rundate) {
            Event::fire(new CronJobSuccess($name, $runtime, $rundate));
        });
        Event::listen('cron.afterRun', function ($name, $return, $runtime, $rundate) {
            Event::fire(new CronAfterRun($name, $return, $runtime, $rundate));
        });
        Event::listen('cron.locked', function ($lockfile) {
            Event::fire(new CronLocked($lockfile));
        });
    }
}
