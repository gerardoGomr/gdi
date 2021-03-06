<?php
namespace GDI\Dominio\Polizas;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Persona;
use GDI\Dominio\Personas\TipoPersona;
use GDI\Dominio\Personas\Domicilio;
use InvalidArgumentException;

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
     * @var int
     */
    private $tipoPersona;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * AsociadoProtegido constructor.
     * @param string $rfc
     * @param int|string $tipoPersona
     * @param string $telefono
     * @param string $celular
     * @param string $email
     */
    public function __construct($rfc = null, $tipoPersona = TipoPersona::PERSONA_FISICA, $telefono, $celular, $email)
    {
        if ($tipoPersona !== TipoPersona::PERSONA_FISICA && $tipoPersona !== TipoPersona::PERSONA_MORAL) {
            throw new InvalidArgumentException('DEBE ESPECIFICAR QUE SEA PERSONA FÍSICA O PERSONA MORAL.');
        }

        $this->rfc         = $rfc;
        $this->tipoPersona = $tipoPersona;
        $this->telefono    = $telefono;
        $this->celular     = $celular;
        $this->email       = $email;

        parent::__construct();
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
     * @return int
     */
    public function getTipoPersona()
    {
        return $this->tipoPersona;
    }

    /**
     * @return string
     */
    public function getRazonSocial()
    {
        return $this->razonSocial;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * verifica si es persona física
     * @return bool
     */
    public function esPersonaFisica()
    {
        return $this->tipoPersona === TipoPersona::PERSONA_FISICA;
    }

    /**
     * verifica si es persona moral
     * @return bool
     */
    public function esPersonaMoral()
    {
        return $this->tipoPersona === TipoPersona::PERSONA_MORAL;
    }

    /**
     * override parent´s behaviour
     * @return null|string
     */
    public function nombreCompleto()
    {
        // TODO: Change the autogenerated stub
        if ($this->tipoPersona === TipoPersona::PERSONA_FISICA) {
            return parent::nombreCompleto();
        } else {
            return $this->razonSocial;
        }
    }

    /**
     * generar datos del asociado dependiendo del tipo de persona
     * @param string $nombre
     * @param string $paterno
     * @param string $materno
     * @param string $razonSocial
     * @param Domicilio $domicilio
     * @param Oficina $oficina
     */
    public function generar($nombre, $paterno, $materno, $razonSocial, Domicilio $domicilio, Oficina $oficina)
    {
        $this->domicilio = $domicilio;
        $this->oficina   = $oficina;

        if ($this->tipoPersona === TipoPersona::PERSONA_FISICA) {
            $this->nombre  = $nombre;
            $this->paterno = $paterno;
            $this->materno = $materno;
        }

        if ($this->tipoPersona === TipoPersona::PERSONA_MORAL) {
            $this->razonSocial = $razonSocial;
        }
    }

    /**
     * actualizar datos
     * @param string $nombre
     * @param string $paterno
     * @param string $materno
     * @param string $razonSocial
     * @param Domicilio $domicilio
     * @param Oficina $oficina
     * @param string $rfc
     * @param string $tipoPersona
     * @param string $telefono
     * @param string $celular
     * @param string $email
     */
    public function actualizar($nombre, $paterno, $materno, $razonSocial, Domicilio $domicilio, Oficina $oficina, $rfc, $tipoPersona, $telefono, $celular, $email)
    {
        $this->generar($nombre, $paterno, $materno, $razonSocial, $domicilio, $oficina);

        if ($tipoPersona !== TipoPersona::PERSONA_FISICA && $tipoPersona !== TipoPersona::PERSONA_MORAL) {
            throw new InvalidArgumentException('DEBE ESPECIFICAR QUE SEA PERSONA FÍSICA O PERSONA MORAL.');
        }

        $this->rfc         = $rfc;
        $this->tipoPersona = $tipoPersona;
        $this->telefono    = $telefono;
        $this->celular     = $celular;
        $this->email       = $email;
    }
}