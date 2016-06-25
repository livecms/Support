<?php

namespace LiveCMS\Support\Uploader;

use LiveCMS\Support\ServiceProvider;

class UploaderServiceProvider extends ServiceProvider
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
        $this->app->singleton('uploader', function ($app) {
            $config = $this->app['config']->get('livecms.uploader') ?: [];
            return new Uploader($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['uploader'];
    }
}
