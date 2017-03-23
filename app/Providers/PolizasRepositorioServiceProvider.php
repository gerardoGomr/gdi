<?php

namespace Providers;

use App;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Infraestructura\Polizas\DoctrinePolizasOficinaRepositorio;
use GDI\Infraestructura\Polizas\DoctrinePolizasRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class PolizasRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind(PolizasRepositorio::class, function($app) {
            if ($verificador->rol !== 1) {
                return new DoctrinePolizasOficinaRepositorio($app['em'], $verificador->oficina);
            }

            return new DoctrinePolizasRepositorio($app['em']);
        });
    }
}