<?php
namespace GDI\Http\Controllers\Polizas;

use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
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
     * @var int
     */
    private $oficinaId;

    /**
     * @var VehiculosRepositorio
     */
    private $vehiculosRepositorio;

    /**
     * @var AsociadosProtegidosRepositorio
     */
    private $asociadosRepositorio;

    /**
     * @var MarcasRepositorio
     */
    private $marcasRepositorio;

    /**
     * PolizasController constructor.
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosRepositorio
     * @param MarcasRepositorio $marcasRepositorio
     */
    public function __construct(VehiculosRepositorio $vehiculosRepositorio, AsociadosProtegidosRepositorio $asociadosRepositorio, MarcasRepositorio $marcasRepositorio)
    {
        $this->oficinaId            = request()->session()->get('usuario')->getOficina()->getId();
        $this->vehiculosRepositorio = $vehiculosRepositorio;
        $this->asociadosRepositorio = $asociadosRepositorio;
        $this->marcasRepositorio    = $marcasRepositorio;
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
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param MarcasRepositorio $marcasRepositorio
     */
    public function verFormRegistro(ModalidadesRepositorio $modalidadesRepositorio, AsociadosAgentesRepositorio $asociadosAgentesRepositorio)
    {
        $modalidades      = $modalidadesRepositorio->obtenerTodos($this->oficinaId);
        $marcas           = $this->marcasRepositorio->obtenerTodos($this->oficinaId);
        $asociadosAgentes = $asociadosAgentesRepositorio->obtenerTodos($this->oficinaId);
        return view('polizas.polizas_registrar', compact('modalidades', 'marcas', 'asociadosAgentes'));
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

        $vehiculos = $this->vehiculosRepositorio->obtenerPor($dato, $this->oficinaId);

        if (is_null($vehiculos)) {
            $respuesta['estatus'] = 'fail';
        } else {
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('')->render();
        }

        return response()->json($respuesta);
    }

    /**
     * buscar modelos dependiendo la marca
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarModelos(Request $request)
    {
        $marcaId   = (int)$request->get('marcaId');
        $marca     = $this->marcasRepositorio->obtenerPorId($marcaId, $this->oficinaId);
        $respuesta = [];

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('polizas.polizas_resultado_modelos', compact('marca'))->render();

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

        $asociados = $this->asociadosRepositorio->obtenerPor($datoAsociado, $this->oficinaId);

        if (is_null($asociados)) {
            $respuesta['estatus'] = 'fail';
        } else {
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('')->render();
        }

        return response()->json($respuesta);
    }
}
