<?php

namespace GDI\Http\Controllers;

use GDI\Aplicacion\TransformadorMayusculas;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * transformar request a mayusculas
     * @param Request $request
     */
    protected function transformarMayusculas(Request $request)
    {
        $transformador = new TransformadorMayusculas();
        $transformador->transformar($request);
    }

    /**
     * validar la presencia de la variable GET
     * @param string $variable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function validarQueryString($variable)
    {
        if (is_null($variable)) {
            return view('errors.404');
        }
    }
}
