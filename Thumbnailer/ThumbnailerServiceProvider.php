<?php

namespace LiveCMS\Support\Thumbnailer;

use Illuminate\Support\ServiceProvider;

class ThumbnailerServiceProvider extends ServiceProvider
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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('thumbnailer', function () {
            return new Thumbnailer;
        });
    }
}
