<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Coberturas\DoctrineCostosRepositorio;
use Illuminate\Support\ServiceProvider;

class CostosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Coberturas\Repositorios\CostosRepositorio', function() {
            return new DoctrineCostosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
