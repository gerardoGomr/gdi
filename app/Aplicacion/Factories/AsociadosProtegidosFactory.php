<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Domicilio;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Polizas\AsociadoProtegido;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio;
use GDI\Dominio\Vehiculos\Vehiculo;
use Illuminate\Http\Request;

/**
 * Class AsociadosProtegidosFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class AsociadosProtegidosFactory
{
    /**
     * crear una nueva instancia de asociado protegido
     * 
     * @param Request $request
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio
     * @param Oficina $oficina
     * @return AsociadoProtegido|mixed
     */
    public static function crear(Request $request, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio, AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio, Oficina $oficina)
    {
        if ($request->get('asociadoNuevo') === '1') {
            // datos de asociado protegido
            $tipoPersona         = (int)$request->get('tipoPersona');
            $nombre              = $request->get('nombre');
            $paterno             = $request->get('paterno');
            $materno             = $request->get('materno');
            $razonSocial         = $request->get('razonSocial');
            $rfc                 = $request->get('rfc');
            $calleAsociado       = $request->get('calleAsociado');
            $numExteriorAsociado = $request->get('numExteriorAsociado');
            $numInteriorAsociado = $request->get('numInteriorAsociado');
            $coloniaAsociado     = $request->get('coloniaAsociado');
            $cpAsociado          = $request->get('cpAsociado');
            $ciudadAsociadoId    = (int)$request->get('ciudadAsociado');
            $telefonoAsociado    = $request->get('telefonoAsociado');
            $celularAsociado     = $request->get('celularAsociado');
            $emailAsociado       = $request->get('emailAsociado');

            // unidad administrativa y domicilio
            $unidadAdministrativa = $unidadesAdministrativasRepositorio->obtenerPorId($ciudadAsociadoId);
            $domicilio            = new Domicilio($calleAsociado, $numExteriorAsociado, $numInteriorAsociado, $coloniaAsociado, $cpAsociado, $unidadAdministrativa);

            // asociado protegido
            $asociadoProtegido = new AsociadoProtegido($rfc, $tipoPersona, $telefonoAsociado, $celularAsociado, $emailAsociado);
            $asociadoProtegido->generar($nombre, $paterno, $materno, $razonSocial, $domicilio, $oficina);    
        
        } else {
            $asociadoProtegidoId = (int)$request->get('asociadoProtegidoId');
            $asociadoProtegido   = $asociadosProtegidosRepositorio->obtenerPorId($asociadoProtegidoId);
        }
        

        return $asociadoProtegido;
    }
}