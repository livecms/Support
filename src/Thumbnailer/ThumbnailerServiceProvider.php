<?php

namespace LiveCMS\Support\Thumbnailer;

use Intervention\Image\ImageManager;
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
            $imageConfig = $app['config']->get('image') ?: $app['config']->get('livecms.image');
            $image = new ImageManager($imageConfig);

            $config = $app['config']->get('livecms.thumbnailer');
            $thumbnailer = new Thumbnailer(null, $config);
            $thumbnailer->setImage($image);

            return $thumbnailer;
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
