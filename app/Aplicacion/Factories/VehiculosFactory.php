<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Vehiculos\Modalidad;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\VehiculosRepositorio;
use GDI\Dominio\Vehiculos\Vehiculo;
use Illuminate\Http\Request;

/**
 * Class VehiculosFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class VehiculosFactory
{
    /**
     * crear una nueva instancia de vehículo
     *
     * @param Request $request
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @param MarcasRepositorio $marcasRepositorio
     * @param ModelosRepositorio $modelosRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param Oficina $oficina
     * @param Modalidad $modalidad
     * @return Vehiculo
     */
    public static function crear(Request $request, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio, MarcasRepositorio $marcasRepositorio, ModelosRepositorio $modelosRepositorio, AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio, VehiculosRepositorio $vehiculosRepositorio, Oficina $oficina, Modalidad $modalidad)
    {
        // datos de vehículo
        $anio        = (int)$request->get('anio');
        $numeroSerie = $request->get('numSerie');
        $numeroMotor = $request->get('numMotor');
        $placas      = $request->get('placas');
        $capacidad   = (int)$request->get('capacidad');
        
        if ($request->get('vehiculoNuevo') === '1') {
            // vehículo
            $modelo            = ModelosFactory::crear($oficina, $request, $marcasRepositorio, $modelosRepositorio);
            $asociadoProtegido = AsociadosProtegidosFactory::crear($request, $unidadesAdministrativasRepositorio, $asociadosProtegidosRepositorio, $oficina);
            $vehiculo          = new Vehiculo($modelo, $anio, $capacidad, $numeroSerie, $numeroMotor, $placas, $modalidad, $asociadoProtegido, $oficina);

        } else {
            // vehiculo existente
            $vehiculoId = (int)$request->get('vehiculoId');
            $vehiculo   = $vehiculosRepositorio->obtenerPorId($vehiculoId, $oficina->getId());
        }
        
        return $vehiculo;
        
    }
}