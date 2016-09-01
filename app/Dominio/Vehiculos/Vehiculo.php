<?php
namespace GDI\Dominio\Vehiculos;

use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Polizas\AsociadoProtegido;
use GDI\Dominio\Polizas\Servicio;

/**
 * Class Vehiculo
 * Ejemplo: Nissan - Tsuru GSI - 2016 - Taxi
 * @package GDI\Dominio\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Vehiculo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Modelo
     */
    private $modelo;

    /**
     * @var int
     */
    private $anio;

    /**
     * @var string
     */
    private $numeroSerie;

    /**
     * @var string
     */
    private $numeroMotor;

    /**
     * @var string
     */
    private $placas;

    /**
     * @var int
     */
    private $capacidad;

    /**
     * @var Modalidad
     */
    private $modalidad;

    /**
     * @var Servicio
     */
    private $servicio;

    /**
     * @var AsociadoProtegido
     */
    private $asociadoProtegido;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * Vehiculo constructor.
     * @param Modelo $modelo
     * @param int $anio
     * @param int|null $capacidad
     * @param string|null $numeroSerie
     * @param string|null $numeroMotor
     * @param string|null $placas
     * @param Modalidad $modalidad
     * @param Servicio $servicio
     * @param AsociadoProtegido $asociadoProtegido
     * @param Oficina $oficina
     */
    public function __construct(Modelo $modelo = null, $anio = 0, $capacidad = null, $numeroSerie = null, $numeroMotor = null, $placas = null, Modalidad $modalidad = null, Servicio $servicio, AsociadoProtegido $asociadoProtegido = null, Oficina $oficina)
    {
        $this->modelo            = $modelo;
        $this->anio              = $anio;
        $this->capacidad         = $capacidad;
        $this->modalidad         = $modalidad;
        $this->servicio          = $servicio;
        $this->asociadoProtegido = $asociadoProtegido;
        $this->oficina           = $oficina;
        $this->numeroSerie       = $numeroSerie;
        $this->numeroMotor       = $numeroMotor;
        $this->placas            = $placas;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Modelo
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @return int
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @return Modalidad
     */
    public function getModalidad()
    {
        return $this->modalidad;
    }

    /**
     * @return AsociadoProtegido
     */
    public function getAsociadoProtegido()
    {
        return $this->asociadoProtegido;
    }

    /**
     * @return string
     */
    public function getNumeroSerie()
    {
        return $this->numeroSerie;
    }

    /**
     * @return string
     */
    public function getNumeroMotor()
    {
        return $this->numeroMotor;
    }

    /**
     * @return int
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * @return Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }

    /**
     * @return string
     */
    public function detalles()
    {
        return $this->modelo->getMarca()->getMarca() . ' ' .$this->anio;
    }
}