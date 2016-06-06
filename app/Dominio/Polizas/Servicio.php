<?php
namespace GDI\Dominio\Polizas;

use \SplEnum;

/**
 * Class Servicio
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Servicio extends SplEnum
{
    const __default = self::ESTATAL;
    const ESTATAL   = 1;
    const FEDERAL   = 2;
}