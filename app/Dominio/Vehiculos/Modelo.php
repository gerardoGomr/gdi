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
    private $modelo;

    /**
     * @var Marca
     */
    private $marca;

    /**
     * Modelo constructor.
     * @param string $modelo
     * @param int $id
     */
    public function __construct($modelo = null, $id = 0)
    {
        $this->modelo = $modelo;
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
     * @return Modelo
     */
    public function getModelo():Modelo
    {
        return $this->modelo;
    }

    /**
     * @return Marca
     */
    public function getMarca():Marca
    {
        return $this->marca;
    }
}