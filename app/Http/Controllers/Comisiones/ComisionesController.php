<?php
namespace GDI\Http\Controllers\Comisiones;

use GDI\Http\Controllers\Controller;
use GDI\Jobs\TestJob;

/**
 * Class ComisionesController
 *
 * @package GDI\Http\Controllers\Comisiones
 * @author Gerardo Adrián Gómez Ruiz <gerardo.gomr@gmail.com>
 */
class ComisionesController extends Controller
{
    /**
     * mostrar la vista para el reporte de comisiones generado por el sistema.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('comisiones.comisiones');
    }

    public function testJob()
    {
        $job = new TestJob();
        dispatch($job);
    }
}