<?php
namespace GDI\Providers;

use App;
use GDI\Infraestructura\Usuarios\DoctrineUsuariosRepositorio;
use Illuminate\Support\ServiceProvider;

class UsuariosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('GDI\Dominio\Usuarios\Repositorios\UsuariosRepositorio', function() {
            return new DoctrineUsuariosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
