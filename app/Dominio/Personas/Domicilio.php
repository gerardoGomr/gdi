<?php
namespace GDI\Dominio\Personas;

/**
 * Class Domicilio
 * @package GDI\Dominio\Personas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Domicilio
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $numExterior;

    /**
     * @var string
     */
    private $numInterior;

    /**
     * @var string
     */
    private $colonia;

    /**
     * @var string
     */
    private $cp;

    /**
     * @var UnidadAdministrativa
     */
    private $unidadAdministrativa;

    /**
     * Domicilio constructor.
     * @param string $calle
     * @param string $cp
     * @param string $municipio
     * @param int|null $id
     */
    public function __construct($calle, $cp, $municipio, $id = null)
    {
        $this->id        = $id;
        $this->calle = $calle;
        $this->cp        = $cp;
        $this->municipio = $municipio;
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
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * @return string
     */
    public function getNumExterior()
    {
        return $this->numExterior;
    }

    /**
     * @return string
     */
    public function getNumInterior()
    {
        return $this->numInterior;
    }

    /**
     * @return string
     */
    public function getColonia()
    {
        return $this->colonia;
    }

    /**
     * @return UnidadAdministrativa
     */
    public function getUnidadAdministrativa()
    {
        return $this->unidadAdministrativa;
    }
}