<?php
namespace GDI\Dominio\Polizas\Pagos;

use GDI\Dominio\Polizas\MedioPago;
use GDI\Exceptions\AbonoAPolizaEsMenorAAbonoMinimoEnPagoParcialException;
use GDI\Exceptions\PagoEsMenorACostoEnPagoDeContadoEfectivoException;

/**
 * Class PolizaPagoParcialEfectivoSegundoPago
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPagoParcialEfectivoSegundoPago extends PolizaPago implements IPolizaPago
{
    /**
     * PolizaPagoParcialEfectivo PolizaPagoParcialEfectivoSegundoPago.
     * @param float $costo
     * @param float $pago
     * @throws PagoEsMenorACostoEnPagoDeContadoEfectivoException
     */
    public function __construct($costo, $pago)
    {
        if ($pago < $costo) {
            throw new PagoEsMenorACostoEnPagoDeContadoEfectivoException('El pago de la póliza no puede ser menor al costo de $' . number_format($this->costo, 2));
        }

        $this->costo = $costo;
        $this->pago  = $pago;

        parent::__construct(MedioPago::EFECTIVO);
    }

    /**
     * registrar el pago de la póliza
     */
    public function registrarPago()
    {
        // TODO: Implement registrarPago() method.
        $this->abono  = $this->costo;
        $this->cambio = $this->pago - $this->costo;
    }
}