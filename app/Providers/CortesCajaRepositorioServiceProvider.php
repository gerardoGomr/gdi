<?php

namespace GDI\Providers;

use GDI\Dominio\Oficinas\Repositorios\CortesCajaRepositorio;
use GDI\Infraestructura\Oficinas\DoctrineCortesCajaRepositorio;
use Illuminate\Support\ServiceProvider;

class CortesCajaRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind(CortesCajaRepositorio::class, function($app) {
            return new DoctrineCortesCajaRepositorio($app['em']);
        });
    }
}
