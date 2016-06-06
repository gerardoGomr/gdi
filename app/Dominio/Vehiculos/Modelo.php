<?php
namespace GDI\Dominio\Vehiculos;

/**
 * Class Modelo
 * Representa por ejemplo a Tsuru GSI - Clasico GL
 * @package GDI\Dominio\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version
 */
class Modelo
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
     * Modelo constructor.
     * @param string $nombre
     * @param int $id
     */
    public function __construct($nombre = null, $id = 0)
    {
        $this->nombre = $nombre;
        $this->id     = $id;
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
}