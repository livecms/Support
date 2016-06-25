<?php

namespace LiveCMS\Support;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function shouldBooted()
    {
        return (new static(app()))->boot();
    }

    public static function shouldRegistered()
    {
        return (new static(app()))->register();
    }
}
