<?php
namespace GDI\Dominio\Polizas;

use GDI\Dominio\Personas\Persona;
use GDI\Dominio\Personas\TipoPersona;

/**
 * Class AsociadoProtegido
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class AsociadoProtegido extends Persona
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $razonSocial;

    /**
     * @var string
     */
    private $rfc;

    /**
     * @var Domicilio
     */
    private $domicilio;

    /**
     * @var TipoPersona
     */
    private $tipoPersona;

    /**
     * AsociadoProtegido constructor.
     * @param int $id
     * @param null $razonSocial
     * @param string $rfc
     * @param Domicilio $domicilio
     * @param TipoPersona $tipoPersona
     */
    public function __construct($id = 0, $razonSocial = null, $rfc = null, Domicilio $domicilio = null, TipoPersona $tipoPersona = TipoPersona::PERSONA_FISICA)
    {
        $this->id          = $id;
        $this->razonSocial = $razonSocial;
        $this->rfc         = $rfc;
        $this->domicilio   = $domicilio;
        $this->tipoPersona = $tipoPersona;
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
    public function getRfc()
    {
        return $this->rfc;
    }

    /**
     * @return Domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @return TipoPersona
     */
    public function getTipoPersona()
    {
        return $this->tipoPersona;
    }

    /**
     * override parent´s behaviour
     * @return null|string
     */
    public function nombreCompleto()
    {
        if ($this->tipoPersona == TipoPersona::PERSONA_FISICA) {
            return parent::nombreCompleto(); // TODO: Change the autogenerated stub
        } else {
            return $this->razonSocial;
        }
    }
}