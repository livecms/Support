<?php

namespace LiveCMS\Support\FileGrabber;

use LiveCMS\Support\ServiceProvider;

class FileGrabberServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('filegrabber', function ($app) {
            $grabber = new FileGrabber;
            $grabber->setTemp(storage_path('app/grabbers'), 0775);
            return $grabber;
        });
    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['filegrabber'];
    }
}
