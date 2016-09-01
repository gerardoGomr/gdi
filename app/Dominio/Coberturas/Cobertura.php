<?php
namespace GDI\Dominio\Coberturas;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Listas\IColeccion;

/**
 * Class Cobertura
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Cobertura
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var int
     */
    private $coberturaTipo;

    /**
     * @var Servicio
     */
    private $servicio;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * @var IColeccion
     */
    private $costos;

    /**
     * @var IColeccion
     */
    private $responsabilidades;

    /**
     * Cobertura constructor.
     * @param string $nombre
     * @param int $coberturaTipo
     * @param Servicio $servicio
     * @param IColeccion $responsabilidades
     * @param IColeccion $costos
     * @param int $id
     */
    public function __construct($nombre = null, $coberturaTipo = null, Servicio $servicio = null, IColeccion $responsabilidades = null, IColeccion $costos, $id = 0)
    {
        $this->id                = $id;
        $this->nombre            = $nombre;
        $this->coberturaTipo     = $coberturaTipo;
        $this->servicio          = $servicio;
        $this->responsabilidades = $responsabilidades;
        $this->costos            = $costos;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return int
     */
    public function getCoberturaTipo()
    {
        return $this->coberturaTipo;
    }

    /**
     * @return Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * @return IColeccion
     */
    public function getCostos()
    {
        return $this->costos;
    }

    /**
     * @return IColeccion
     */
    public function getResponsabilidades()
    {
        return $this->responsabilidades;
    }

    /**
     * agregar una nueva responsabilidad a la cobertura
     * @throws \Exception
     * @return void
     */
    public function verificarResponsabilidad()
    {
        foreach ($this->responsabilidades as $responsabilidad) {
            if ($this->coberturaTipo == CoberturaTipo::LOCAL) {
                if ($responsabilidad->getCoberturaConcepto() == CoberturaConcepto::RC_VIAJERO) {

                }
            }
        }


        if ($this->coberturaTipo == CoberturaTipo::BASICA) {
            if ($responsabilidad->getCoberturaConcepto()->getConcepto() == CoberturaConcepto::DANIOS_MATERIALES || $responsabilidad->getCoberturaConcepto()->getConcepto() == CoberturaConcepto::ROBO_TOTAL) {
                throw new \Exception('No se aceptan resposabilidades iguales ' . CoberturaConcepto::DANIOS_MATERIALES . ' o ' . CoberturaConcepto::ROBO_TOTAL . ' en cobertura de tipo Básica');
            }   
        }

        $this->responsabilidades->add($responsabilidad);
    }
}