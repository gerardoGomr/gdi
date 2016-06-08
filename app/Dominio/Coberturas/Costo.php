<?php
namespace GDI\Dominio\Coberturas;

use GDI\Dominio\Vehiculos\Modalidad;

/**
 * Class Costo
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Costo
{
    /**
     * @var double
     */
    private $costo;

    /**
     * @var Vigencia
     */
    private $vigencia;

    /**
     * @var Modalidad
     */
    private $modalidad;

    /**
     * Costo constructor.
     * @param float $costo
     * @param Vigencia $vigencia
     * @param Modalidad $modalidad
     */
    public function __construct($costo, Vigencia $vigencia, Modalidad $modalidad)
    {
        $this->costo     = $costo;
        $this->vigencia  = $vigencia;
        $this->modalidad = $modalidad;
    }

    /**
     * @return float
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @return Vigencia
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * @return Modalidad
     */
    public function getModalidad()
    {
        return $this->modalidad;
    }
}