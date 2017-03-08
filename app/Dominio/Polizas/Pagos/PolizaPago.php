<?php
namespace GDI\Dominio\Polizas\Pagos;

use DateTime;
use GDI\Dominio\Oficinas\CorteCaja;
use GDI\Dominio\Polizas\MedioPago;
use GDI\Dominio\Polizas\Poliza;

/**
 * Class PolizaPago
 * @package GDI\Dominio\Polizas\Pagos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class PolizaPago
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $fechaPago;

    /**
     * @var int
     */
    protected $metodoPago;

    /**
     * @var double
     */
    protected $costo;

    /**
     * @var double
     */
    protected $abono;

    /**
     * @var double
     */
    protected $pago;

    /**
     * @var double
     */
    protected $cambio;

    /**
     * @var double
     */
    protected $minimoCosto;

    /**
     * @var Poliza
     */
    protected $poliza;

    /**
     * @var CorteCaja
     */
    protected $corteCaja;

    /**
     * PolizaPago constructor.
     * @param int $metodoPago
     */
    public function __construct($metodoPago)
    {
        $this->metodoPago = $metodoPago;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFechaPago()
    {
        return $this->fechaPago->format('d/m/Y');
    }

    /**
     * @return int
     */
    public function getMetodoPago()
    {
        return $this->metodoPago;
    }

    /**
     * @return float
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @return float
     */
    public function getAbono()
    {
        return $this->abono;
    }

    /**
     * @return float
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * @return float
     */
    public function getCambio()
    {
        return $this->cambio;
    }

    /**
     * @return float
     */
    public function getMinimoCosto()
    {
        return $this->minimoCosto;
    }

    /**
     * @return Poliza
     */
    public function getPoliza()
    {
        return $this->poliza;
    }

    /**
     * asignar pago a poliza
     * @param Poliza $poliza
     * @param DateTime $fechaPago
     */
    public function asignadoA(Poliza $poliza, DateTime $fechaPago)
    {
        $this->poliza    = $poliza;
        $this->fechaPago = $fechaPago;
    }

    /**
     * evalúa el medio de pago y devuelve su representación en string
     * @return string
     */
    public function medioPago()
    {
        $medioPago = '';

        switch ($this->metodoPago) {
            case MedioPago::EFECTIVO:
                $medioPago = 'EN EFECTIVO';
                break;

            case MedioPago::TARJETA_CREDITO:
                $medioPago = 'TARJETA DE CRÉDITO';
                break;

            case MedioPago::CHEQUE:
                $medioPago = 'CHEQUE';
                break;
        }

        return $medioPago;
    }

    /**
     * @return CorteCaja
     */
    public function getCorteCaja()
    {
        return $this->corteCaja;
    }

    /**
     * asignar el corte de caja a la póliza actual
     *
     * @param CorteCaja $corteCaja
     */
    public function asignarCorteCaja(CorteCaja $corteCaja)
    {
        $this->corteCaja = $corteCaja;
    }

    /**
     * evalúa si el medio de pago es en efectivo
     *
     * @return bool
     */
    public function esPagoEnEfectivo()
    {
        return $this->metodoPago === MedioPago::EFECTIVO;
    }

    /**
     * evalúa si el medio de pago es con tarjeta
     *
     * @return bool
     */
    public function esPagoConTarjeta()
    {
        return $this->metodoPago === MedioPago::TARJETA_CREDITO;
    }

    /**
     * evalúa si el medio de pago es con cheque
     *
     * @return bool
     */
    public function esPagoConCheque()
    {
        return $this->metodoPago === MedioPago::CHEQUE;
    }

    /**
     * devuelve el abono formateado con number format
     *
     * @return string
     */
    public function abonoFormateado()
    {
        return '$' . number_format($this->abono, 2);
    }
}