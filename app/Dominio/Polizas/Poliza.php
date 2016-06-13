<?php

namespace GDI\Dominio\Polizas;

/**
 * Class Poliza
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Poliza
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var AsociadoAgente
     */
    private $asociadoAgente;

    /**
     * @var Vehiculo
     */
    private $vehiculo;

    /**
     * @var Cobertura
     */
    private $cobertura;

    /**
     * @var DateTime
     */
    private $fechaRegistro;

    /**
     * @var DateTime
     */
    private $fechaInicioVigencia;

    /**
     * @var MedioPago
     */
    private $medioPago;

    /**
     * @var FormaPago
     */
    private $formaPago;

    /**
     * @var bool
     */
    private $estaPagada;    

    /**
     * Class Poliza Constructor
     * @param Vehiculo $vehiculo
     * @param Persona $asociadoAgente
     * @param Cobertura $cobertura
     * @param DateTime $fechaInicioVigencia
     */
    public function __construct(Vehiculo $vehiculo, Persona $asociadoAgente, Cobertura $cobertura, DateTime $fechaInicioVigencia)
    {
        $this->vehiculo            = $vehiculo;
        $this->asociadoAgente      = $asociadoAgente;
        $this->cobertura           = $cobertura;
        $this->fechaInicioVigencia = $fechaInicioVigencia;
    }

    /**
     * @return MedioPago
     */
    public function getMedioPago()
    {
        return $this->medioPago;
    }

    /**
     * @return FormaPago
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * @return bool
     */
    public function estaPagada()
    {
        return $this->estaPagada;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return AsociadoAgente
     */
    public function getAsociadoAgente()
    {
        return $this->asociadoAgente;
    }

    /**
     * @return Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * @return Cobertura
     */
    public function getCobertura()
    {
        return $this->cobertura;
    }

    /**
     * @return DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * @return DateTime
     */
    public function getFechaInicioVigencia()
    {
        return $this->fechaInicioVigencia;
    }

    /**
     * @return bool
     */
    public function getEstaPagada()
    {
        return $this->estaPagada;
    }
}