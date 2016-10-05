<?php
namespace GDI\Aplicacion;

/**
 * Class Fecha
 * @package GDI\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Fecha
{
    public static $meses = [
        '01' => 'ENERO',
        '02' => 'FEBRERO',
        '03' => 'MARZO',
        '04' => 'ABRIL',
        '05' => 'MAYO',
        '06' => 'JUNIO',
        '07' => 'JULIO',
        '08' => 'AGOSTO',
        '09' => 'SEPTIEMBRE',
        '10' => 'OCTUBRE',
        '11' => 'NOVIEMBRE',
        '12' => 'DICIEMBRE'
    ];

    public static function convertir($fecha)
    {
        list($anio, $mes, $dia) = explode('-', $fecha);

        return $dia . ' DE ' . self::$meses[$mes] . ' DE '. $anio;
    }
}