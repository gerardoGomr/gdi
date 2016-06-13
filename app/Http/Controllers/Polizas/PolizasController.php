<?php
namespace GDI\Http\Controllers\Polizas;

use Illuminate\Http\Request;
use GDI\Http\Requests;
use GDI\Http\Controllers\Controller;

/**
 * Class PolizasController
 * @package GDI\Http\Controllers\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizasController extends Controller
{
    /**
     * retornar la vista principal de polizas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('polizas.polizas');
    }

    /**
     * retornar la vista de registro de nueva póliza
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormRegistro()
    {
        return view('polizas.polizas_registrar');
    }
}
