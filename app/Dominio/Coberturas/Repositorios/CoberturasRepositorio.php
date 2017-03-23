<?php
namespace GDI\Dominio\Coberturas\Repositorios;

use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Repositorios\Repositorio;
use GDI\Dominio\Vehiculos\Modalidad;

/**
 * Interface CoberturasRepositorio
 * @package GDI
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface CoberturasRepositorio extends Repositorio
{
    /**
     * obtener coberturas por $servicio, $coberturatipo
     *
     * @param Servicio $servicio
     * @param int $coberturaTipo
     * @return array|null
     */
    public function obtenerPorServicioCoberturaTipo(Servicio $servicio, $coberturaTipo);

    /**
     * obtener cobertura por $id
     *
     * @param int $id
     * @param Modalidad|null $modalidad
     * @return Cobertura
     */
    public function obtenerPorId($id, Modalidad $modalidad = null);
}