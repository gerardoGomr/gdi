<?php
namespace GDI\Aplicacion;

use Illuminate\Http\Request;

/**
 * Class TransformadorMayusculas
 * @package GDI\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class TransformadorMayusculas
{
    /**
     * transformar los valores del request a mayúsculas
     * @param Request $request
     * @return void
     */
    public function transformar(Request $request)
    {
        $input   = $request->except('emailAsociado', 'emailAgente', 'polizaId');
        array_walk($input, function(&$value) {
            $value = mb_strtoupper($value);
        });

        $input[] = $request->get('emailAsociado');
        $input[] = $request->get('emailAgente');

        $request->merge($input);
    }
}