<?php

namespace Kodebyraaet\Centra;

use Illuminate\Support\ServiceProvider;

class CentraServiceProvider extends ServiceProvider {

    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/centra.php' => config_path('centra.php')
        ], 'centra');
    }

    public function register()
    {
        $this->mergeConfigFrom( __DIR__ . '/../config/centra.php', 'centra');

        $this->app->singleton('centra', function($app) {

            $config = $app->make('config');
            $endpoint = $config->get('centra.endpoint');

            return new Centra($endpoint);
        });
    }

    public function provides()
    {
        return ['centra'];
    }

}