<?php
namespace GDI\Dominio\Polizas;

/**
 * Class FormaPago
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class FormaPago
{
    const CONTADO   = 1;
    const PARCIAL   = 2;
    const SEMESTRAL = 3;
}