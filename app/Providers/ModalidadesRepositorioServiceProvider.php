<?php

namespace GDI\Providers;

use GDI\Infraestructura\Vehiculos\DoctrineModalidadesRepositorio;
use Illuminate\Support\ServiceProvider;

class ModalidadesRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio', function($app) {
            return new DoctrineModalidadesRepositorio($app['em']);
        });
    }
}
