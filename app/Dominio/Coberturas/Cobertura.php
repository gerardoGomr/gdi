<?php
namespace GDI\Dominio\Coberturas;

use GDI\Dominio\Polizas\Servicio;

/**
 * Class Cobertura
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Cobertura
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var CoberturaTipo
     */
    private $coberturaTipo;

    /**
     * @var Servicio
     */
    private $servicio;

    /**
     * Cobertura constructor.
     * @param string $nombre
     * @param CoberturaTipo $coberturaTipo
     * @param Servicio $servicio
     * @param int $id
     */
    public function __construct($nombre = null, CoberturaTipo $coberturaTipo = null, Servicio $servicio = null, $id = 0)
    {
        $this->id            = $id;
        $this->nombre        = $nombre;
        $this->coberturaTipo = $coberturaTipo;
        $this->servicio      = $servicio;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return CoberturaTipo
     */
    public function getCoberturaTipo()
    {
        return $this->coberturaTipo;
    }

    /**
     * @return Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }
}