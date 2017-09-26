<?php

namespace Galahad\Forms;

use Galahad\Forms\ErrorStore\IlluminateErrorStore;
use Galahad\Forms\OldInput\IlluminateOldInputProvider;
use Illuminate\Support\ServiceProvider;

class FormsServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->registerErrorStore();
        $this->registerOldInput();
        $this->registerFormBuilder();
    }

    protected function registerErrorStore()
    {
        $this->app->singleton('galahad.form.errorstore', function ($app) {
            return new IlluminateErrorStore($app['session.store']);
        });
    }

    protected function registerOldInput()
    {
        $this->app->singleton('galahad.form.oldinput', function ($app) {
            return new IlluminateOldInputProvider($app['session.store']);
        });
    }

    protected function registerFormBuilder()
    {
        $this->app->singleton('galahad.form', function ($app) {
            $formBuilder = new FormBuilder;
            $formBuilder->setErrorStore($app['galahad.form.errorstore']);
            $formBuilder->setOldInputProvider($app['galahad.form.oldinput']);
            $formBuilder->setToken($app['session.store']->token());

            return $formBuilder;
        });
    }

    public function provides()
    {
        return ['galahad.form'];
    }
}
