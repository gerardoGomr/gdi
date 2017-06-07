<?php

namespace GDI\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // validar el día actual
        // si es 15 o (28, 29, 30, 31 dependiendo el mes)
        // generar un nuevo reporte de comisiones
        // con un dispatch()->onConnection(sync)
        // $job = new GenerarReporteComisionesJob(new DoctrineOficinasRepositorio, 2)
    }
}