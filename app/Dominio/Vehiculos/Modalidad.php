<?php
namespace GDI\Dominio\Vehiculos;

use \SplEnum;

/**
 * Class Modalidad
 * @package GDI\Dominio\Vehiculos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Modalidad extends SplEnum
{
    const __default = self::TAXI;
    const TAXI      = 1;
    const COMBI     = 2;
    const URVAN     = 3;
    const MOTOTAXI  = 4;
}