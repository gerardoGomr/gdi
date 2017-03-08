<?php
namespace GDI\Dominio\Vehiculos;

use GDI\Dominio\Listas\IColeccion;

/**
 * Class Marca
 * @package GDI\Dominio\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Marca
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $marca;

    /**
     * @var IColeccion
     */
    private $modelos;

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
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @return IColeccion
     */
    public function getModelos()
    {
        return $this->modelos;
    }
}