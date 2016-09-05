<?php

namespace Hesto\Generators;

use Illuminate\Support\ServiceProvider;

class GeneratorsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('hesto/generators.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerViewGenerator();
        $this->registerControllerGenerator();
    }

    /**
     * Register the make:view generator.
     */
    private function registerViewGenerator()
    {
        $this->app->singleton('command.hesto.view', function ($app) {
            return $app['Hesto\Generators\Commands\ViewMakeCommand'];
        });

        $this->commands('command.hesto.view');
    }

    /**
     * Register the make:controller:crud generator.
     */
    private function registerControllerGenerator()
    {
        $this->app->singleton('command.hesto.controller', function ($app) {
            return $app['Hesto\Generators\Commands\ControllerMakeCommand'];
        });

        $this->commands('command.hesto.controller');
    }
}
