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
     * buscar asociados por $dato
     * 
     * @param $dato
     * @return array
     */
    public function obtenerPor($dato);
}