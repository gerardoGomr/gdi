<?php
namespace GDI\Dominio\Coberturas;

use Exception;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\Servicio;
use GDI\Dominio\Listas\IColeccion;
use GDI\Exceptions\ResponsabilidadNoexisteEnCoberturaException;

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
     * @param Oficina $oficina
     * @param IColeccion $responsabilidades
     * @param IColeccion $costos
     * @param int $id
     */
    public function __construct($nombre = null, $coberturaTipo = null, Servicio $servicio = null, Oficina $oficina, IColeccion $responsabilidades = null, IColeccion $costos, $id = 0)
    {
        $this->id                = $id;
        $this->nombre            = $nombre;
        $this->coberturaTipo     = $coberturaTipo;
        $this->servicio          = $servicio;
        $this->oficina           = $oficina;
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
                throw new Exception('No se aceptan resposabilidades iguales ' . CoberturaConcepto::DANIOS_MATERIALES . ' o ' . CoberturaConcepto::ROBO_TOTAL . ' en cobertura de tipo Básica');
            }   
        }

        $this->responsabilidades->add($responsabilidad);
    }

    /**
     * se agrega un nuevo costo a la cobertura
     * @param Costo $costo
     */
    public function agregarNuevoCosto(Costo $costo)
    {
        $this->costos->add($costo);
    }

    /**
     * verifica la cobertura tipo y devuelve su representación en texto
     * @return string
     */
    public function coberturaTipo()
    {
        $coberturaTipo = '';

        switch ($this->coberturaTipo) {
            case  CoberturaTipo::LOCAL:
                $coberturaTipo = 'LOCAL';
                break;

            case  CoberturaTipo::BASICA:
                $coberturaTipo = 'BÁSICA';
                break;

            case  CoberturaTipo::AMPLIA:
                $coberturaTipo = 'AMPLIA';
                break;
        }

        return $coberturaTipo;
    }

    /**
     * verifica si es cobertura local
     * @return bool
     */
    public function esCoberturaLocal()
    {
        return $this->coberturaTipo === CoberturaTipo::LOCAL;
    }

    /**
     * verifica si es cobertura básica
     * @return bool
     */
    public function esCoberturaBasica()
    {
        return $this->coberturaTipo === CoberturaTipo::BASICA;
    }

    /**
     * verifica si es cobertura amplia
     * @return bool
     */
    public function esCoberturaAmplia()
    {
        return $this->coberturaTipo === CoberturaTipo::AMPLIA;
    }

    /**
     * describe el detalle de la cobertura contratada
     */
    public function detalles()
    {
        return $this->coberturaTipo() . ' - ' . $this->getNombre();
    }

    /**
     * verifica si la cobertura tiene responsabilidades
     * @return bool
     */
    public function tieneResponsabilidades()
    {
        return $this->responsabilidades->count() > 0;
    }

    /**
     * recorre las responsabilidades asignadas y si encuentra la especificada, devuelve true
     * @param ResponsabilidadCobertura $responsabilidad
     * @return bool
     */
    public function existeResponsabilidad(ResponsabilidadCobertura $responsabilidad)
    {
        if ($this->tieneResponsabilidades()) {
            foreach ($this->responsabilidades as $responsabilidades) {
                if ($responsabilidades->getId() === $responsabilidad->getId()) {
                    return true;
                }

                if ($responsabilidades->getCoberturaConcepto()->getId() === $responsabilidad->getCoberturaConcepto()->getId()) {
                    return true;
                }
            }

            return false;
        }

        return false;
    }

    /**
     * agregar una responsabilidad a la cobertura
     * @param ResponsabilidadCobertura $responsabilidad
     */
    public function agregarResponsabilidad(ResponsabilidadCobertura $responsabilidad)
    {
        $this->responsabilidades->add($responsabilidad);
    }

    /**
     * eliminar la responsabilidad de la cobertura
     * @param ResponsabilidadCobertura $responsabilidad
     * @throws ResponsabilidadNoexisteEnCoberturaException
     */
    public function eliminarResponsabilidad(ResponsabilidadCobertura $responsabilidad)
    {
        if (!$this->existeResponsabilidad($responsabilidad)) {
            throw new ResponsabilidadNoexisteEnCoberturaException('LA RESPONSABILIDAD QUE SE INTENTA ELIMINAR NO ESTÁ ASIGNADA A LA COBERTURA.');
        }

        $this->responsabilidades->removeElement($responsabilidad);
    }
}