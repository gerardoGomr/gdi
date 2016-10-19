<?php

namespace GDI\Providers;

use GDI\Infraestructura\Polizas\DoctrineAsociadosAgentesRepositorio;
use Illuminate\Support\ServiceProvider;

class AsociadosAgentesRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio', function($app) {
            return new DoctrineAsociadosAgentesRepositorio($app['em']);
        });
    }
}
