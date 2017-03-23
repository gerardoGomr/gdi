<?php
namespace GDI\Http\Middleware;

use Closure;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Oficinas\Repositorios\CortesCajaRepositorio;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use GDI\Infraestructura\Coberturas\DoctrineCoberturasOficinaRepositorio;
use GDI\Infraestructura\Coberturas\DoctrineCoberturasRepositorio;
use GDI\Infraestructura\Oficinas\DoctrineCortesCajaOficinaRepositorio;
use GDI\Infraestructura\Oficinas\DoctrineCortesCajaRepositorio;
use GDI\Infraestructura\Polizas\DoctrineAsociadosProtegidosOficinaRepositorio;
use GDI\Infraestructura\Polizas\DoctrineAsociadosProtegidosRepositorio;
use GDI\Infraestructura\Polizas\DoctrinePolizasRepositorio;
use GDI\Infraestructura\Polizas\DoctrinePolizasOficinaRepositorio;
use GDI\Infraestructura\Polizas\DoctrineAsociadosAgentesRepositorio;
use GDI\Infraestructura\Polizas\DoctrineAsociadosAgentesOficinaRepositorio;

class MyInterfaceBinder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // binds para usuarios que no sean admin
        $app = app()->getInstance();

        if (session()->has('user') && session('user')->rol() !== 1) {
            $oficina = session('user')->getOficina();

            // polizas
            $app->bind(PolizasRepositorio::class, function($app) use ($oficina) {
                return new DoctrinePolizasOficinaRepositorio($app['em'], $oficina);
            });

            // asociados agentes
            $app->bind(AsociadosAgentesRepositorio::class, function($app) use ($oficina) {
                return new DoctrineAsociadosAgentesOficinaRepositorio($app['em'], $oficina);
            });

            // coberturas
            $app->bind(CoberturasRepositorio::class, function($app) use ($oficina) {
                return new DoctrineCoberturasOficinaRepositorio($app['em'], $oficina);
            });

            // asociados protegidos
            $app->bind(AsociadosProtegidosRepositorio::class, function($app) use ($oficina) {
                return new DoctrineAsociadosProtegidosOficinaRepositorio($app['em'], $oficina);
            });
            
            // corte caja
            $app->bind(CortesCajaRepositorio::class, function($app) use ($oficina) {
                return new DoctrineCortesCajaOficinaRepositorio($app['em'], $oficina);
            });
            
        } else {
            // $this->bindUserAdminOrDefault($app);
            // pólizas
            $app->bind(PolizasRepositorio::class, function($app) {
                return new DoctrinePolizasRepositorio($app['em']);
            });

            // asociados agentes
            $app->bind(AsociadosAgentesRepositorio::class, function($app) {
                return new DoctrineAsociadosAgentesRepositorio($app['em']);
            });

            // coberturas
            $app->bind(CoberturasRepositorio::class, function($app) {
                return new DoctrineCoberturasRepositorio($app['em']);
            });

            // asociados protegidos
            $app->bind(AsociadosProtegidosRepositorio::class, function($app) {
                return new DoctrineAsociadosProtegidosRepositorio($app['em']);
            });

            // corte caja
            $app->bind(CortesCajaRepositorio::class, function($app) {
                return new DoctrineCortesCajaRepositorio($app['em']);
            });
        }
        return $next($request);
    }
}