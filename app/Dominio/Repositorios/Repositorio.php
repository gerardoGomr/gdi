<?php
namespace GDI\Dominio\Repositorios;
use GDI\Dominio\Oficinas\Oficina;

/**
 * Interface Repositorio
 *
 * @package GDI\Dominio\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface Repositorio
{
    /**
     * @return array
     */
    public function obtenerTodos();

    /**
     * @param int $id
     * @return mixed
     */
    public function obtenerPorId($id);
}