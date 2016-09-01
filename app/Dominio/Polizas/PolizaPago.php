<?php
namespace GDI\Dominio\Polizas;

/**
 * Class PolizaPago
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPago
{
    /**
     * @var double
     */
    private $pago;

    /**
     * @var double
     */
    private $cambio;

    /**
     * PolizaPago constructor.
     * @param double $pago
     * @param double $cambio
     */
    public function __construct($pago, $cambio)
    {
        $this->pago   = $pago;
        $this->cambio = $cambio;
    }

    /**
     * comprobar que el cambio esté bien calculado
     * @param $costo
     */
    public function calcularCambio($costo)
    {
        $cambio = $costo - $this->pago;

        if ($cambio !== $this->cambio) {
            $this->cambio = $cambio;
        }
    }
}