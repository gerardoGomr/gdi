<?php
namespace GDI\Dominio\Polizas;

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
     * AsociadoAgente constructor.
     * @param int $id
     * @param Domicilio $domicilio
     * @param null $nombre
     * @param null $paterno
     * @param null $materno
     */
    public function __construct($id = 0, Domicilio $domicilio = null, $nombre = null, $paterno = null, $materno = null)
    {
        $this->id        = $id;
        $this->domicilio = $domicilio;

        parent::__construct($nombre, $paterno, $materno);
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
}