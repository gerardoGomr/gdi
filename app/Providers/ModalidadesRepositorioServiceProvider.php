<?php

namespace GDI\Providers;

use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use GDI\Infraestructura\Vehiculos\DoctrineModalidadesOficinaRepositorio;
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
        $this->app->bind(ModalidadesRepositorio::class, function($app) {
            $user = session('usuario');

            if ($user->getUsuarioTipo() !== 1) {
                return new DoctrineModalidadesOficinaRepositorio($app['em'], $user->getOficina());
            }

            return new DoctrineModalidadesRepositorio($app['em']);
        });
    }
}
