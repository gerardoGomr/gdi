<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Vehiculos\DoctrineMarcasRepositorio;
use Illuminate\Support\ServiceProvider;

class MarcasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio', function() {
            return new DoctrineMarcasRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
