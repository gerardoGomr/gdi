<?php
namespace GDI\Dominio\Coberturas\Repositorios;

use GDI\Dominio\Repositorios\Repositorio;

/**
 * Interface ResponsabilidadesRepositorio
 * @package GDI\Dominio\Coberturas\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface ResponsabilidadesRepositorio extends Repositorio
{
    /**
     * obtener responsabilidades en base al concepto id
     * @param int $coberturaConceptoId
     * @param int|null $oficiaId
     * @return array|null
     */
    public function obtenerPorCoberturaConceptoId($coberturaConceptoId, $oficiaId = null);
}