<?php
namespace GDI\Dominio\Polizas;

use \SplEnum;

/**
 * Class MedioPago
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class MedioPago extends SplEnum
{
    const EFECTIVO        = 1;
    const TARJETA_CREDITO = 2;
    const CHEQUE          = 3;
    const __default       = self::EFECTIVO;
}