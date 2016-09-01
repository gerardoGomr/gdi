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
     * @param Servicio $servicio
     * @param int $coberturaTipo
     * @param int $oficinaId
     * @return array|null
     */
    public function obtenerPorServicioCoberturaTipo(Servicio $servicio, $coberturaTipo, $oficinaId);

    /**
     * @param int $id
     * @param int|null $oficinaId
     * @param Modalidad|null $modalidad
     * @return Cobertura
     */
    public function obtenerPorId($id, $oficinaId = null, Modalidad $modalidad = null);
}