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
        $this->registerControllerRouteGenerator();
    }

    /**
     * Register the make:view generator.
     */
    private function registerViewGenerator()
    {
        $this->app->singleton('command.hesto.generators.view', function ($app) {
            return $app['Hesto\Generators\Commands\ViewMakeCommand'];
        });

        $this->commands('command.hesto.generators.view');
    }

    /**
     * Register the make:controller:crud generator.
     */
    private function registerControllerGenerator()
    {
        $this->app->singleton('command.hesto.generators.controller', function ($app) {
            return $app['Hesto\Generators\Commands\ControllerMakeCommand'];
        });

        $this->commands('command.hesto.generators.controller');
    }

    private function registerControllerRouteGenerator()
    {
        $this->app->singleton('command.hesto.generators.controller-route', function ($app) {
            return $app['Hesto\Generators\Commands\ControllerRouteMakeCommand'];
        });

        $this->commands('command.hesto.generators.controller-route');
    }
}
