<?php
namespace GDI\Dominio\Vehiculos;
use GDI\Dominio\Oficinas\Oficina;

/**
 * Class Modalidad
 * @package GDI\Dominio\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Modalidad
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $modalidad;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * Modalidad constructor.
     *
     * @param string $modalidad
     * @param Oficina $oficina
     */
    public function __construct($modalidad, Oficina $oficina)
    {
        $this->modalidad = $modalidad;
        $this->oficina   = $oficina;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getModalidad()
    {
        return $this->modalidad;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }
}