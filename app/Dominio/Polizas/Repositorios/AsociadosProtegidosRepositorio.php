<?php
namespace GDI\Dominio\Polizas\Repositorios;

use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface AsociadosProtegidosRepositorio
 * @package GDI\Dominio\Polizas\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface AsociadosProtegidosRepositorio extends Repositorio
{
    /**
     * @param $dato
     * @param int|null $oficinaId
     * @return array
     */
    public function obtenerPor($dato, $oficinaId = null);
}