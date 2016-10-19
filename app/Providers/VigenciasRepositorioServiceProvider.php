<?php

namespace GDI\Providers;

use GDI\Infraestructura\Coberturas\DoctrineVigenciasRepositorio;
use Illuminate\Support\ServiceProvider;

class VigenciasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio', function($app) {
            return new DoctrineVigenciasRepositorio($app['em']);
        });
    }
}
