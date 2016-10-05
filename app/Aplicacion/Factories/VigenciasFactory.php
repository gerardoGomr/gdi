<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Vigencia;
use Illuminate\Http\Request;

/**
 * Class VigenciasFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class VigenciasFactory
{
    public static function crear(Request $request, PolizasRepositorio $vigenciasRepositorio)
    {
        if ($request->get('vigencias') === '-1') {
            // otra vigencia
            $vigencia = new Vigencia($request->get('nuevaVigencia'));

        } else {
            $vigencia = $vigenciasRepositorio->obtenerVigenciaPorId((int)$request->get('vigencias'));
        }

        return $vigencia;
    }
}