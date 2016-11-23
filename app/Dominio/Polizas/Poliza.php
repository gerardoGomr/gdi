<?php
namespace GDI\Dominio\Polizas;

use DateInterval;
use DateTime;
use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Coberturas\Costo;
use GDI\Dominio\Oficinas\Oficina;
use GDI\Dominio\Personas\Persona;
use GDI\Dominio\Polizas\Pagos\IPolizaPago;
use GDI\Dominio\Vehiculos\Vehiculo;
use GDI\Dominio\Listas\IColeccion;

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
    private $formaPago;

    /**
     * @var DateTime
     */
    private $fechaProximoPago;

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
     * @var IColeccion
     */
    private $pagos;

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
     * @return string
     */
    public function getFechaProximoPago()
    {
        return $this->fechaProximoPago->format('d/m/Y');
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
     * inicializar pagos
     * @param IColeccion $pagos
     */
    public function inicializarPagos(IColeccion $pagos)
    {
        if(is_null($this->pagos)) {
            $this->pagos = $pagos;
        }
    }

    /**
     * verifica si tiene activo el pago parcial o semestral
     * @return bool
     */
    public function tienePagoParcial()
    {
        if (!$this->estaPagada) {
            if ($this->formaPago === FormaPago::PARCIAL || $this->formaPago === FormaPago::SEMESTRAL) {
                if ($this->pagos->count() > 0) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * registrar el pago de la póliza
     * @param IPolizaPago $polizaPago
     * @param int|null $formaPago
     */
    public function pagar(IPolizaPago $polizaPago, $formaPago = null)
    {
        if (!is_null($formaPago)) {
            $this->formaPago  = $formaPago;
        }

        $polizaPago->asignadoA($this, new DateTime());
        $polizaPago->registrarPago();

        // se marca la poliza como pagada si es de contado
        if ($this->formaPago === FormaPago::CONTADO) {
            $this->estaPagada = true;
        }

        if ($this->tienePagoParcial()) {
            $this->estaPagada = true;

        } else {
            // calcular la fecha del siguiente pago
            if ($this->formaPago === FormaPago::PARCIAL) {
                $this->fechaProximoPago = new DateTime();

                // 30 DÍAS
                $this->fechaProximoPago->add(new DateInterval('P30D'));
            }

            if ($this->formaPago === FormaPago::SEMESTRAL) {
                $this->fechaProximoPago = new DateTime();

                // 6 MESES
                $this->fechaProximoPago->add(new DateInterval('P6M'));
            }
        }

        $this->pagos->add($polizaPago);
    }

    /**
     * verifica si se puede generar el formato de póliza
     * @return bool
     */
    public function sePuedeGenerarFormato()
    {
        return $this->estaPagada;
    }

    /**
     * verifica que sea de tipo pago parcial o semestral
     * @return bool
     */
    public function esPagoParcial()
    {
        return $this->formaPago === FormaPago::PARCIAL || $this->formaPago === FormaPago::SEMESTRAL;
    }

    /**
     * @return IColeccion
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * devuelve el saldo a pagar
     * @return double
     */
    public function obtenerSaldo()
    {
        $saldo = $this->costo->getCosto();

        if ($this->esPagoParcial()) {
            foreach ($this->pagos as $polizaPago) {
                $saldo -= $polizaPago->getAbono();
            }

            return $saldo;
        }
    }

    /**
     * saldo a pagar formateado
     * @return string
     */
    public function saldoFormateado()
    {
        return '$' . number_format($this->obtenerSaldo(), 2);
    }

    /**
     * evalúa si la póliz está vigente o no
     * @return bool
     */
    public function vigente()
    {
        $fechaHoy = new DateTime();

        return $fechaHoy <= $this->fechaVigencia;
    }
}