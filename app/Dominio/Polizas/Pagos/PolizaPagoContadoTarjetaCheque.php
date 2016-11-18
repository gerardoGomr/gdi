<?php
namespace GDI\Dominio\Polizas\Pagos;

/**
 * Class PolizaPagoContadoTarjetaCheque
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPagoContadoTarjetaCheque extends PolizaPago implements IPolizaPago
{
    /**
     * PolizaPagoContadoTarjetaCheque constructor.
     * @param int $metodoPago
     * @param float $costo
     */
    public function __construct($metodoPago, $costo)
    {
        $this->costo = $costo;
        $this->abono = $costo;

        parent::__construct($metodoPago);
    }

    /**
     * registrar el pago de la póliza
     */
    public function registrarPago()
    {
        // TODO: Implement registrarPago() method.
        $this->pago   = $this->costo;
        $this->cambio = 0;
    }
}