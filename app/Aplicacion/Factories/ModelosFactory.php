<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Vehiculos\Modelo;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio;
use Illuminate\Http\Request;

/**
 * Class ModelosFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ModelosFactory
{
    /**
     * crear una nueva instancia de modelo
     * @param Oficina $oficina
     * @param Request $request
     * @param MarcasRepositorio $marcasRepositorio
     * @param ModelosRepositorio $modelosRepositorio
     * @return Modelo
     */
    public static function crear(Oficina $oficina, Request $request, MarcasRepositorio $marcasRepositorio, ModelosRepositorio $modelosRepositorio)
    {
        $marca = MarcasFactory::crear($request, $marcasRepositorio);

        if ($request->get('modelo') === '-1') {
            // es un nuevo modelo, crear
            $modelo = new Modelo($request->get('otroModelo'), $marca, $oficina);

        } else {
            // leer del repositorio
            $modeloId = (int)$request->get('modelo');
            $modelo   = $modelosRepositorio->obtenerPorId($modeloId, $oficina->getId());
        }

        // cerrar la relación
        $marca->getModelos()->add($modelo);

        return $modelo;
    }
}