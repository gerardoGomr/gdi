<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Vehiculos\DoctrineModelosRepositorio;
use Illuminate\Support\ServiceProvider;

class ModelosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio', function() {
            return new DoctrineModelosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
