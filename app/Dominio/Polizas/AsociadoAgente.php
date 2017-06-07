<?php
namespace GDI\Dominio\Polizas;

use GDI\Dominio\Listas\IColeccion;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Domicilio;
use GDI\Dominio\Personas\Persona;

/**
 * Class AsociadoAgente
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class AsociadoAgente extends Persona
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $rfc;

    /**
     * @var float
     */
    private $porcentajeComision;

    /**
     * @var bool
     */
    private $reciboHonorarios;

    /**
     * @var Domicilio
     */
    private $domicilio;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * @var IColeccion
     */
    private $polizas;

    /**
     * AsociadoAgente constructor.
     * @param string $rfc
     * @param string $telefono
     * @param $celular
     * @param $email
     */
    public function __construct($rfc, $telefono, $celular, $email)
    {
        $this->rfc       = $rfc;
        $this->telefono  = $telefono;
        $this->celular   = $celular;
        $this->email     = $email;
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
     * @return float
     */
    public function getPorcentajeComision()
    {
        return $this->porcentajeComision;
    }

    /**
     * @return boolean
     */
    public function reciboHonorarios()
    {
        return $this->reciboHonorarios;
    }

    /**
     * @return Domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * complementar la creación de un agente
     * @param $nombreAgente
     * @param $paternoAgente
     * @param $maternoAgente
     * @param Domicilio $domicilio
     * @param Oficina $oficina
     */
    public function generar($nombreAgente, $paternoAgente, $maternoAgente, Domicilio $domicilio, Oficina $oficina)
    {
        $this->nombre    = $nombreAgente;
        $this->paterno   = $paternoAgente;
        $this->materno   = $maternoAgente;
        $this->domicilio = $domicilio;
        $this->oficina   = $oficina;
    }
}