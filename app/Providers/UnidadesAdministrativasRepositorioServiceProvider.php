<?php

namespace GDI\Providers;

use App;
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
        $this->app->bind('GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio', function() {
            return new DoctrineUnidadesAdministrativasRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
