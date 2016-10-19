<?php
namespace GDI\Aplicacion\Factories;

use GDI\Aplicacion\Coleccion;
use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio;
use GDI\Dominio\Coberturas\ResponsabilidadCobertura;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\AsociadoAgente;
use GDI\Dominio\Polizas\Poliza;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Vehiculos\Modalidad;
use GDI\Dominio\Vehiculos\Vehiculo;
use Illuminate\Http\Request;

/**
 * Class PolizasFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizasFactory
{
    /**
     * Se crea un nuevo objeto poliza dependiendo de la cobertura seleccionada por el cliente
     *
     * @param Request $request
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CostosRepositorio $costosRepositorio
     * @param Modalidad $modalidad
     * @param Servicio $servicio
     * @param Oficina $oficina
     * @param Vehiculo $vehiculo
     * @param AsociadoAgente $asociadoAgente
     * @return Poliza
     */
    public static function crear(Request $request, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, CoberturasRepositorio $coberturasRepositorio, VigenciasRepositorio $vigenciasRepositorio, CostosRepositorio $costosRepositorio, Modalidad $modalidad, Servicio $servicio, Oficina $oficina, Vehiculo $vehiculo, AsociadoAgente $asociadoAgente)
    {
        if ($request->get('cobertura') === '-1') {
            $vigencia = VigenciasFactory::crear($request, $vigenciasRepositorio);
            $costo    = CostosFactory::crear($request, $vigencia, $modalidad, $costosRepositorio);

            $responsabilidades = new Coleccion();
            $costos            = new Coleccion();

            foreach ($request->get('concepto') as $indice => $valor) {
                $conceptoId            = (int)$request->get('concepto')[$indice];
                $concepto              = $coberturasConceptosRepositorio->obtenerPorId($conceptoId);
                $limiteResponsabilidad = $request->get('limResponsabilidad')[$indice];
                $cuotaExtraordinaria   = $request->get('cuotaExtraordinaria')[$indice];

                $responsabilidadCobertura = new ResponsabilidadCobertura($concepto, $limiteResponsabilidad, $cuotaExtraordinaria);
                $responsabilidades->add($responsabilidadCobertura);
            }

            $costos->add($costo);
            $cobertura = new Cobertura($request->get('nombreCobertura'), (int)$request->get('coberturaTipo'), $servicio, $oficina, $responsabilidades, $costos);
        
        } else {
            $coberturaId = (int)$request->get('servicio');
            $cobertura   = $coberturasRepositorio->obtenerPorId($coberturaId);

            $costo = $costosRepositorio->obtenerPorId((int)$request->get('vigenciaCobertura'));
        }

        $poliza = new Poliza($vehiculo, $asociadoAgente, $cobertura, $costo, $oficina);

        return $poliza;
    }
}