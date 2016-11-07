<?php
namespace GDI\Dominio\Polizas;

use DateInterval;
use DateTime;
use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Coberturas\Costo;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Persona;
use GDI\Dominio\Vehiculos\Vehiculo;

/**
 * Class Poliza
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Poliza
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var AsociadoAgente
     */
    private $asociadoAgente;

    /**
     * @var Vehiculo
     */
    private $vehiculo;

    /**
     * @var Cobertura
     */
    private $cobertura;

    /**
     * @var DateTime
     */
    private $fechaEmision;

    /**
     * @var DateTime
     */
    private $fechaVigencia;

    /**
     * @var int
     */
    private $medioPago;

    /**
     * @var int
     */
    private $formaPago;

    /**
     * @var bool
     */
    private $estaPagada;

    /**
     * @var Costo
     */
    private $costo;

    /**
     * @var Oficina
     */
    private $oficina;

    /**
     * @var PolizaPago
     */
    private $polizaPago;

    /**
     * Class Poliza Constructor
     * @param Vehiculo $vehiculo
     * @param Persona $asociadoAgente
     * @param Cobertura $cobertura
     * @param Costo $costo
     * @param Oficina $oficina
     */
    public function __construct(Vehiculo $vehiculo, Persona $asociadoAgente, Cobertura $cobertura, Costo $costo, Oficina $oficina)
    {
        $this->vehiculo       = $vehiculo;
        $this->asociadoAgente = $asociadoAgente;
        $this->cobertura      = $cobertura;
        $this->costo          = $costo;
        $this->estaPagada     = false;
        $this->oficina        = $oficina;
    }

    /**
     * @return int
     */
    public function getMedioPago()
    {
        return $this->medioPago;
    }

    /**
     * @return int
     */
    public function getFormaPago()
    {
        return $this->formaPago;
    }

    /**
     * @return bool
     */
    public function estaPagada()
    {
        return $this->estaPagada;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return AsociadoAgente
     */
    public function getAsociadoAgente()
    {
        return $this->asociadoAgente;
    }

    /**
     * @return Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * @return Cobertura
     */
    public function getCobertura()
    {
        return $this->cobertura;
    }

    /**
     * @return DateTime
     */
    public function getFechaEmision()
    {
        return $this->fechaEmision;
    }

    /**
     * @return DateTime
     */
    public function getFechaVigencia()
    {
        return $this->fechaVigencia;
    }

    /**
     * @return bool
     */
    public function getEstaPagada()
    {
        return $this->estaPagada;
    }

    /**
     * @return Costo
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * @return Oficina
     */
    public function getOficina()
    {
        return $this->oficina;
    }

    /**
     * calcular la vigencia de la póliza en base al costo seleccionado
     */
    public function generarVigencia()
    {
        $meses = (string)$this->costo->getVigencia()->getVigencia();
        $this->fechaEmision  = new DateTime();
        $this->fechaVigencia = new DateTime();
        $this->fechaVigencia->add(new DateInterval("P$meses".'M'));
    }

    /**
     * evalua la forma de pago y devuelve su representación en cadena
     * @return string
     */
    public function formaPago()
    {
        $formaPago = '';

        switch ($this->formaPago) {
            case FormaPago::CONTADO:
                $formaPago = 'CONTADO';
                break;

            case FormaPago::PARCIAL:
                $formaPago = 'PAGO PARCIAL';
                break;

            case FormaPago::SEMESTRAL:
                $formaPago = 'PAGO SEMESTRAL';
                break;
        }

        return $formaPago;
    }

    /**
     * registrar el pago de la póliza
     * @param $formaPago
     * @param $metodoPago
     * @param PolizaPago|null $polizaPago
     */
    public function pagar($formaPago, $metodoPago, PolizaPago $polizaPago = null)
    {
        $this->formaPago = $formaPago;
        $this->medioPago = $metodoPago;

        if ($this->formaPago === FormaPago::CONTADO) {
            $this->estaPagada = true;
        }

        if ($this->medioPago === MedioPago::EFECTIVO) {
            $this->polizaPago = $polizaPago;
            $this->polizaPago->calcularCambio($this->costo->getCosto());
        }
    }

    public function sePuedeGenerarFormato()
    {
        return $this->estaPagada;
    }

    public function esPagoParcial()
    {
        return $this->formaPago === FormaPago::PARCIAL;
    }
}