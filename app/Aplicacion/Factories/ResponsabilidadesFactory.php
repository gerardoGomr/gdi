<?php
namespace GDI\Aplicacion\Factories;

use GDI\Aplicacion\Coleccion;
use Illuminate\Http\Request;
use GDI\Dominio\Coberturas\CoberturaConcepto;
use GDI\Dominio\Coberturas\ResponsabilidadCobertura;
use GDI\Dominio\Coberturas\Repositorios\ResponsabilidadesRepositorio;

/**
 * Class ResponsabilidadesFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ResponsabilidadesFactory
{
	/**
	 * crear una nueva responsabilidad
	 * @param Request $request
	 * @param CoberturaConcepto $coberturaConcepto
	 * @param ResponsabilidadesRepositorio $responsabilidadesRepositorio
	 * @return ResponsabilidadCobertura
	 */
	public static function crear(Request $request, CoberturaConcepto $coberturaConcepto, ResponsabilidadesRepositorio $responsabilidadesRepositorio)
	{
		$responsabilidadId     = $request->get('responsabilidadId');
		$limiteResponsabilidad = $request->get('limiteResponsabilidad');
        $cuotaExtraordinaria   = $request->get('cuotaExtraordinaria');

        if ($responsabilidadId === '-1') {
        	$responsabilidad = new ResponsabilidadCobertura($coberturaConcepto, $limiteResponsabilidad, $cuotaExtraordinaria);

        } else {
        	$responsabilidad = $responsabilidadesRepositorio->obtenerPorId((int)$responsabilidadId);
        }

        return $responsabilidad;
	}
}