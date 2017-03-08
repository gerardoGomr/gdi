<?php

namespace GDI\Providers;

use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use GDI\Infraestructura\Polizas\DoctrineAsociadosAgentesOficinaRepositorio;
use GDI\Infraestructura\Polizas\DoctrineAsociadosAgentesRepositorio;
use Illuminate\Support\ServiceProvider;

class AsociadosAgentesRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind(AsociadosAgentesRepositorio::class, function($app) {
            $user = session('usuario');

            if ($user->getUsuarioTipo() !== 1) {
                return new DoctrineAsociadosAgentesOficinaRepositorio($app['em'], $user->getOficina());
            }

            return new DoctrineAsociadosAgentesRepositorio($app['em']);
        });
    }
}
