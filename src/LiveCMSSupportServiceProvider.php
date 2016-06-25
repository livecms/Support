<?php

namespace LiveCMS\Support;

use Illuminate\Support\ServiceProvider;
use LiveCMS\Providers\LiveCMSServiceProvider;

class LiveCMSSupportServiceProvider extends ServiceProvider
{
    protected function bootPublish()
    {
        // Config
        if (!class_exists(LiveCMSServiceProvider::class)) {
            $this->publishes([__DIR__.'/../config/livecms.php' => config_path('livecms.php')], 'config');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootPublish();
        
        \LiveCMS\Support\Emailer\EmailerServiceProvider::shouldBooted();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (!class_exists(LiveCMSServiceProvider::class)) {
            $this->mergeConfigFrom(__DIR__.'/../config/livecms.php', 'livecms');
        }

        \LiveCMS\Support\Emailer\EmailerServiceProvider::shouldRegistered();
        \LiveCMS\Support\FileGrabber\FileGrabberServiceProvider::shouldRegistered();
        \LiveCMS\Support\Thumbnailer\ThumbnailerServiceProvider::shouldRegistered();
        \LiveCMS\Support\Uploader\UploaderServiceProvider::shouldRegistered();
    }
}
