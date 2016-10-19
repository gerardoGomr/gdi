<?php

namespace GDI\Providers;

use GDI\Infraestructura\Personas\DoctrineUnidadesAdministrativasRepositorio;
use Illuminate\Support\ServiceProvider;

class UnidadesAdministrativasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio', function($app) {
            return new DoctrineUnidadesAdministrativasRepositorio($app['em']);
        });
    }
}
