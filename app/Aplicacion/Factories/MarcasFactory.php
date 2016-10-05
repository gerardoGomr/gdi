<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Vehiculos\Marca;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use Illuminate\Http\Request;

/**
 * Class MarcasFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class MarcasFactory
{
    /**
     * crear una nueva instancia de marca
     * @param Request $request
     * @param MarcasRepositorio $marcasRepositorio
     * @return Marca
     */
    public static function crear(Request $request, MarcasRepositorio $marcasRepositorio)
    {
        if ($request->get('marca') === '1') {
            // es un nuevo modelo, crear
            $marca = new Marca($request->get('otraMarca'));

        } else {
            // leer del repositorio
            $marcaId = (int)$request->get('marca');
            $marca   = $marcasRepositorio->obtenerPorId($marcaId);
        }

        return $marca;
    }
}