<?php

namespace LiveCMS\Support;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public static function shouldBooted()
    {
        return (new static(app()))->boot();
    }

    public static function shouldRegistered()
    {
        return (new static(app()))->register();
    }
}
