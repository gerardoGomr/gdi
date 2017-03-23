<?php
namespace GDI\Dominio\Oficinas;

use DateTime;
use GDI\Dominio\Listas\IColeccion;
use GDI\Dominio\Usuarios\Usuario;

/**
 * Class CorteCaja
 * @package GDI\Dominio\Oficinas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CorteCaja
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var IColeccion
     */
    private $polizasPagos;

    /**
     * @var Usuario
     */
    private $auditor;

    /**
     * @var DateTime
     */
    private $fecha;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * CorteCaja constructor.
     *
     * @param IColeccion $polizasPagos
     * @param Usuario $auditor
     * @param DateTime $fecha
     * @param Oficina $oficina
     */
    public function __construct(IColeccion $polizasPagos, Usuario $auditor, DateTime $fecha, Oficina $oficina)
    {
        $this->polizasPagos = $polizasPagos;
        $this->auditor      = $auditor;
        $this->fecha        = $fecha;
        $this->oficina      = $oficina;

        $this->asignarCorteAPolizasPagos();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return IColeccion
     */
    public function getPolizasPagos()
    {
        return $this->polizasPagos;
    }

    /**
     * @return Usuario
     */
    public function getAuditor()
    {
        return $this->auditor;
    }

    /**
     * @return DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * devolver la fecha en formato dia/mes/año
     *
     * @return string
     */
    public function fecha()
    {
        return $this->fecha->format('Y-m-d');
    }

    /**
     * devuelve la cantidad de pólizas registradas en el corte
     *
     * @return int
     */
    public function cantidadPolizas()
    {
        return $this->polizasPagos->count();
    }

    /**
     * asignar el corte de caja a las pólizas
     */
    private function asignarCorteAPolizasPagos()
    {
        foreach ($this->polizasPagos as $polizaPago) {
            $polizaPago->asignarCorteCaja($this);
        }
    }
}