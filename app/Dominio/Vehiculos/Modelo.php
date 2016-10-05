<?php
namespace GDI\Dominio\Vehiculos;
use GDI\Dominio\Oficinas\Oficina;

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
     * @var Oficina
     */
    private $oficina;

    /**
     * Modelo constructor.
     * @param string $modelo
     * @param Marca $marca
     * @param Oficina $oficina
     */
    public function __construct($modelo = null, Marca $marca = null, Oficina $oficina = null)
    {
        $this->modelo  = $modelo;
        $this->marca   = $marca;
        $this->oficina = $oficina;
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
    public function getModelo():string
    {
        return $this->modelo;
    }

    /**
     * @return Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }
}