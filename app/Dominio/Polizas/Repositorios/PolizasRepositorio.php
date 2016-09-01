<?php
namespace GDI\Dominio\Polizas\Repositorios;

use GDI\Dominio\Polizas\Poliza;
use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface PolizasRepositorio
 * @package GDI\Dominio\Polizas\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface PolizasRepositorio extends Repositorio
{
    /**
     * guardar o editar una póliza
     * @param Poliza $poliza
     * @return bool
     */
    public function persistir(Poliza $poliza);
}