<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio;
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
    /**
     * crear un objeto vigencia
     * 
     * @param Request $request
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @return Vigencia
     */
    public static function crear(Request $request, VigenciasRepositorio $vigenciasRepositorio)
    {
        if ($request->get('vigencias') === '-1') {
            // otra vigencia
            $vigencia = new Vigencia($request->get('nuevaVigencia'));

        } else {
            $vigencia = $vigenciasRepositorio->obtenerPorId((int)$request->get('vigencias'));
        }

        return $vigencia;
    }
}