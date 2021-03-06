<?php
namespace GDI\Aplicacion\Factories;

use GDI\Dominio\Polizas\FormaPago;
use GDI\Dominio\Polizas\MedioPago;
use GDI\Dominio\Polizas\Pagos\PolizaPagoContadoEfectivo;
use GDI\Dominio\Polizas\Pagos\PolizaPagoContadoTarjetaCheque;
use GDI\Dominio\Polizas\Pagos\PolizaPagoParcialEfectivo;
use GDI\Dominio\Polizas\Pagos\PolizaPagoParcialTarjetaCheque;
use GDI\Dominio\Polizas\Pagos\PolizaPagoSemestralEfectivo;
use GDI\Dominio\Polizas\Pagos\PolizaPagoSemestralTarjetaCheque;

/**
 * Class PolizasPagosFactory
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizasPagosFactory
{
    /**
     * crea una nueva instancia del pago de la póliza dependiendo de la forma de pago y del método de pago
     * @param int $formaPago
     * @param int $metodoPago
     * @param double $abono
     * @param double $pago
     * @param double $costoReal
     * @return PolizaPagoParcialTarjetaCheque|PolizaPagoContadoEfectivo|PolizaPagoContadoTarjetaCheque|PolizaPagoParcialEfectivo|null
     */
    public static function crear($formaPago, $metodoPago, $abono, $pago, $costoReal)
    {
        $polizaPago = null;
        
        if ($formaPago === FormaPago::CONTADO) {
            if ($metodoPago === MedioPago::EFECTIVO) {
                $polizaPago = new PolizaPagoContadoEfectivo($costoReal, $pago);
            }

            if ($metodoPago === MedioPago::TARJETA_CREDITO || $metodoPago === MedioPago::CHEQUE) {
                $polizaPago = new PolizaPagoContadoTarjetaCheque($metodoPago, $costoReal);
            }
        }

        if ($formaPago === FormaPago::PARCIAL) {
            if ($metodoPago === MedioPago::EFECTIVO) {
                $polizaPago = new PolizaPagoParcialEfectivo($costoReal, $abono, $pago, $minimoCosto = 0.5);
            }

            if ($metodoPago === MedioPago::TARJETA_CREDITO || $metodoPago === MedioPago::CHEQUE) {
                $polizaPago = new PolizaPagoParcialTarjetaCheque($metodoPago, $costoReal, $abono, $minimoCosto = 0.5);
            }
        }

        if ($formaPago === FormaPago::SEMESTRAL) {
            if ($metodoPago === MedioPago::EFECTIVO) {
                $polizaPago = new PolizaPagoSemestralEfectivo($costoReal, $abono, $pago, $minimoCosto = 0.5);
            }

            if ($metodoPago === MedioPago::TARJETA_CREDITO || $metodoPago === MedioPago::CHEQUE) {
                $polizaPago = new PolizaPagoSemestralTarjetaCheque($metodoPago, $costoReal, $abono, $minimoCosto = 0.5);
            }
        }

        return $polizaPago;
    }
}