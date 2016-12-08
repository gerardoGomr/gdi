<?php
namespace GDI\Aplicacion\Factories;

use GDI\Aplicacion\ConvertidorMayusculas;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Domicilio;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Polizas\AsociadoAgente;
use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use Illuminate\Http\Request;

/**
 * Class AsociadosAgentesFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class AsociadosAgentesFactory
{
    /**
     * generar la creación de un agente
     * @param Request $request
     * @param Oficina $oficina
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @return AsociadoAgente
     */
    public static function crear(Request $request, Oficina $oficina, AsociadosAgentesRepositorio $asociadosAgentesRepositorio, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio): AsociadoAgente
    {
        if ($request->get('asociadoAgente') === '1') {
            // nuevo
            $nombreAgente      = ConvertidorMayusculas::convertir($request->get('nombreAgente'));
            $paternoAgente     = ConvertidorMayusculas::convertir($request->get('paternoAgente'));
            $maternoAgente     = ConvertidorMayusculas::convertir($request->get('maternoAgente'));
            $rfc               = ConvertidorMayusculas::convertir($request->get('rfcAgente'));
            $calleAgente       = ConvertidorMayusculas::convertir($request->get('calleAgente'));
            $numExteriorAgente = ConvertidorMayusculas::convertir($request->get('numExteriorAgente'));
            $numInteriorAgente = ConvertidorMayusculas::convertir($request->get('numInteriorAgente'));
            $coloniaAgente     = ConvertidorMayusculas::convertir($request->get('coloniaAgente'));
            $cpAgente          = $request->get('cpAgente');
            $ciudadAgenteId    = (int)$request->get('ciudadAgente');
            $telefonoAgente    = $request->get('telefonoAgente');
            $celularAgente     = $request->get('celularAgente');
            $emailAgente       = $request->get('emailAsociado');

            // unidad administrativa y domicilio
            $unidadAdministrativa = $unidadesAdministrativasRepositorio->obtenerPorId($ciudadAgenteId);
            $domicilio            = new Domicilio($calleAgente, $numExteriorAgente, $numInteriorAgente, $coloniaAgente, $cpAgente, $unidadAdministrativa);
            
            $asociadoAgente = new AsociadoAgente($rfc, $telefonoAgente, $celularAgente, $emailAgente);
            $asociadoAgente->generar($nombreAgente, $paternoAgente, $maternoAgente, $domicilio, $oficina);
            
        } else {
            $asociadoAgenteId = (int)$request->get('asociadoAgente');
            $asociadoAgente   = $asociadosAgentesRepositorio->obtenerPorId($asociadoAgenteId);

        }

        return $asociadoAgente;
    }
}