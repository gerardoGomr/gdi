<?php

namespace GDI\Providers;

use GDI\Infraestructura\Vehiculos\DoctrineVehiculosRepositorio;
use Illuminate\Support\ServiceProvider;

class VehiculosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Vehiculos\Repositorios\VehiculosRepositorio', function($app) {
            return new DoctrineVehiculosRepositorio($app['em']);
        });
    }
}
