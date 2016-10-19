<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Coberturas\Costo;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Coberturas\Vigencia;
use GDI\Dominio\Vehiculos\Modalidad;
use Illuminate\Http\Request;

/**
 * Class CostosFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CostosFactory
{
    /**
     * @param Request $request
     * @param Vigencia $vigencia
     * @param Modalidad $modalidad
     * @param CostosRepositorio $costosRepositorio
     * @return Costo
     */
    public static function crear(Request $request, Vigencia $vigencia, Modalidad $modalidad, CostosRepositorio $costosRepositorio)
    {
        if ($request->get('cobertura') === '-1') {
            $costo = new Costo((double)$request->get('nuevoCosto'), $vigencia, $modalidad);

        } else {
            $costo = $costosRepositorio->obtenerPorId((int)$request->get('vigenciaCobertura'));
        }

        return $costo;
    }
}