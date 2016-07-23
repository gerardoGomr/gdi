<?php
namespace GDI\Dominio\Personas;

/**
 * Class UnidadAdministrativa
 * @package GDI\Dominio\Personas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class UnidadAdministrativa
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $unidad;

    /**
     * @var UnidadAdministrativa
     */
    private $unidadPadre;

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
    public function getUnidad()
    {
        return $this->unidad;
    }

    /**
     * @return UnidadAdministrativa
     */
    public function getUnidadPadre()
    {
        return $this->unidadPadre;
    }
}