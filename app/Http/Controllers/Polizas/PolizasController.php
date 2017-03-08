<?php
namespace GDI\Http\Controllers\Polizas;

use Exception;
use GDI\Aplicacion\Factories\AsociadosAgentesFactory;
use GDI\Aplicacion\Factories\ModalidadesFactory;
use GDI\Aplicacion\Factories\PolizasFactory;
use GDI\Aplicacion\Factories\PolizasPagosParcialesFactory;
use GDI\Aplicacion\Factories\ServiciosFactory;
use GDI\Aplicacion\Factories\VehiculosFactory;
use GDI\Aplicacion\Factories\PolizasPagosFactory;
use GDI\Aplicacion\Logger;
use GDI\Aplicacion\Reportes\Polizas\FormatoPoliza;
use GDI\Aplicacion\Coleccion;
use GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CostosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\ResponsabilidadesRepositorio;
use GDI\Dominio\Coberturas\Repositorios\VigenciasRepositorio;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Oficinas\Repositorios\OficinasRepositorio;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
use GDI\Dominio\Polizas\FormaPago;
use GDI\Dominio\Polizas\Poliza;
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
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;

/**
 * Class PolizasController
 *
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
     *
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param AsociadosProtegidosRepositorio $asociadosRepositorio
     * @param MarcasRepositorio $marcasRepositorio
     * @param ServiciosRepositorio $serviciosRepositorio
     * @param PolizasRepositorio $polizasRepositorio
     */
    public function __construct(VehiculosRepositorio $vehiculosRepositorio, AsociadosProtegidosRepositorio $asociadosRepositorio, MarcasRepositorio $marcasRepositorio, ServiciosRepositorio $serviciosRepositorio, PolizasRepositorio $polizasRepositorio)
    {
        $this->vehiculosRepositorio = $vehiculosRepositorio;
        $this->asociadosRepositorio = $asociadosRepositorio;
        $this->marcasRepositorio    = $marcasRepositorio;
        $this->serviciosRepositorio = $serviciosRepositorio;
        $this->polizasRepositorio   = $polizasRepositorio;
    }

    /**
     * retornar la vista principal de polizas
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $polizas = $this->polizasRepositorio->obtenerTodos();
        return view('polizas.polizas', compact('polizas'));
    }

    /**
     * buscar pólizas en base a los parámetros
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarPolizas(Request $request)
    {
        $parametros = [];

        foreach ($request->all() as $index => $sentRequest) {
            $parametros[$index] = $sentRequest;
        }

        $polizas = $this->polizasRepositorio->obtenerPor($parametros);

        return response()->json(['html' => view('polizas.polizas_resultados', compact('polizas'))->render()]);
    }

    /**
     * retornar la vista de registro de nueva póliza
     *
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormRegistro(AsociadosAgentesRepositorio $asociadosAgentesRepositorio)
    {
        $asociadosAgentes = $asociadosAgentesRepositorio->obtenerTodos();

        return view('polizas.polizas_registrar', compact('asociadosAgentes'));
    }

    /**
     * buscar vehículos por número de serie o por número de motor
     *
     * @param Request $request
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function buscarVehiculos(Request $request, ModalidadesRepositorio $modalidadesRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio, CoberturasRepositorio $coberturasRepositorio, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio)
    {
        $dato      = $request->get('dato');
        $respuesta = ['estatus' => 'OK'];

        $this->transformarMayusculas($request);

        $polizas                 = $this->polizasRepositorio->obtenerPorVehiculo($dato);
        $modalidades             = $modalidadesRepositorio->obtenerTodos();
        $marcas                  = $this->marcasRepositorio->obtenerTodos();
        $servicios               = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos     = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias               = $vigenciasRepositorio->obtenerTodos();
        $unidadesAdministrativas = $unidadesAdministrativasRepositorio->obtenerTodos();

        if (is_null($polizas)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['html']    = view('polizas.polizas_registrar_nuevo', compact('modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'unidadesAdministrativas'))->render();

        } else {
            $poliza        = end($polizas);
            $coberturaTipo = $poliza->getCobertura()->getCoberturaTipo();
            $servicio      = $poliza->getCobertura()->getServicio();
            $coberturas    = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipo);
            $formaDeCargo  = 'busqueda';

            $respuesta['sePuedeRenovar'] = 'OK';

            if ($poliza->vigente()) {
                if ($poliza->estaDentroDePeriodoAptoParaRenovar()) {
                    $respuesta['mensaje'] = 'SE PROCEDERÁ A REALIZAR LA RENOVACIÓN DE LA PÓLIZA DEBIDO A QUE ESTÁ DENTRO DE LOS 30 DÍAS ANTES DE QUE TERMINE SU VIGENCIA.';
                    $respuesta['html']    = view('polizas.polizas_registrar_existente', compact('poliza', 'modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'coberturas', 'unidadesAdministrativas', 'formaDeCargo'))->render();

                } else {
                    $respuesta['sePuedeRenovar'] = 'No';
                    $respuesta['mensaje']        = 'NO SE PUEDE REALIZAR LA RENOVACIÓN DE LA PÓLIZA DEBIDO A QUE ESTÁ VIGENTE Y NO ESTÁ DENTRO DE LOS 30 DÍAS ANTES DE QUE TERMINE SU VIGENCIA.';
                }
            } else {
                $respuesta['mensaje'] = 'SE PROCEDERÁ A REALIZAR LA RENOVACIÓN DE LA PÓLIZA DEBIDO A QUE TERMINÓ SU VIGENCIA.';
                $respuesta['html']    = view('polizas.polizas_registrar_existente', compact('poliza', 'modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'coberturas', 'unidadesAdministrativas'))->render();
            }

        }

        return response()->json($respuesta);
    }

    /**
     * buscar una póliza en base al ID enviado
     *
     * @param Request $request
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarPolizaExistente(Request $request, ModalidadesRepositorio $modalidadesRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio, CoberturasRepositorio $coberturasRepositorio)
    {
        $polizaId            = (int)$request->get('polizaId');
        $poliza              = $this->polizasRepositorio->obtenerPorId($polizaId);
        $modalidades         = $modalidadesRepositorio->obtenerTodos();
        $marcas              = $this->marcasRepositorio->obtenerTodos();
        $servicios           = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias           = $vigenciasRepositorio->obtenerTodos();

        $coberturaTipo = $poliza->getCobertura()->getCoberturaTipo();
        $servicio      = $poliza->getCobertura()->getServicio();
        $coberturas    = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipo);

        return response()->json([
            'html' => view('polizas.polizas_registrar_existente', compact('poliza', 'modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'coberturas'))->render()
        ]);
    }

    /**
     * buscar modelos dependiendo la marca
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarModelos(Request $request)
    {
        $marcaId   = (int)$request->get('marcaId');
        $marca     = $this->marcasRepositorio->obtenerPorId($marcaId);
        $respuesta = ['estatus' => 'OK'];

        $respuesta['html'] = view('polizas.polizas_resultado_modelos', compact('marca'))->render();

        return response()->json($respuesta);
    }

    /**
     * buscar a un asociado protegido por nombres
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarAsociados(Request $request)
    {
        $datoAsociado = $request->get('datoAsociado');
        $respuesta    = ['estatus' => 'OK'];

        $asociados = $this->asociadosRepositorio->obtenerPor($datoAsociado);

        if (is_null($asociados)) {
            $respuesta['estatus'] = 'fail';

        } else {
            $respuesta['html'] = view('polizas.polizas_resultado_asociados_tabla', compact('asociados'))->render();
        }

        return response()->json($respuesta);
    }

    /**
     * buscar coberturas dependiendo el tipo y el servicio
     *
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
        $coberturas = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipoId);

        $respuesta['html'] = view('polizas.polizas_resultado_coberturas', compact('coberturas'))->render();

        return response()->json($respuesta);
    }

    /**
     * buscar vigencias asignadas a la cobertura dependiendo la modalidad del vehículo
     *
     * @param Request $request
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function buscarVigenciasCobertura(Request $request, ModalidadesRepositorio $modalidadesRepositorio, CoberturasRepositorio $coberturasRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio)
    {
        $coberturaId = (int)$request->get('coberturaId');
        $modalidadId = (int)$request->get('modalidadId');

        if ($modalidadId === '-1') {
            // se registrará nueva modalidad
            $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId);

        } else {
            $modalidad = $modalidadesRepositorio->obtenerPorId($modalidadId);
            $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId, $modalidad);
        }

        $coberturasConceptos = $coberturasConceptosRepositorio->obtenerTodos();

        $respuesta['html']                  = view('polizas.polizas_resultado_vigencias', compact('cobertura', 'modalidad'))->render();
        $respuesta['htmlResponsabilidades'] = view('polizas.polizas_resultado_responsabilidades', compact('cobertura', 'coberturasConceptos'))->render();

        return response()->json($respuesta);
    }

    /**
     * registrar una nueva póliza
     *
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
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param PolizasRepositorio $polizasRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request, AsociadosAgentesRepositorio $asociadosAgentesRepositorio, ModalidadesRepositorio $modalidadesRepositorio, CoberturasRepositorio $coberturasRepositorio, ModelosRepositorio $modelosRepositorio, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, OficinasRepositorio $oficinasRepositorio, VigenciasRepositorio $vigenciasRepositorio, CostosRepositorio $costosRepositorio, AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio, VehiculosRepositorio $vehiculosRepositorio, PolizasRepositorio $polizasRepositorio)
    {
        $respuesta = ['estatus' => 'OK'];

        // transformar a mayúsculas
        $this->transformarMayusculas($request);

        $oficina = $oficinasRepositorio->obtenerPorId(session('usuario')->getOficina()->getId());

        // ===========================================================================
        // constructing and saving
        $asociadoAgente = AsociadosAgentesFactory::crear($request, $oficina, $asociadosAgentesRepositorio, $unidadesAdministrativasRepositorio);
        $modalidad      = ModalidadesFactory::crear($oficina, $request, $modalidadesRepositorio);
        $servicio       = ServiciosFactory::crear($request, $this->serviciosRepositorio);
        $vehiculo       = VehiculosFactory::crear($request, $unidadesAdministrativasRepositorio, $this->marcasRepositorio, $modelosRepositorio, $asociadosProtegidosRepositorio, $vehiculosRepositorio, $oficina, $modalidad);

        try {
            $poliza = PolizasFactory::crear($request, $polizasRepositorio, $coberturasConceptosRepositorio, $coberturasRepositorio, $vigenciasRepositorio, $costosRepositorio, $modalidad, $servicio, $oficina, $vehiculo, $asociadoAgente);

        } catch (Exception $e) {
            $pdoLogger = new Logger(new Log('exception'), new StreamHandler(storage_path() . '/logs/exceptions/exc_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);

            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = $e->getMessage();

            return response()->json($respuesta);
        }

        // ===========================================================================
        // persistir poliza
        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        // generar la url de respuesta
        $respuesta['url'] = '/polizas';

        if (!$poliza->estaPagada()) {
            $respuesta['url'] = '/polizas/pagar/' . base64_encode($poliza->getId());
        }

        return response()->json($respuesta);
    }

    /**
     * mostrar vista para la selección de pago de la póliza
     *
     * @param string $polizaId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormPago($polizaId = null)
    {
        $this->validarQueryString($polizaId);

        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        if ($poliza->seActualizoPago()) {
            return view('polizas.polizas_pagar_diferencia', compact('poliza'));
        }

        if ($poliza->tienePagoParcial()) {
            return view('polizas.polizas_pagar_pago_parcial', compact('poliza'));
        }

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
        $respuesta  = ['estatus' => 'OK'];

        $poliza     = $this->polizasRepositorio->obtenerPorId($polizaId);
        $polizaPago = PolizasPagosFactory::crear($formaPago, $metodoPago, $abono, $pago, $poliza->getCosto()->getCosto());

        $poliza->inicializarPagos(new Coleccion());
        $poliza->pagar($polizaPago, $formaPago);

        if ($poliza->sePuedeGenerarFormato()) {
            $respuesta['sePuedeGenerarFormato'] = 'OK';

        } else {
            if ($poliza->esPagoParcial()) {
                $respuesta['generarFormatoParcial'] = 'OK';
            }
        }

        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        $respuesta['id'] = base64_encode((string)$poliza->getId());

        return response()->json($respuesta);
    }

    /**
     * pago de parciales (parcial - semestral) dependiendo del medio de pago
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagarPolizaParcial(Request $request)
    {
        $metodoPago = (int)$request->get('metodoPago');
        $polizaId   = (int)base64_decode($request->get('polizaId'));
        $abono      = (double)$request->get('cantidadAAbonar');
        $pago       = (double)$request->get('montoPago');
        $respuesta  = [];

        $poliza     = $this->polizasRepositorio->obtenerPorId($polizaId);
        $polizaPago = PolizasPagosParcialesFactory::crear($metodoPago, $pago, $poliza->obtenerSaldo());

        $poliza->pagar($polizaPago);

        if ($poliza->sePuedeGenerarFormato()) {
            $respuesta['sePuedeGenerarFormato'] = 'OK';

        } else {
            if ($poliza->esPagoParcial()) {
                $respuesta['generarFormatoParcial'] = 'OK';
            }
        }

        $respuesta['estatus'] = 'OK';

        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        $respuesta['id'] = base64_encode((string)$poliza->getId());

        return response()->json($respuesta);
    }

    /**
     * cobrar el costo de diferencia
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pagarPolizaDiferencia(Request $request)
    {
        $metodoPago = (int)$request->get('metodoPago');
        $polizaId   = (int)base64_decode($request->get('polizaId'));
        $pago       = (double)$request->get('montoPago');
        $abono      = (double)$request->get('cantidadAAbonar');
        $respuesta  = ['estatus' => 'OK'];

        $poliza     = $this->polizasRepositorio->obtenerPorId($polizaId);
        $polizaPago = PolizasPagosFactory::crear(FormaPago::CONTADO, $metodoPago, $abono, $pago, $poliza->getCostoDiferencia());

        $poliza->pagar($polizaPago);

        if ($poliza->sePuedeGenerarFormato()) {
            $respuesta['sePuedeGenerarFormato'] = 'OK';

        } else {
            if ($poliza->esPagoParcial()) {
                $respuesta['generarFormatoParcial'] = 'OK';
            }
        }

        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        $respuesta['id'] = base64_encode((string)$poliza->getId());

        return response()->json($respuesta);
    }

    /**
     * genera el formato de póliza en PDF
     *
     * @param string $polizaId
     */
    public function formato($polizaId = null)
    {
        $this->validarQueryString($polizaId);

        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $this->crearFormatoPoliza($poliza);
    }

    /**
     * generar el formato parcial de póliza en PDF
     *
     * @param string $polizaId
     */
    public function formatoParcial($polizaId = null)
    {
        $this->validarQueryString($polizaId);

        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $this->crearFormatoPoliza($poliza);
    }

    /**
     * construir el formato de la póliza
     *
     * @param Poliza $poliza
     */
    private function crearFormatoPoliza(Poliza $poliza)
    {
        $formatoPoliza = new FormatoPoliza($poliza);
        $formatoPoliza->SetHeaderMargin(PDF_MARGIN_HEADER);
        $formatoPoliza->SetFooterMargin(PDF_MARGIN_FOOTER);
        $formatoPoliza->SetAutoPageBreak(true);
        $formatoPoliza->SetMargins(15, 55);
        $formatoPoliza->generar();
    }

    /**
     * Generar la vista para editar la póliza
     * Si el parámetro $polizaId no está especificado, retornar una vista genérica de error
     *
     * @param string|null $polizaId
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @param UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormEdicion($polizaId = null, ModalidadesRepositorio $modalidadesRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio, CoberturasRepositorio $coberturasRepositorio, AsociadosAgentesRepositorio $asociadosAgentesRepositorio, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio)
    {
        $this->validarQueryString($polizaId);

        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $modalidades             = $modalidadesRepositorio->obtenerTodos();
        $marcas                  = $this->marcasRepositorio->obtenerTodos();
        $servicios               = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos     = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias               = $vigenciasRepositorio->obtenerTodos();
        $coberturaTipo           = $poliza->getCobertura()->getCoberturaTipo();
        $servicio                = $poliza->getCobertura()->getServicio();
        $coberturas              = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipo);
        $asociadosAgentes        = $asociadosAgentesRepositorio->obtenerTodos();
        $unidadesAdministrativas = $unidadesAdministrativasRepositorio->obtenerTodos();
        $formaDeCargo            = 'load';

        return view('polizas.polizas_editar', compact('poliza', 'modalidades', 'marcas', 'servicios', 'coberturasConceptos', 'vigencias', 'coberturas', 'asociadosAgentes', 'unidadesAdministrativas', 'formaDeCargo'));
    }

    /**
     * buscar responsabilidades en base al concepto id
     *
     * @param Request $request
     * @param ResponsabilidadesRepositorio $responsabilidadesRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function bucarResponsabilidades(Request $request, ResponsabilidadesRepositorio $responsabilidadesRepositorio)
    {
        $coberturaConceptoId = (int)$request->get('coberturaConceptoId');
        $responsabilidades   = $responsabilidadesRepositorio->obtenerPorCoberturaConceptoId($coberturaConceptoId);

        return response()->json([
            'html' => view('polizas.polizas_resultado_responsabilidades_combo', compact('responsabilidades'))->render()
        ]);
    }
}