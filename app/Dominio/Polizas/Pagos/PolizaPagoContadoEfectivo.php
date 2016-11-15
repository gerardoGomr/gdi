<?php
namespace GDI\Dominio\Polizas\Pagos;

use GDI\Exceptions\PagoEsMenorACostoEnPagoDeContadoEfectivoException;

/**
 * Class PolizaPagoContadoEfectivo
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPagoContadoEfectivo extends PolizaPago implements IPolizaPago
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