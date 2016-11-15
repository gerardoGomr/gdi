<?php
namespace GDI\Http\Controllers\Polizas;

use GDI\Aplicacion\Factories\AsociadosAgentesFactory;
use GDI\Aplicacion\Factories\ModalidadesFactory;
use GDI\Aplicacion\Factories\PolizasFactory;
use GDI\Aplicacion\Factories\ServiciosFactory;
use GDI\Aplicacion\Factories\VehiculosFactory;
use GDI\Aplicacion\Factories\PolizasPagosFactory;
use GDI\Aplicacion\Reportes\Polizas\FormatoPoliza;
use GDI\Aplicacion\Coleccion;
use GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Oficinas\Repositorios\OficinasRepositorio;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Polizas\MedioPago;
use GDI\Dominio\Polizas\PolizaPago;
use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio;
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
     * @var Oficina
     */
    private $oficina;

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
     * @var ServiciosRepositorio
     */
    private $serviciosRepositorio;

    /**
     * @var PolizasRepositorio
     */
    private $polizasRepositorio;

    /**
     * PolizasController constructor.
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosRepositorio
     * @param MarcasRepositorio $marcasRepositorio
     * @param ServiciosRepositorio $serviciosRepositorio
     * @param PolizasRepositorio $polizasRepositorio
     */
    public function __construct(VehiculosRepositorio $vehiculosRepositorio, AsociadosProtegidosRepositorio $asociadosRepositorio, MarcasRepositorio $marcasRepositorio, ServiciosRepositorio $serviciosRepositorio, PolizasRepositorio $polizasRepositorio)
    {
        $this->oficinaId            = request()->session()->get('usuario')->getOficina()->getId();
        $this->vehiculosRepositorio = $vehiculosRepositorio;
        $this->asociadosRepositorio = $asociadosRepositorio;
        $this->marcasRepositorio    = $marcasRepositorio;
        $this->serviciosRepositorio = $serviciosRepositorio;
        $this->polizasRepositorio   = $polizasRepositorio;
    }

    /**
     * retornar la vista principal de polizas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $polizas = $this->polizasRepositorio->obtenerTodos($this->oficinaId);
        return view('polizas.polizas', compact('polizas'));
    }

    /**
     * retornar la vista de registro de nueva póliza
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormRegistro(ModalidadesRepositorio $modalidadesRepositorio, AsociadosAgentesRepositorio $asociadosAgentesRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio)
    {

        $modalidades         = $modalidadesRepositorio->obtenerTodos($this->oficinaId);
        $marcas              = $this->marcasRepositorio->obtenerTodos();
        $asociadosAgentes    = $asociadosAgentesRepositorio->obtenerTodos($this->oficinaId);
        $servicios           = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias           = $vigenciasRepositorio->obtenerTodos();

        return view('polizas.polizas_registrar', compact('modalidades', 'marcas', 'asociadosAgentes', 'servicios', 'coberturasConceptos', 'vigencias'));
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

    /**
     * buscar coberturas dependiendo el tipo y el servicio
     * @param Request $request
     * @param CoberturasRepositorio $coberturasRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarCoberturas(Request $request, CoberturasRepositorio $coberturasRepositorio)
    {
        $coberturaTipoId = (int)$request->get('coberturaTipoId');
        $servicioId      = (int)$request->get('servicioId');

        $servicio   = $this->serviciosRepositorio->obtenerPorId($servicioId);
        $coberturas = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipoId, $this->oficinaId);

        $respuesta['html'] = view('polizas.polizas_resultado_coberturas', compact('coberturas'))->render();

        return response()->json($respuesta);
    }

    /**
     * buscar vigencias asignadas a la cobertura dependiendo la modalidad del vehículo
     * @param Request $request
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarVigenciasCobertura(Request $request, ModalidadesRepositorio $modalidadesRepositorio, CoberturasRepositorio $coberturasRepositorio)
    {
        $coberturaId = (int)$request->get('coberturaId');
        $modalidadId = (int)$request->get('modalidadId');

        if ($modalidadId === '-1') {
            // se registrará nueva modalidad
            $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId);

        } else {
            $modalidad = $modalidadesRepositorio->obtenerPorId($modalidadId, $this->oficinaId);
            $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId, $modalidad);
        }

        $respuesta['html'] = view('polizas.polizas_resultado_vigencias', compact('cobertura'))->render();

        return response()->json($respuesta);
    }

    /**
     * registrar una nueva póliza
     * @param Request $request
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param ModelosRepositorio $modelosRepositorio
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param OficinasRepositorio $oficinasRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CostosRepositorio $costosRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request, AsociadosAgentesRepositorio $asociadosAgentesRepositorio, ModalidadesRepositorio $modalidadesRepositorio, CoberturasRepositorio $coberturasRepositorio, ModelosRepositorio $modelosRepositorio, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, OficinasRepositorio $oficinasRepositorio, VigenciasRepositorio $vigenciasRepositorio, CostosRepositorio $costosRepositorio, AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio)
    {
        $respuesta = [];

        // oficina
        $this->oficina = $oficinasRepositorio->obtenerPorId($this->oficinaId);

        // ===========================================================================
        // constructing and saving
        $asociadoAgente = AsociadosAgentesFactory::crear($request, $this->oficina, $asociadosAgentesRepositorio, $unidadesAdministrativasRepositorio);
        $modalidad      = ModalidadesFactory::crear($this->oficina, $request, $modalidadesRepositorio);
        $servicio       = ServiciosFactory::crear($request, $this->serviciosRepositorio);
        $vehiculo       = VehiculosFactory::crear($request, $unidadesAdministrativasRepositorio, $this->marcasRepositorio, $modelosRepositorio, $asociadosProtegidosRepositorio, $this->oficina, $modalidad, $servicio);

        $poliza = PolizasFactory::crear($request, $coberturasConceptosRepositorio, $coberturasRepositorio, $vigenciasRepositorio, $costosRepositorio, $modalidad, $servicio, $this->oficina, $vehiculo, $asociadoAgente);

        // ===========================================================================
        // persistir poliza
        $respuesta['estatus'] = 'OK';
        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        $respuesta['id'] = base64_encode((string)$poliza->getId());

        return response()->json($respuesta);
    }

    /**
     * mostrar vista para la selección de pago de la póliza
     * @param string $polizaId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormPago($polizaId)
    {
        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId, $this->oficinaId);

        return view('polizas.polizas_pagar', compact('poliza'));
    }

    /**
     * pagar la póliza - registrar el pago de la poliza dependiendo el medio de pago
     * y la forma de pago.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagarPoliza(Request $request)
    {
        $formaPago  = (int)$request->get('formaPago');
        $metodoPago = (int)$request->get('metodoPago');
        $polizaId   = (int)base64_decode($request->get('polizaId'));
        $abono      = (double)$request->get('cantidadAAbonar');
        $pago       = (double)$request->get('montoPago');
        $cambio     = (double)$request->get('cambio');
        $respuesta  = [];

        $poliza     = $this->polizasRepositorio->obtenerPorId($polizaId);
        $polizaPago = PolizasPagosFactory::crear($formaPago, $metodoPago, $abono, $pago, $cambio, $poliza->getCosto()->getCosto());

        $poliza->inicializarPagos(new Coleccion());
        $poliza->pagar($formaPago, $metodoPago, $polizaPago);

        if ($poliza->sePuedeGenerarFormato()) {
            $respuesta['sePuedeGenerarFormato'] = 'OK';

        } else {
            if ($poliza->esPagoParcial()) {
                $respuesta['generarFormatoParcial'] = 'OK';
            }
        }

        $respuesta['estatus'] = 'OK';

        if (!$this->polizasRepositorio->actualizar($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        $respuesta['id'] = base64_encode((string)$poliza->getId());

        return response()->json($respuesta);
    }

    /**
     * genera el formato de póliza en PDF
     * @param string $polizaId
     */
    public function formato($polizaId)
    {
        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $formatoPoliza = new FormatoPoliza($poliza);
        $formatoPoliza->SetHeaderMargin(PDF_MARGIN_HEADER);
        $formatoPoliza->SetFooterMargin(PDF_MARGIN_FOOTER);
        $formatoPoliza->SetAutoPageBreak(true);
        $formatoPoliza->SetMargins(15, 55);
        $formatoPoliza->generar();
    }

    /**
     * generar el formato parcial de póliza en PDF
     * @param string $polizaId
     */
    public function formatoParcial($polizaId)
    {
        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $formatoPoliza = new FormatoPoliza($poliza);
        $formatoPoliza->SetHeaderMargin(PDF_MARGIN_HEADER);
        $formatoPoliza->SetFooterMargin(PDF_MARGIN_FOOTER);
        $formatoPoliza->SetAutoPageBreak(true);
        $formatoPoliza->SetMargins(15, 55);
        $formatoPoliza->generar();
    }
}