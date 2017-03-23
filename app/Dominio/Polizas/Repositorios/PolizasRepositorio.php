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
     * obtener lista de pólizas en base al dato de búsqueda
     *
     * @param string $dato
     * @return array|null
     */
    public function obtenerPorVehiculo($dato);

    /**
     * obtener polizas en base a los parámetros de búsqueda
     *
     * @param array $parametros
     * @return array|null
     */
    public function obtenerPor(array $parametros);

    /**
     * guardar o editar una póliza
     * @param Poliza $poliza
     * @return bool
     */
    public function persistir(Poliza $poliza);
}