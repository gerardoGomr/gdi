<?php

namespace GDI\Jobs;

use DateTime;
use GDI\Dominio\Oficinas\Repositorios\OficinasRepositorio;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class GenerarReporteComisionesJob
 *
 * Este Job genera reportes de comisiones por quincena y por sucursales de GDI
 *
 * @package GDI\Jobs
 * @author Gerardo Adrián Gómez Ruiz <gerardo.gomr@gmail.com>
 */
class GenerarReporteComisionesJob
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var OficinasRepositorio
     */
    private $oficinasRepositorio;

    private $fechaInicial;

    private $fechaFinal;

    /**
     * Create a new job instance.
     *
     * @param OficinasRepositorio $oficinasRepositorio
     * @param DateTime $fechaInicial La fecha inicial de la quincena
     * @param DateTime $fechaFinal La fecha final de la quincena
     */
    public function __construct(OficinasRepositorio $oficinasRepositorio, DateTime $fechaInicial, DateTime $fechaFinal)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $oficinas = $this->oficinasRepositorio->obtenerOficinasConAsociadosYPolizasDeLaQuincena($this->fechaInicial, $this->fechaFinal);

        foreach ($oficinas as $oficina) {
            // crear nuevo reporte
            // construir reporte
            // grabar reporte en DB y en storage
        }
    }
}
