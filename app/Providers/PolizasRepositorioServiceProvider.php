<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Polizas\DoctrinePolizasRepositorio;
use Illuminate\Support\ServiceProvider;

class PolizasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Polizas\Repositorios\PolizasRepositorio', function($app) {
            return new DoctrinePolizasRepositorio($app['em']);
        });
    }
}
