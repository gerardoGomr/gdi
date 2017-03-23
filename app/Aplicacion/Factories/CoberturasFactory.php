<?php
namespace GDI\Aplicacion\Factories;

use GDI\Aplicacion\Coleccion;
use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Coberturas\ResponsabilidadCobertura;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Vehiculos\Modalidad;
use Illuminate\Http\Request;

/**
 * Class CoberturasFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CoberturasFactory
{
    /**
     * crear una nueva instancia de Cobertura
     * @param Request $request
     * @param Servicio $servicio
     * @param Modalidad $modalidad
     * @param Oficina $oficina
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CostosRepositorio $costosRepositorio
     * @return Cobertura
     */
    public static function crear(Request $request, Servicio $servicio, Modalidad $modalidad, Oficina $oficina, CoberturasRepositorio $coberturasRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio, CostosRepositorio $costosRepositorio)
    {
        if ($request->get('cobertura') === '-1') {
            // es un nuevo modelo, crear
            // obtener responsabilidades
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

            $vigencia = VigenciasFactory::crear($request, $vigenciasRepositorio);
            $costo    = CostosFactory::crear($request, $vigencia, $modalidad, $costosRepositorio);

            $costos->add($costo);

            $cobertura = new Cobertura($request->get('nombreCobertura'), (int)$request->get('coberturaTipo'), $servicio, $oficina, $responsabilidades, $costos);

        } else {
            // leer del repositorio
            $coberturaId = (int)$request->get('servicio');
            $cobertura   = $coberturasRepositorio->obtenerPorId($coberturaId);
        }

        return $cobertura;
    }
}