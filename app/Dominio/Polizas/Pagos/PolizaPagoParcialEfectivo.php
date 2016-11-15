<?php
namespace GDI\Dominio\Polizas\Pagos;

use GDI\Exceptions\AbonoAPolizaEsMenorAAbonoMinimoEnPagoParcialException;

/**
 * Class PolizaPagoParcialEfectivo
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPagoParcialEfectivo extends PolizaPago
{
    /**
     * @var double
     */
    private $minimoCosto;

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
    }

    /**
     * registrar el pago de la póliza
     */
    public function registrarPago()
    {
        // TODO: Implement registrarPago() method.
        $minimoAbono = $this->costo * $this->minimoCosto;

        if ($this->abono < $minimoAbono) {
            throw new AbonoAPolizaEsMenorAAbonoMinimoEnPagoParcialException('El abono a la póliza no puede ser menor que el abono mínimo que es del 50% del valor de la póliza');
        }

        $this->cambio = $this->pago - $this->abono;
    }
}