<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Vehiculos\DoctrineModalidadesRepositorio;
use Illuminate\Support\ServiceProvider;

class ModalidadesRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio', function() {
            return new DoctrineModalidadesRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
