<?php

namespace GDI\Http\Middleware;

use Closure;
use DateInterval;
use DateTime;
use GDI\Dominio\Oficinas\Repositorios\CortesCajaRepositorio;

/**
 * Middleware empleado para verificar que exista un corte de caja del día anterior
 *
 * @package GDI\Http\Middleware
 * @author Gerardo Adrián Gómez Ruiz <gerardo.gomr@gmail.com>
 */
class VerificadorCortesCaja
{
    /**
     * @var CortesCajaRepositorio
     */
    private $cortesCajaRepositorio;

    /**
     * VerificadorCortesCaja constructor.
     *
     * @param CortesCajaRepositorio $cortesCajaRepositorio
     */
    public function __construct(CortesCajaRepositorio $cortesCajaRepositorio)
    {
        $this->cortesCajaRepositorio = $cortesCajaRepositorio;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $fecha     = new DateTime();
        $fecha->sub(new DateInterval('P1D'));

        $cortesCaja = $this->cortesCajaRepositorio->obtenerPorFecha($fecha);

        if (is_null($cortesCaja)) {
            return redirect('home')->with(['message' => 'ANTES DE CONTINUAR, POR FAVOR, REALICE EL CORTE DE CAJA DEL DÍA ANTERIOR.']);
        }

        return $next($request);
    }
}
