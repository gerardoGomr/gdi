<?php
namespace GDI\Http\Controllers\Coberturas;

use Exception;
use GDI\Aplicacion\Factories\ResponsabilidadesFactory;
use GDI\Aplicacion\Logger;
use GDI\Dominio\Coberturas\Repositorios\CoberturasConceptosRepositorio;
use GDI\Dominio\Coberturas\Repositorios\CoberturasRepositorio;
use GDI\Dominio\Coberturas\Repositorios\ResponsabilidadesRepositorio;
use Illuminate\Http\Request;
use GDI\Http\Requests;
use GDI\Http\Controllers\Controller;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Log;

/**
 * Class CoberturasController
 * @package GDI\Http\Controllers\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CoberturasController extends Controller
{
    /**
     * @var int
     */
    private $oficinaId;

    /**
     * @var ResponsabilidadesRepositorio
     */
    private $responsabilidadesRepositorio;

    /**
     * @var CoberturasRepositorio
     */
    private $coberturasRepositorio;

    /**
     * CoberturasController constructor.
     */
    public function __construct(ResponsabilidadesRepositorio $responsabilidadesRepositorio, CoberturasRepositorio $coberturasRepositorio)
    {
        $this->oficinaId                    = request()->session()->get('usuario')->getOficina()->getId();
        $this->responsabilidadesRepositorio = $responsabilidadesRepositorio;
        $this->coberturasRepositorio        = $coberturasRepositorio;
    }

    /**
     * agregar una nueva responsabilidad a la cobertura de la póliza especificada
     * @param Request $request
     * @param CoberturasConceptosRepositorio $coberturasConceptosRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function agregarResponsabilidad(Request $request, CoberturasConceptosRepositorio $coberturasConceptosRepositorio)
    {
        $coberturaId           = (int)$request->get('coberturaId');
        $coberturaConceptoId   = (int)$request->get('coberturaConceptoId');
        $respuesta             = ['estatus' => 'OK'];

        // transformar a a mayusculas
        $this->transformarMayusculas($request);

        $cobertura         = $this->coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId);
        $coberturaConcepto = $coberturasConceptosRepositorio->obtenerPorId($coberturaConceptoId);
        $responsabilidad   = ResponsabilidadesFactory::crear($request, $coberturaConcepto, $this->responsabilidadesRepositorio);

        if ($cobertura->existeResponsabilidad($responsabilidad)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'NO SE AGREGÓ LA RESPONSABILIDAD PORQUE YA ESTÁ ASIGNADA A LA COBERTURA.';

            return response()->json($respuesta);
        }

        $cobertura->agregarResponsabilidad($responsabilidad);

        if (!$this->coberturasRepositorio->persistir($cobertura)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'OCURRIÓ UN ERROR AL GUARDAR LOS CAMBIOS.';
        }

        $respuesta['html']    = view('polizas.polizas_resultado_responsabilidades_desglose', compact('cobertura'))->render();

        return response()->json($respuesta);
    }

    /**
     * eliminar una responsabilidad de la cobertura
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminarResponsabilidad(Request $request)
    {
        $coberturaId       = (int)$request->get('coberturaId');
        $responsabilidadId = (int)$request->get('responsabilidadId');
        $respuesta         = ['estatus' => 'OK'];

        $cobertura         = $this->coberturasRepositorio->obtenerPorId($coberturaId, $this->oficinaId);
        $responsabilidad   = $this->responsabilidadesRepositorio->obtenerPorId($responsabilidadId);

        try {
            $cobertura->eliminarResponsabilidad($responsabilidad);
            $respuesta['html'] = view('polizas.polizas_resultado_responsabilidades_desglose', compact('cobertura'))->render();

        } catch (Exception $e) {
            $pdoLogger = new Logger(new Log('exception'), new StreamHandler(storage_path() . '/logs/exceptions/excep_' . date('Y-m-d') . '.log', Log::ERROR));
            $pdoLogger->log($e);

            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = $e->getMessage();

            return response()->json($respuesta);
        }

        if (!$this->coberturasRepositorio->persistir($cobertura)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'OCURRIÓ UN ERROR AL GUARDAR LOS CAMBIOS.';
        }

        return response()->json($respuesta);
    }
}
