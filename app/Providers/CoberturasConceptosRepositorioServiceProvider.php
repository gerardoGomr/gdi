<?php

namespace GDI\Providers;

use App;
use GDI\Infraestructura\Coberturas\DoctrineCoberturasConceptosRepositorio;
use Illuminate\Support\ServiceProvider;

class CoberturasConceptosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio', function() {
            return new DoctrineCoberturasConceptosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
