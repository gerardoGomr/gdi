<?php
namespace GDI\Dominio\Polizas\Repositorios;

use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface AsociadosProtegidosRepositorio
 * @package GDI
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface AsociadosProtegidosRepositorio extends Repositorio
{
    /**
     * @param $dato
     * @return array
     */
    public function obtenerPor($dato):array;
}