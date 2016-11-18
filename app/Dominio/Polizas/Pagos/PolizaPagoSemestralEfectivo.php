<?php
namespace GDI\Dominio\Polizas\Pagos;

use GDI\Dominio\Polizas\MedioPago;
use GDI\Exceptions\AbonoAPolizaEsMenorAAbonoMinimoEnPagoSemestralException;

/**
 * Class PolizaPagoSemestralEfectivo
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPagoSemestralEfectivo extends PolizaPago implements IPolizaPago
{
    /**
     * PolizaPagoParcialEfectivo constructor.
     * @param float $costo
     * @param float $abono
     * @param float $pago
     * @param double $minimoCosto
     */
    public function __construct($costo, $abono, $pago, $minimoCosto)
    {
        $this->costo       = $costo;
        $this->pago        = $pago;
        $this->abono       = $abono;
        $this->minimoCosto = $minimoCosto;

        parent::__construct(MedioPago::EFECTIVO);
    }

    /**
     * registrar el pago de la póliza
     */
    public function registrarPago()
    {
        // TODO: Implement registrarPago() method.
        $minimoAbono = ($this->costo * $this->minimoCosto) + ($this->costo * 0.085);

        if ($this->abono < $minimoAbono) {
            throw new AbonoAPolizaEsMenorAAbonoMinimoEnPagoSemestralException('El abono a la póliza no puede ser menor que el abono mínimo que es del 50% más un impuesto del 8.5% del valor de la póliza');
        }

        $this->cambio = $this->pago - $this->abono;
    }
}