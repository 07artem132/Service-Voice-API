<?php

namespace Api\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->register(\Sentry\SentryLaravel\SentryLaravelServiceProvider::class);
	    $loader = \Illuminate\Foundation\AliasLoader::getInstance();

	    $loader->alias('Sentry', 'Sentry\SentryLaravel\SentryFacade::class');

	    if ($this->app->environment() !== 'production') {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
            $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');

            $loader->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        }
    }
}
