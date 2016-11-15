<?php
namespace GDI\Dominio\Polizas\Pagos;

use GDI\Exceptions\PagoEsMenorACostoEnPagoDeContadoEfectivoException;

class PolizaPagoContadoEfectivo extends PolizaPago
{
    /**
     * PolizaPagoContadoEfectivo constructor.
     * @param float $costo
     * @param float $pago
     * @throws PagoEsMenorACostoEnPagoDeContadoEfectivoException
     */
    public function __construct($costo, $pago)
    {
        if ($pago < $costo) {
            throw new PagoEsMenorACostoEnPagoDeContadoEfectivoException('El pago de la póliza no puede ser menor al costo de la misma.');    
        }
        
        $this->costo = $costo;
        $this->pago  = $pago;
    }

    /**
     * registrar el pago de la póliza
     */
    public function registrarPago()
    {
        // TODO: Implement registrarPago() method.
        $this->abono  = $this->pago;
        $this->cambio = $this->pago - $this->costo;
    }
}