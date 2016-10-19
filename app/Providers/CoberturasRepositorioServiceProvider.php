<?php

namespace GDI\Providers;

use GDI\Infraestructura\Coberturas\DoctrineCoberturasRepositorio;
use Illuminate\Support\ServiceProvider;

class CoberturasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio', function($app) {
            return new DoctrineCoberturasRepositorio($app['em']);
        });
    }
}
