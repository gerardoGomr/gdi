<?php
namespace GDI\Dominio\Polizas\Pagos;

/**
 * Class PolizaPago
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class PolizaPago
{
    /**
     * @var double
     */
    protected $costo;

    /**
     * @var double
     */
    protected $abono;

    /**
     * @var double
     */
    protected $pago;

    /**
     * @var double
     */
    protected $cambio;

    /**
     * PolizaPago constructor.
     * @param double $abono
     * @param double $pago
     * @param double $cambio
     */
    public function __construct($abono, $pago, $cambio)
    {
        $this->abono  = $abono;
        $this->pago   = $pago;
        $this->cambio = $cambio;
    }

    /**
     * @return float
     */
    public function getAbono()
    {
        return $this->abono;
    }

    /**
     * @return float
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * @return float
     */
    public function getCambio()
    {
        return $this->cambio;
    }

    public abstract function registrarPago();
}