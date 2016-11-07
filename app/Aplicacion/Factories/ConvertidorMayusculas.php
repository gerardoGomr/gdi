<?php
namespace GDI\Aplicacion;

/**
 * Class ConvertidorMayusculas
 * @package GDI\Aplicacion\Factories
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ConvertidorMayusculas
{
    /**
     * convierte el valor especificado en mayúsculas
     * @param $valor
     * @return string
     */
    public static function convertir($valor)
    {
        return mb_strtoupper($valor);
    }
}