<?php

namespace GDI\Dominio\Polizas;


class Poliza
{
    /**
     * @var int
     */
    private $id;

    private $asociadoAgente;

    private $vehiculo;

    private $cobertura;

    private $fechaRegistro;

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
}