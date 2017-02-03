<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Polizas\MedioPago;
use GDI\Dominio\Polizas\Pagos\PolizaPagoContadoTarjetaCheque;
use GDI\Dominio\Polizas\Pagos\PolizaPagoParcialEfectivoSegundoPago;

/**
 * Class PolizasPagosParcialesFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizasPagosParcialesFactory
{
    /**
     * registrar el pago de pagos parciales
     * @param int $metodoPago
     * @param double $pago
     * @param double $costoReal
     * @return PolizaPagoContadoTarjetaCheque|PolizaPagoParcialEfectivoSegundoPago|null
     */
    public static function crear($metodoPago, $pago, $costoReal)
    {
        $polizaPago = null;

        if ($metodoPago === MedioPago::EFECTIVO) {
            $polizaPago = new PolizaPagoParcialEfectivoSegundoPago($costoReal, $pago);
        }

        if ($metodoPago === MedioPago::TARJETA_CREDITO || $metodoPago === MedioPago::CHEQUE) {
            $polizaPago = new PolizaPagoContadoTarjetaCheque($metodoPago, $costoReal);
        }

        return $polizaPago;
    }
}