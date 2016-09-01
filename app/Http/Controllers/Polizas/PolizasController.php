<?php
namespace GDI\Http\Controllers\Polizas;

use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Domicilio;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Polizas\AsociadoProtegido;
use GDI\Dominio\Polizas\MedioPago;
use GDI\Dominio\Polizas\Poliza;
use GDI\Dominio\Polizas\PolizaPago;
use GDI\Dominio\Polizas\Repositorios\AsociadosAgentesRepositorio;
use GDI\Dominio\Polizas\Repositorios\AsociadosProtegidosRepositorio;
use GDI\Dominio\Polizas\Repositorios\PolizasRepositorio;
use GDI\Dominio\Polizas\Repositorios\ServiciosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\MarcasRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModalidadesRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\ModelosRepositorio;
use GDI\Dominio\Vehiculos\Repositorios\VehiculosRepositorio;
use GDI\Dominio\Vehiculos\Vehiculo;
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
        //$this->oficina              = request()->session()->get('usuario')->getOficina();
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
        $servicios        = $this->serviciosRepositorio->obtenerTodos();
        return view('polizas.polizas_registrar', compact('modalidades', 'marcas', 'asociadosAgentes', 'servicios'));
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

        $modalidad = $modalidadesRepositorio->obtenerPorId($modalidadId, $this->oficinaId);
        $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId, $modalidad);

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
     * @param CostosRepositorio $costosRepositorio
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(
        Request $request,
        AsociadosAgentesRepositorio $asociadosAgentesRepositorio,
        ModalidadesRepositorio $modalidadesRepositorio,
        CoberturasRepositorio $coberturasRepositorio,
        ModelosRepositorio $modelosRepositorio,
        CostosRepositorio $costosRepositorio,
        UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
    )
    {
        $respuesta = [];

        // oficina
        $this->oficina = $this->polizasRepositorio->obtenerOficinaPorId($this->oficinaId);

        // datos de vehículo
        $modalidadId = (int)$request->get('modalidad');
        $servicioId  = (int)$request->get('servicio');
        $modeloId    = (int)$request->get('modelo');
        $anio        = (int)$request->get('anio');
        $numeroSerie = $request->get('numSerie');
        $numeroMotor = $request->get('numMotor');
        $placas      = $request->get('placas');
        $capacidad   = (int)$request->get('capacidad');

        // datos de asociado protegido
        $tipoPersona         = (int)$request->get('tipoPersona');
        $nombre              = $request->get('nombre');
        $paterno             = $request->get('paterno');
        $materno             = $request->get('materno');
        $razonSocial         = $request->get('razonSocial');
        $rfc                 = $request->get('rfc');
        $calleAsociado       = $request->get('calleAsociado');
        $numExteriorAsociado = $request->get('numExteriorAsociado');
        $numInteriorAsociado = $request->get('numInteriorAsociado');
        $coloniaAsociado     = $request->get('coloniaAsociado');
        $cpAsociado          = $request->get('cpAsociado');
        $ciudadAsociadoId    = (int)$request->get('ciudadAsociado');
        $telefonoAsociado    = $request->get('telefonoAsociado');
        $celularAsociado     = $request->get('celularAsociado');
        $emailAsociado       = $request->get('emailAsociado');

        // datos de asociado agente
        $asociadoAgenteId = (int)$request->get('asociadoAgente');

        // datos de la cobertura
        $coberturaId = (int)$request->get('cobertura');
        $costoId     = (int)$request->get('vigenciaCobertura');

        // ===========================================================================
        // constructing and saving
        $asociadoAgente = $asociadosAgentesRepositorio->obtenerPorId($asociadoAgenteId, $this->oficinaId);

        // unidad administrativa y domicilio
        $unidadAdministrativa = $unidadesAdministrativasRepositorio->obtenerPorId($ciudadAsociadoId);
        $domicilio = new Domicilio($calleAsociado, $numExteriorAsociado, $numInteriorAsociado, $coloniaAsociado, $cpAsociado, $unidadAdministrativa);

        // asociado protegido
        $asociadoProtegido = new AsociadoProtegido($rfc, $tipoPersona, $telefonoAsociado, $celularAsociado, $emailAsociado);
        $asociadoProtegido->generar($nombre, $paterno, $materno, $razonSocial, $domicilio, $this->oficina);

        // vehículo
        $modelo    = $modelosRepositorio->obtenerPorId($modeloId, $this->oficinaId);
        $modalidad = $modalidadesRepositorio->obtenerPorId($modalidadId, $this->oficinaId);
        $servicio  = $this->serviciosRepositorio->obtenerPorId($servicioId);
        $vehiculo  = new Vehiculo($modelo, $anio, $capacidad, $numeroSerie, $numeroMotor, $placas, $modalidad, $servicio, $asociadoProtegido, $this->oficina);

        // coberturas
        $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId, $modalidad);

        // costos
        $costo = $costosRepositorio->obtenerPorId($costoId);

        // pólizas
        $poliza = new Poliza($vehiculo, $asociadoAgente, $cobertura, $costo, $this->oficina);
        $poliza->generarVigencia();
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
     * pagar la póliza
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagarPoliza(Request $request)
    {
        $formaPago  = (int)$request->get('formaPago');
        $metodoPago = (int)$request->get('metodoPago');
        $polizaId   = (int)base64_decode($request->get('polizaId'));
        $respuesta  = [];

        $poliza = $this->polizasRepositorio->obtenerPorId($polizaId);

        if ($metodoPago === MedioPago::EFECTIVO) {
            $pago   = (double)$request->get('montoPago');
            $cambio = (double)$request->get('cambio');
            $poliza->pagar($formaPago, $metodoPago, new PolizaPago($pago, $cambio));

        } else {
            $poliza->pagar($formaPago, $metodoPago);

        }

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

    public function formato($polizaId)
    {
        $polizaId = (int)base64_decode($polizaId));
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        // construcción de formato, usar TCPDF or Crystal Reports
    }
}