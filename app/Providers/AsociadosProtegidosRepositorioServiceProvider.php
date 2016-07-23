<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Polizas\DoctrineAsociadosProtegidosRepositorio;
use Illuminate\Support\ServiceProvider;

class AsociadosProtegidosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio', function() {
            return new DoctrineAsociadosProtegidosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
