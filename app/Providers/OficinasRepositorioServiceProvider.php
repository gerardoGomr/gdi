<?php

namespace GDI\Providers;

use GDI\Dominio\Oficinas\Repositorios\OficinasRepositorio;
use GDI\Infraestructura\Oficinas\DoctrineOficinasRepositorio;
use Illuminate\Support\ServiceProvider;

class OficinasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind(OficinasRepositorio::class, function ($app) {
            return new DoctrineOficinasRepositorio($app['em']);
        });
    }
}
