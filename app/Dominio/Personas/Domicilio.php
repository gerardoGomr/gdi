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
     * @param $numExterior
     * @param $numInterior
     * @param $colonia
     * @param string $cp
     * @param UnidadAdministrativa|null $unidadAdministrativa
     */
    public function __construct($calle, $numExterior, $numInterior, $colonia, $cp, UnidadAdministrativa $unidadAdministrativa = null)
    {
        $this->calle                = $calle;
        $this->numExterior          = $numExterior;
        $this->numInterior          = $numInterior;
        $this->colonia              = $colonia;
        $this->cp                   = $cp;
        $this->unidadAdministrativa = $unidadAdministrativa;
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

    /**
     * devuelve la dirección completa
     * @return string
     */
    public function direccionCompleta()
    {
        $direccion = $this->calle;

        if (strlen($this->numExterior)) {
            $direccion .= ' ' . $this->numExterior;
        }

        if (strlen($this->numInterior)) {
            $direccion .= ' ' . $this->numInterior;
        }

        if (strlen($this->colonia)) {
            $direccion .= ' ' . $this->colonia;
        }

        if (!is_null($this->unidadAdministrativa)) {
            $direccion .= ' ' . $this->unidadAdministrativa->getUnidad();
        }

        return $direccion;
    }
}