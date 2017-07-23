<?php

namespace Api\Providers;

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

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            $this->app->bind('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }
    }
}
