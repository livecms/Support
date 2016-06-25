<?php

namespace LiveCMS\Support\Emailer;

use LiveCMS\Support\ServiceProvider;

class EmailerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $emailer = $this->app['emailer'];
        $config = $this->app['config']->get('livecms.emailer') ?: [];
        $emailer->compose($config);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('emailer', function ($app) {
            $mailer = $app['mailer'];
            return new Emailer($mailer);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['emailer'];
    }
}
