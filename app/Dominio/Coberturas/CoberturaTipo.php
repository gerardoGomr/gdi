<?php
namespace GDI\Dominio\Coberturas;

use \SplEnum;

/**
 * Class CoberturaTipo
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CoberturaTipo extends SplEnum
{
    const __default = self::BASICA;
    const BASICA    = 1;
    const AMPLIA    = 2;
    const LOCAL     = 3;
}