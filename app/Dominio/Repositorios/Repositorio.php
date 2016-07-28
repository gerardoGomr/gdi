<?php
namespace GDI\Dominio\Repositorios;

/**
 * Interface Repositorio
 * @package GDI\Dominio\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface Repositorio
{
    /**
     * @param int|null $oficinaId
     * @return array
     */
    public function obtenerTodos($oficinaId = null);

    /**
     * @param int $id
     * @param int|null $oficinaId
     * @return mixed
     */
    public function obtenerPorId($id, $oficinaId = null);
}