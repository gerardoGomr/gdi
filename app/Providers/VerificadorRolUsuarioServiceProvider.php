<?php

namespace GDI\Providers;

use App;
use GDI\Aplicacion\VerificadorRolUsuario;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Infraestructura\Polizas\DoctrinePolizasOficinaRepositorio;
use GDI\Infraestructura\Polizas\DoctrinePolizasRepositorio;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class VerificadorRolUsuarioServiceProvider extends ServiceProvider
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
        $this->app->singleton(VerificadorRolUsuario::class);
    }
}