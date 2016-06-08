<?php
namespace GDI\Dominio\Vehiculos;

use GDI\Dominio\Polizas\AsociadoProtegido;

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
     * @var Marca
     */
    private $marca;

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
     * @var Modalidad
     */
    private $modalidad;

    /**
     * @var AsociadoProtegido
     */
    private $asociadoProtegido;

    /**
     * Vehiculo constructor.
     * @param Modelo $modelo
     * @param Marca $marca
     * @param int $anio
     * @param string|null $numeroSerie
     * @param string|null $numeroMotor
     * @param Modalidad $modalidad
     * @param AsociadoProtegido $asociadoProtegido
     * @param int $id
     */
    public function __construct(Modelo $modelo = null, Marca $marca = null, $anio = 0, $numeroSerie = null, $numeroMotor = null, Modalidad $modalidad = null, AsociadoProtegido $asociadoProtegido = null, $id = 0)
    {
        $this->modelo    = $modelo;
        $this->marca     = $marca;
        $this->anio      = $anio;
        $this->modalidad = $modalidad;
        $this->asociadoProtegido = $asociadoProtegido;
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
     * @return Marca
     */
    public function getMarca()
    {
        return $this->marca;
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
}