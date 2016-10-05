<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Coberturas\DoctrineCoberturasConceptosRepositorio;
use GDI\Infraestructura\Coberturas\DoctrineVigenciasRepositorio;
use Illuminate\Support\ServiceProvider;

class VigenciasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio', function() {
            return new DoctrineVigenciasRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
