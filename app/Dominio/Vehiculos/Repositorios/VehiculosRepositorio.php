<?php
namespace GDI\Dominio\Vehiculos\Repositorios;

use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface VehiculosRepositorio
 * @package GDI\Dominio\Vehiculos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface VehiculosRepositorio extends Repositorio
{
    /**
     * obtener una lista de vehiculos en base al dato
     * @param string $dato
     * @param int $oficinaId
     * @return array
     */
    public function obtenerPor($dato, $oficinaId);
}