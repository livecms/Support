<?php

namespace LiveCMS\Support;

use Illuminate\Support\ServiceProvider;

class LiveCMSSupportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LiveCMS\Emailer\EmailerServiceProvider::shouldBooted();
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        LiveCMS\Emailer\EmailerServiceProvider::shouldRegistered();
        LiveCMS\FileGrabber\FileGrabberServiceProvider::shouldRegistered();
        LiveCMS\Thumbnailer\ThumbnailerServiceProvider::shouldRegistered();
        LiveCMS\Uploader\UploaderServiceProvider::shouldRegistered();
    }
}
