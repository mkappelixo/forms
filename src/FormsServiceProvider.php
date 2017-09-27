<?php

namespace Galahad\Forms;

use Galahad\Forms\ErrorStore\IlluminateErrorStore;
use Galahad\Forms\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider;

class FormsServiceProvider extends ServiceProvider
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
        $this->registerErrorStore()->registerOldInput()->registerFormBuilder();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'galahad.forms',
            'galahad.forms.errorstore',
            'galahad.forms.oldinput',
        ];
    }

    /**
     * @return $this
     */
    protected function registerErrorStore()
    {
        $this->app->singleton('galahad.forms.errorstore', function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });

        return $this;
    }

    /**
     * @return $this
     */
    protected function registerOldInput()
    {
        $this->app->singleton('galahad.forms.oldinput', function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });

        return $this;
    }

    /**
     * @return $this
     */
    protected function registerFormBuilder()
    {
        $this->app->singleton('galahad.forms', function ($app) {
            return (new FormBuilder())
                ->setErrorStore($app['galahad.forms.errorstore'])
                ->setOldInputProvider($app['galahad.forms.oldinput'])
                ->setToken(optional($app['session.store'])->token());
        });

        return $this;
    }
}
