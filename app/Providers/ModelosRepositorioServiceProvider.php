<?php

namespace GDI\Providers;

use GDI\Infraestructura\Vehiculos\DoctrineModelosRepositorio;
use Illuminate\Support\ServiceProvider;

class ModelosRepositorioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio', function($app) {
            return new DoctrineModelosRepositorio($app['em']);
        });
    }
}
