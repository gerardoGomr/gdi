<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Polizas\DoctrineServiciosRepositorio;
use Illuminate\Support\ServiceProvider;

class ServiciosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio', function() {
            return new DoctrineServiciosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
