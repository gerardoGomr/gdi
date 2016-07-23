<?php
namespace GDI\Dominio\Oficinas;
use GDI\Dominio\Personas\Domicilio;

/**
 * Class Oficina
 * @package GDI\Dominio\Oficinas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Oficina
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
     * @var Domicilio
     */
    private $domicilio;

    /**
     * @var bool
     */
    private $activa;

    /**
     * Oficina constructor.
     * @param string $nombre
     * @param Domicilio $domicilio
     */
    public function __construct($nombre, Domicilio $domicilio)
    {
        $this->nombre    = $nombre;
        $this->domicilio = $domicilio;
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
     * @return Domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @return boolean
     */
    public function activa()
    {
        return $this->activa;
    }
}