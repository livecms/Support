<?php

namespace LiveCMS\Support\Thumbnailer;

use LiveCMS\Support\ServiceProvider;

class ThumbnailerServiceProvider extends ServiceProvider
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
        $this->app->singleton('thumbnailer', function ($app) {
            $config = $app['config']->get('livecms.thumbnailer');
            return new Thumbnailer($config);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['thumbnailer'];
    }
}
