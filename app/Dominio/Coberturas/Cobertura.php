<?php
namespace GDI\Dominio\Coberturas;

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
     * @var CoberturaTipo
     */
    private $coberturaTipo;

    /**
     * @var Servicio
     */
    private $servicio;

    /**
     * @var IColeccion
     */
    private $responsabilidades;

    /**
     * Cobertura constructor.
     * @param string $nombre
     * @param CoberturaTipo $coberturaTipo
     * @param Servicio $servicio
     * @param IColeccion $responsabilidades
     * @param int $id
     */
    public function __construct($nombre = null, CoberturaTipo $coberturaTipo = null, Servicio $servicio = null, IColeccion $responsabilidades = null, $id = 0)
    {
        $this->id                = $id;
        $this->nombre            = $nombre;
        $this->coberturaTipo     = $coberturaTipo;
        $this->servicio          = $servicio;
        $this->responsabilidades = $responsabilidades;
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
     * @return CoberturaTipo
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
     * @return IColeccion
     */
    public function getResponsabilidades()
    {
        return $this->responsabilidades;
    }

    /**
     * agregar una nueva responsabilidad a la cobertura
     * @param ResponsabilidadCobertura $responsabilidad
     * @throws \Exception
     * @return void
     */
    public function agregarResponsabilidad(ResponsabilidadCobertura $responsabilidad)
    {
        if ($this->coberturaTipo == CoberturaTipo::LOCAL) {
            if ($responsabilidad->getCoberturaConcepto()->getConcepto() !== CoberturaConcepto::RC_VIAJERO) {
                throw new \Exception('No se aceptan resposabilidades diferentes a ' . CoberturaConcepto::RC_VIAJERO . ' en cobertura de tipo Local');
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