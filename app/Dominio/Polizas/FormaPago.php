<?php

namespace GDI\Dominio\Polizas;

use \SplEnum;

/**
 * Class FormaPago
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class FormaPago extends SplEnum
{
    const CONTADO   = 1;
    const PARCIAL   = 2;
    const SEMESTRAL = 3;
    const __default = self::CONTADO;
}