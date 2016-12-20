<?php
namespace GDI\Providers;

use GDI\Infraestructura\Coberturas\DoctrineResponsabilidadesRepositorio;
use Illuminate\Support\ServiceProvider;

class ResponsabilidadesRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Coberturas\Repositorios\ResponsabilidadesRepositorio', function($app) {
            return new DoctrineResponsabilidadesRepositorio($app['em']);
        });
    }
}
