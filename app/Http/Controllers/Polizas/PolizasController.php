<?php
namespace GDI\Http\Controllers\Polizas;

use Exception;
use Monolog\Logger as Log;
use Monolog\Handler\StreamHandler;
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
use GDI\Dominio\Coberturas\ResponsabilidadCobertura;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Oficinas\Repositorios\OficinasRepositorio;
use GDI\Dominio\Personas\Repositorios\UnidadesAdministrativasRepositorio;
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
     * buscar pólizas en base a los parámetros
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarPolizas(Request $request)
    {
        $parametros = [];
        $parametros['estatus']            = $request->has('estatusPoliza') ? $request->get('estatusPoliza') : null;
        $parametros['entreFechaEmision']  = $request->has('entreFechaEmision') ? $request->get('entreFechaEmision') : null;
        $parametros['yFechaEmision']      = $request->has('yFechaEmision') ? $request->get('yFechaEmision') : null;
        $parametros['entreFechaVigencia'] = $request->has('entreFechaVigencia') ? $request->get('entreFechaVigencia') : null;
        $parametros['yFechaVigencia']     = $request->has('yFechaVigencia') ? $request->get('yFechaVigencia') : null;

        $polizas = $this->polizasRepositorio->obtenerPor($parametros);

        return response()->json(['html' => view('polizas.polizas_resultados', compact('polizas'))->render()]);
    }

    /**
     * retornar la vista de registro de nueva póliza
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormRegistro(AsociadosAgentesRepositorio $asociadosAgentesRepositorio)
    {
        $asociadosAgentes = $asociadosAgentesRepositorio->obtenerTodos($this->oficinaId);

        return view('polizas.polizas_registrar', compact('asociadosAgentes'));
    }

    /**
     * buscar vehículos por número de serie o por número de motor
     * @param Request $request
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarVehiculos(Request $request, ModalidadesRepositorio $modalidadesRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio, CoberturasRepositorio $coberturasRepositorio)
    {
        $dato      = $request->get('dato');
        $respuesta = [];

        $polizas             = $this->polizasRepositorio->obtenerPorVehiculo($dato, $this->oficinaId);
        $modalidades         = $modalidadesRepositorio->obtenerTodos($this->oficinaId);
        $marcas              = $this->marcasRepositorio->obtenerTodos();
        $servicios           = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias           = $vigenciasRepositorio->obtenerTodos();

        if (is_null($polizas)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['html']    = view('polizas.polizas_registrar_nuevo', compact('modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos'))->render();

        } else {
            $poliza        = end($polizas);
            $coberturaTipo = $poliza->getCobertura()->getCoberturaTipo();
            $servicio      = $poliza->getCobertura()->getServicio();
            $coberturas    = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipo, $this->oficinaId);
            $formaDeCargo  = 'busqueda';

            $respuesta['estatus']        = 'OK';
            $respuesta['sePuedeRenovar'] = 'OK';

            if($poliza->vigente()) {
                if($poliza->estaDentroDePeriodoAptoParaRenovar()) {
                    $respuesta['mensaje'] = 'SE PROCEDERÁ A REALIZAR LA RENOVACIÓN DE LA PÓLIZA DEBIDO A QUE ESTÁ DENTRO DE LOS 30 DÍAS ANTES DE QUE TERMINE SU VIGENCIA.';
                    $respuesta['html']    = view('polizas.polizas_registrar_existente', compact('poliza', 'modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'coberturas', 'formaDeCargo'))->render();

                } else {
                    $respuesta['sePuedeRenovar'] = 'No';
                    $respuesta['mensaje']        = 'NO SE PUEDE REALIZAR LA RENOVACIÓN DE LA PÓLIZA DEBIDO A QUE ESTÁ VIGENTE Y NO ESTÁ DENTRO DE LOS 30 DÍAS ANTES DE QUE TERMINE SU VIGENCIA.';
                }
            } else {
                $respuesta['mensaje'] = 'SE PROCEDERÁ A REALIZAR LA RENOVACIÓN DE LA PÓLIZA DEBIDO A QUE TERMINÓ SU VIGENCIA.';
                $respuesta['html']    = view('polizas.polizas_registrar_existente', compact('poliza', 'modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'coberturas'))->render();
            }

        }

        return response()->json($respuesta);
    }

    /**
     * buscar una póliza en base al ID enviado
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
        $modalidades         = $modalidadesRepositorio->obtenerTodos($this->oficinaId);
        $marcas              = $this->marcasRepositorio->obtenerTodos();
        $servicios           = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias           = $vigenciasRepositorio->obtenerTodos();

        $coberturaTipo = $poliza->getCobertura()->getCoberturaTipo();
        $servicio      = $poliza->getCobertura()->getServicio();
        $coberturas    = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipo, $this->oficinaId);

        return response()->json([
            'html' => view('polizas.polizas_registrar_existente', compact('poliza', 'modalidades', 'marcas', 'servicios', 'vigencias', 'coberturasConceptos', 'coberturas'))->render()
        ]);
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
            $cobertura = $coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId);
        }

        $respuesta['html']                  = view('polizas.polizas_resultado_vigencias', compact('cobertura', 'modalidad'))->render();
        $respuesta['htmlResponsabilidades'] = view('polizas.polizas_resultado_responsabilidades', compact('cobertura'))->render();

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
     * @param VehiculosRepositorio $vehiculosRepositorio
     * @param PolizasRepositorio $polizasRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function registrar(Request $request, AsociadosAgentesRepositorio $asociadosAgentesRepositorio, ModalidadesRepositorio $modalidadesRepositorio, CoberturasRepositorio $coberturasRepositorio, ModelosRepositorio $modelosRepositorio, UnidadesAdministrativasRepositorio $unidadesAdministrativasRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, OficinasRepositorio $oficinasRepositorio, VigenciasRepositorio $vigenciasRepositorio, CostosRepositorio $costosRepositorio, AsociadosProtegidosRepositorio $asociadosProtegidosRepositorio, VehiculosRepositorio $vehiculosRepositorio, PolizasRepositorio $polizasRepositorio)
    {
        $respuesta = [];

        // transformar a mayúsculas
        /*$transformador = new TransformadorMayusculas();
        $transformador->transformar($request);*/

        // oficina
        $this->oficina = $oficinasRepositorio->obtenerPorId($this->oficinaId);

        // ===========================================================================
        // constructing and saving
        $asociadoAgente = AsociadosAgentesFactory::crear($request, $this->oficina, $asociadosAgentesRepositorio, $unidadesAdministrativasRepositorio);
        $modalidad      = ModalidadesFactory::crear($this->oficina, $request, $modalidadesRepositorio);
        $servicio       = ServiciosFactory::crear($request, $this->serviciosRepositorio);
        $vehiculo       = VehiculosFactory::crear($request, $unidadesAdministrativasRepositorio, $this->marcasRepositorio, $modelosRepositorio, $asociadosProtegidosRepositorio, $vehiculosRepositorio, $this->oficina, $modalidad);

        $poliza = PolizasFactory::crear($request, $polizasRepositorio, $coberturasConceptosRepositorio, $coberturasRepositorio, $vigenciasRepositorio, $costosRepositorio, $modalidad, $servicio, $this->oficina, $vehiculo, $asociadoAgente);

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
        $respuesta  = [];

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

        $respuesta['estatus'] = 'OK';

        if (!$this->polizasRepositorio->actualizar($poliza)) {
            $respuesta['estatus'] = 'fail';
        }

        $respuesta['id'] = base64_encode((string)$poliza->getId());

        return response()->json($respuesta);
    }

    /**
     * pago de parciales (parcial - semestral) dependiendo del medio de pago
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
        $polizaPago = PolizasPagosParcialesFactory::crear($metodoPago, $abono, $pago, $poliza->obtenerSaldo());

        $poliza->pagar($polizaPago);

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

        $this->crearFormatoPoliza($poliza);
    }

    /**
     * generar el formato parcial de póliza en PDF
     * @param string $polizaId
     */
    public function formatoParcial($polizaId)
    {
        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $this->crearFormatoPoliza($poliza);
    }

    /**
     * construir el formato de la póliza
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
     * @param string|null $polizaId
     * @param ModalidadesRepositorio $modalidadesRepositorio
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param VigenciasRepositorio $vigenciasRepositorio
     * @param CoberturasRepositorio $coberturasRepositorio
     * @param AsociadosAgentesRepositorio $asociadosAgentesRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verFormEdicion($polizaId = null, ModalidadesRepositorio $modalidadesRepositorio, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, VigenciasRepositorio $vigenciasRepositorio, CoberturasRepositorio $coberturasRepositorio, AsociadosAgentesRepositorio $asociadosAgentesRepositorio)
    {
        if (!isset($polizaId)) {
            $error = 'VERIFIQUE LOS PARÁMETROS.';
            return view('errors.404', compact('error'));
        }

        $polizaId = (int)base64_decode($polizaId);
        $poliza   = $this->polizasRepositorio->obtenerPorId($polizaId);

        $modalidades         = $modalidadesRepositorio->obtenerTodos($this->oficinaId);
        $marcas              = $this->marcasRepositorio->obtenerTodos();
        $servicios           = $this->serviciosRepositorio->obtenerTodos();
        $coberturasConceptos = $coberturasConceptosRepositorio->obtenerTodos();
        $vigencias           = $vigenciasRepositorio->obtenerTodos();
        $coberturaTipo       = $poliza->getCobertura()->getCoberturaTipo();
        $servicio            = $poliza->getCobertura()->getServicio();
        $coberturas          = $coberturasRepositorio->obtenerPorServicioCoberturaTipo($servicio, $coberturaTipo, $this->oficinaId);
        $asociadosAgentes    = $asociadosAgentesRepositorio->obtenerTodos($this->oficinaId);
        $formaDeCargo        = 'load';

        return view('polizas.polizas_editar', compact('poliza', 'modalidades', 'marcas', 'servicios', 'coberturasConceptos', 'vigencias', 'coberturas', 'asociadosAgentes', 'formaDeCargo'));
    }

    /**
     * agregar una nueva responsabilidad a la cobertura de la póliza especificada
     * @param Request $request
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @param ResponsabilidadesRepositorio $responsabilidadesRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function agregarResponsabilidad(Request $request, CoberturasConceptosRepositorio $coberturasConceptosRepositorio, ResponsabilidadesRepositorio $responsabilidadesRepositorio)
    {
        $polizaId              = (int)$request->get('polizaId');
        $coberturaConceptoId   = (int)$request->get('coberturaConceptoId');
        $limiteResponsabilidad = $request->get('limiteResponsabilidad');
        $cuotaExtraordinaria   = $request->get('cuotaExtraordinaria');
        $respuesta             = [];

        $poliza            = $this->polizasRepositorio->obtenerPorId($polizaId);
        $coberturaConcepto = $coberturasConceptosRepositorio->obtenerPorId($coberturaConceptoId);
        $responsabilidades = $responsabilidadesRepositorio->obtenerPorCoberturaConceptoId($coberturaConceptoId);

        if (is_null($responsabilidades)) {
            $responsabilidad = new ResponsabilidadCobertura($coberturaConcepto, $limiteResponsabilidad, $cuotaExtraordinaria);
            $poliza->getCobertura()->agregarResponsabilidad($responsabilidad);

            $cobertura = $poliza->getCobertura();
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('polizas.polizas_resultado_responsabilidades_desglose', compact('cobertura'))->render();

        } else {
            foreach ($responsabilidades as $responsabilidad) {
                if($poliza->getCobertura()->existeResponsabilidad($responsabilidad)) {
                    $respuesta['estatus'] = 'fail';
                    $respuesta['mensaje'] = 'NO SE AGREGÓ LA RESPONSABILIDAD PORQUE YA ESTÁ ASIGNADA A LA COBERTURA.';

                    return response()->json($respuesta);
                }
            }

            $responsabilidad = new ResponsabilidadCobertura($coberturaConcepto, $limiteResponsabilidad, $cuotaExtraordinaria);
            $poliza->getCobertura()->agregarResponsabilidad($responsabilidad);

            $cobertura = $poliza->getCobertura();
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('polizas.polizas_resultado_responsabilidades_desglose', compact('cobertura'))->render();
        }

        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'OCURRIÓ UN ERROR AL GUARDAR LOS CAMBIOS.';
        }

        return response()->json($respuesta);
    }

    /**
     * eliminar una responsabilidad de la cobertura
     * @param Request $request
     * @param ResponsabilidadesRepositorio $responsabilidadesRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminarResponsabilidad(Request $request, ResponsabilidadesRepositorio $responsabilidadesRepositorio)
    {
        $polizaId          = (int)$request->get('polizaId');
        $responsabilidadId = (int)$request->get('responsabilidadId');
        $respuesta         = [];

        $poliza            = $this->polizasRepositorio->obtenerPorId($polizaId);
        $responsabilidad   = $responsabilidadesRepositorio->obtenerPorId($responsabilidadId);

        try {
            $poliza->getCobertura()->eliminarResponsabilidad($responsabilidad);
            $cobertura = $poliza->getCobertura();
            $respuesta['estatus'] = 'OK';
            $respuesta['html']    = view('polizas.polizas_resultado_responsabilidades_desglose', compact('cobertura'))->render();

        } catch (Exception $e) {
            $pdoLogger = new Logger(new Log('exception'), new StreamHandler(storage_path() . '/logs/exceptions/excep_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);

            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = $e->getMessage();

            return response()->json($respuesta);
        }

        if (!$this->polizasRepositorio->persistir($poliza)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'OCURRIÓ UN ERROR AL GUARDAR LOS CAMBIOS.';
        }

        return response()->json($respuesta);
    }
}