<?php
namespace GDI\Dominio\Oficinas\Repositorios;

use DateTime;
use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface OficinasRepositorio
 * @package GDI\Dominio\Oficinas\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface OficinasRepositorio extends Repositorio
{
    /**
     * obtener una lista de oficinas, asociados agentes asignados y las pólizas de estos en
     * base a la fecha de la quicena
     *
     * @param DateTime $fechaInicial
     * @param DateTime $fechaFinal
     * @return array
     */
    public function obtenerOficinasConAsociadosYPolizasDeLaQuincena(DateTime $fechaInicial, DateTime $fechaFinal);
}