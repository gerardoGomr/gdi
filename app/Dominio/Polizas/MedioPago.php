<?php
namespace GDI\Dominio\Polizas;

/**
 * Class MedioPago
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class MedioPago
{
    const EFECTIVO        = 1;
    const TARJETA_CREDITO = 2;
    const CHEQUE          = 3;
}