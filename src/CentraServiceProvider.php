<?php

namespace Kodebyraaet\Centra;

use Illuminate\Support\ServiceProvider;

class CentraServiceProvider extends ServiceProvider {

    protected $defer = true;

    public function register()
    {
        $this->app->singleton('centra', function($app) {
            return new Centra();
        });
    }

    public function provides()
    {
        return ['centra'];
    }

}