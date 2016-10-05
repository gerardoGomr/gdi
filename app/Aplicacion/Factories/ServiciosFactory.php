<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio;
use GDI\Dominio\Polizas\Servicio;
use Illuminate\Http\Request;

/**
 * Class ServiciosFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ServiciosFactory
{
    /**
     * crear una nueva instancia de Servicio
     * @param Request $request
     * @param ServiciosRepositorio $serviciosRepositorio
     * @return Servicio
     */
    public static function crear(Request $request, ServiciosRepositorio $serviciosRepositorio)
    {
        if ($request->get('servicio') === '1') {
            // es un nuevo modelo, crear
            $servicio = new Servicio($request->get('otroServicio'));

        } else {
            // leer del repositorio
            $servicioId = (int)$request->get('servicio');
            $servicio   = $serviciosRepositorio->obtenerPorId($servicioId);
        }

        return $servicio;
    }
}