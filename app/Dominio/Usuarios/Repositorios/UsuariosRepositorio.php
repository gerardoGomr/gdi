<?php
namespace GDI\Dominio\Usuarios\Repositorios;

use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface UsuariosRepositorio
 * @package GDI\Dominio\Usuarios\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface UsuariosRepositorio extends Repositorio
{
    /**
     * @param string $username
     * @return Usuario|null
     */
    public function obtenerPorUsername($username);
}