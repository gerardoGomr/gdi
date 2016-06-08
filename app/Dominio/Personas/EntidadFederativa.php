<?php
namespace GDI\Dominio\Personas;

use \SplEnum;

/**
 * Class EntidadFederativa
 * @package GDI\Dominio\Personas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class EntidadFederativa extends SplEnum
{
    const AGUASCALIENTES      = 1;
    const BAJA_CALIFORNIA     = 2;
    const BAJA_CALIFORNIA_SUR = 3;
    const CAMPECHE            = 4;
    const CHIAPAS             = 5;
    const CHIHUAHUA           = 6;
    const CIUDAD_DE_MEXICO    = 7;
    const COAHUILA            = 8;
    const COLIMA              = 9;
    const DURANGO             = 10;
    const ESTADO_DE_MEXICO    = 11;
    const GUANAJUATO          = 12;
    const GUERRERO            = 13;
    const HIDALGO             = 14;
    const JALISCO             = 15;
    const MICHOACAN           = 16;
    const MORELOS             = 17;
    const NAYARIT             = 18;
    const NUEVO_LEON          = 19;
    const OAXACA              = 20;
    const PUEBLA              = 21;
    const QUERETARO           = 22;
    const QUINTANA_ROO        = 23;
    const SAN_LUIS_POTOSI     = 24;
    const SINALOA             = 25;
    const SONORA              = 26;
    const TABASCO             = 27;
    const TAMAULIPAS          = 28;
    const TLAXCALA            = 29;
    const VERACRUZ            = 30;
    const YUCATAN             = 31;
    const ZACATECAS           = 32;
    const __default           = self::CHIAPAS;
}