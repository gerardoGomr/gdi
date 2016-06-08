<?php
namespace GDI\Dominio\Coberturas;

use \SplEnum;

/**
 * Class Vigencia
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Vigencia extends SplEnum
{
    const SEIS_MESES = 1;
    const DOCE_MESES = 2;
    const __default  = self::DOCE_MESES;
}