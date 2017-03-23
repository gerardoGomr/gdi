<?php
namespace GDI\Dominio\Oficinas\Repositorios;

use GDI\Dominio\Oficinas\CorteCaja;
use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface CortesCajaRepositorio
 *
 * @package GDI\Dominio\Oficinas\Repositorios
 * @author Gerardo Adrián Gómez Ruiz <gerardo.gomr@gmail.com>
 * @version 1.0
 */
interface CortesCajaRepositorio extends Repositorio
{
    /**
     * persistir cambios del corte de caja
     *
     * @param CorteCaja $corteCaja
     * @return bool
     */
    public function persistir(CorteCaja $corteCaja);

    /**
     * obtener cortes de caja en base a fecha
     * 
     * @param string $fechaCorte
     * @return CorteCaja|null
     */
    public function obtenerPorFecha($fechaCorte);
}