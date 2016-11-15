<?php
namespace GDI\Dominio\Polizas\Pagos;

/**
 * Interface IPolizaPago
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface IPolizaPago
{
    /**
     * @return void
     */
    public function registrarPago();
}