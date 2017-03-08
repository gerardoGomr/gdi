<?php

namespace GDI\Http\Controllers\Caja;

use DateTime;
use GDI\Aplicacion\Coleccion;
use GDI\Aplicacion\Reportes\Caja\ReporteCorteCaja;
use GDI\Dominio\Oficinas\CorteCaja;
use GDI\Dominio\Oficinas\Repositorios\CortesCajaRepositorio;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Usuarios\Repositorios\UsuariosRepositorio;
use GDI\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class CajaController
 * @package GDI\Http\Controllers\Caja
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CajaController extends Controller
{
    /**
     * @var CortesCajaRepositorio
     */
    private $cortesCajaRepositorio;

    /**
     * CajaController constructor.
     *
     * @param CortesCajaRepositorio $cortesCajaRepositorio
     */
    public function __construct(CortesCajaRepositorio $cortesCajaRepositorio)
    {
        $this->cortesCajaRepositorio = $cortesCajaRepositorio;
    }


    /**
     * mostrar vista para mostrar los cortes de caja
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $cortes = $this->cortesCajaRepositorio->obtenerTodos();
        return view('caja.caja', compact('cortes'));
    }

    /**
     * buscar cortes y volver a generar la vista
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function recargar()
    {
        $respuesta = ['estatus' => 'OK'];
        $cortes    = $this->cortesCajaRepositorio->obtenerTodos();

        $respuesta['html'] = view('caja.caja_cortes', compact('cortes'))->render();

        return response()->json($respuesta);
    }

    /**
     * generar nuevo corte de caja
     *
     * @param Request $request
     * @param PolizasRepositorio $polizasRepositorio
     * @param UsuariosRepositorio $usuariosRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function nuevo(Request $request, PolizasRepositorio $polizasRepositorio, UsuariosRepositorio $usuariosRepositorio)
    {
        $respuesta  = ['estatus' => 'OK'];
        $fechaCorte = $request->get('fechaCorte');
        $usuario    = session('usuario');
        $usuario    = $usuariosRepositorio->obtenerPorId($usuario->getId(), $usuario->getOficina()->getId());

        $corte = $this->cortesCajaRepositorio->obtenerPorFecha($fechaCorte);

        if (!is_null($corte)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'YA EXISTE UN CORTE DE CAJA CON LA FECHA ESPECIFIADA.';

            // codigo para loguear el error - ya existe un corte con esta fecha
            return response()->json($respuesta);
        }

        $polizasPagos = $polizasRepositorio->obtenerPorFechaPago($fechaCorte);

        if (is_null($polizasPagos)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = "NO EXISTEN PÓLIZAS REGISTRADAS CON LA FECHA $fechaCorte.";

            // codigo para loguear el error - no hay polizas generadas con esta fecha
            return response()->json($respuesta);
        }

        // generando corte
        $polizasPagos = new Coleccion($polizasPagos);
        $corte        = new CorteCaja($polizasPagos, $usuario, DateTime::createFromFormat('d/m/Y', $fechaCorte), $usuario->getOficina());

        if (!$this->cortesCajaRepositorio->persistir($corte)) {
            $respuesta['estatus'] = 'fail';

            // codigo para loguear el error - error en BD
            return response()->json($respuesta);
        }

        return response()->json($respuesta);
    }

    /**
     * mostrar el detalle de un corte de caja
     *
     * @param string|null $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function mostrar($id = null)
    {
        $this->validarQueryString($id);

        $respuesta         = ['estatus' => 'OK'];
        $corte             = $this->cortesCajaRepositorio->obtenerPorId((int)$id);
        $respuesta['html'] = view('caja.caja_corte_detalle_cuerpo', compact('corte'))->render();

        return response()->json($respuesta);

    }

    /**
     * exportar detalles del corte a excel
     *
     * @param string $id
     * @return \Illuminate\Http\Response
     */
    public function exportarExcel($id = null)
    {
        $this->validarQueryString($id);

        $corte = $this->cortesCajaRepositorio->obtenerPorId((int)base64_decode($id));

        Excel::create('CorteCaja_' . (new DateTime())->format('d/m/Y H:i:s'), function($excel) use($corte) {
            $excel->sheet('Corte', function($sheet) use($corte) {
                $sheet->loadView('caja.caja_corte_detalle_excel', compact('corte'));
            });
        })->export('xlsx');
    }

    public function exportarPDF($id = null)
    {
        $this->validarQueryString($id);

        $corte = $this->cortesCajaRepositorio->obtenerPorId((int)base64_decode($id));

        $reporteCorte = new ReporteCorteCaja($corte);
        $reporteCorte->SetHeaderMargin(PDF_MARGIN_HEADER);
        $reporteCorte->SetFooterMargin(PDF_MARGIN_FOOTER);
        $reporteCorte->SetAutoPageBreak(true);
        $reporteCorte->SetMargins(15, 55);
        $reporteCorte->generar();
    }
}