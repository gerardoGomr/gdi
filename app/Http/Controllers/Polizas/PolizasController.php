<?php
namespace GDI\Http\Controllers\Polizas;

use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\VehiculosRepositorio;
use Illuminate\Http\Request;
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
     * @var VehiculosRepositorio
     */
    private $vehiculosRepositorio;

    /**
     * @var AsociadosProtegidosRepositorio
     */
    private $asociadosRepositorio;

    /**
     * PolizasController constructor.
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosRepositorio
     */
    public function __construct(VehiculosRepositorio $vehiculosRepositorio, AsociadosProtegidosRepositorio $asociadosRepositorio)
    {
        $this->vehiculosRepositorio = $vehiculosRepositorio;
        $this->asociadosRepositorio = $asociadosRepositorio;
    }

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
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormRegistro(ModalidadesRepositorio $modalidadesRepositorio)
    {
        $modalidades = $modalidadesRepositorio->obtenerTodos();
        return view('polizas.polizas_registrar', compact('modalidades'));
    }

    /**
     * buscar vehículos por número de serie o por número de motor
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarVehiculos(Request $request)
    {
        $dato      = $request->get('dato');
        $respuesta = [];

        $vehiculos = $this->vehiculosRepositorio->obtenerPor($dato);

        if (is_null($vehiculos)) {
            $respuesta['estatus'] = 'fail';
        } else {
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('')->render();
        }

        return response()->json($respuesta);
    }

    /**
     * buscar a un asociado protegido por nombres
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarAsociados(Request $request)
    {
        $datoAsociado = $request->get('datoAsociado');
        $respuesta    = [];

        $asociados = $this->asociadosRepositorio->obtenerPor($datoAsociado);

        if (is_null($asociados)) {
            $respuesta['estatus'] = 'fail';
        } else {
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('')->render();
        }

        return response()->json($respuesta);
    }
}
