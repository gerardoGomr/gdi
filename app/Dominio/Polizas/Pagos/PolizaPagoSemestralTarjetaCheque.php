<?php
namespace GDI\Dominio\Polizas\Pagos;

use GDI\Exceptions\AbonoAPolizaEsMenorAAbonoMinimoEnPagoParcialException;
use GDI\Exceptions\AbonoAPolizaEsMenorAAbonoMinimoEnPagoSemestralException;

/**
 * Class PolizaPagoSemestralTarjetaCheque
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPagoSemestralTarjetaCheque extends PolizaPago implements IPolizaPago
{
    /**
     * PolizaPagoParcialTarjetaCheque constructor.
     * @param int $metodoPago
     * @param float $costo
     * @param float $abono
     * @param float $minimoCosto
     */
    public function __construct($metodoPago, $costo, $abono, $minimoCosto)
    {
        $this->costo       = $costo;
        $this->abono       = $abono;
        $this->minimoCosto = $minimoCosto;

        parent::__construct($metodoPago);
    }

    /**
     * registrar el pago de la póliza
     */
    public function registrarPago()
    {
        // TODO: Implement registrarPago() method.
        $minimoAbono = ($this->costo * $this->minimoCosto) + ($this->costo * 0.085);

        if ($this->abono < $minimoAbono) {
            throw new AbonoAPolizaEsMenorAAbonoMinimoEnPagoSemestralException('El abono a la póliza no puede ser menor que el abono mínimo que es del 50% mas un impuesto del 8.5% del valor de la póliza');
        }

        $this->pago   = $this->abono;
        $this->cambio = 0;
    }
}