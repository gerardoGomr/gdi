<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Vehiculos\Modalidad;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use Illuminate\Http\Request;

/**
 * Class ModalidadesFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ModalidadesFactory
{
    /**
     * crear una nueva instancia de Modalidad
     * @param Oficina $oficina
     * @param Request $request
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @return Modalidad
     */
    public static function crear(Oficina $oficina, Request $request, ModalidadesRepositorio $modalidadesRepositorio)
    {
        if ($request->get('modalidad') === '-1') {
            // es un nuevo modelo, crear
            $modalidad = new Modalidad($request->get('otraModalidad'), $oficina);

        } else {
            // leer del repositorio
            $modalidadId = (int)$request->get('modalidad');
            $modalidad   = $modalidadesRepositorio->obtenerPorId($modalidadId, $oficina->getId());
        }

        return $modalidad;
    }
}