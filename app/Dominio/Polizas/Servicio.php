<?php
namespace GDI\Dominio\Polizas;

/**
 * Class Servicio
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Servicio
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $servicio;

    /**
     * Servicio constructor.
     * @param string $servicio
     */
    public function __construct($servicio)
    {
        $this->servicio = $servicio;
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
    public function getServicio()
    {
        return $this->servicio;
    }
}