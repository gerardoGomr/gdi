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
use GDI\Exceptions\NuevoCostoEsMenorAlCostoDePolizaException;

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
     * @var bool
     */
    private $activa;

    /**
     * @var double
     */
    private $costoDiferencia;

    /**
     * @var string
     */
    private $observaciones;

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
        $this->activa         = true;
        $this->oficina        = $oficina;
    }

    /**
     * devolver el numero de póliza rellenado con ceros
     * @return string
     */
    public function numero()
    {
        $id         = (string)$this->id;
        $longitudId = strlen($id);
        $max        = 4;
        $numero     = '';

        $diferencia = $max - $longitudId;

        for ($i = 0; $i < $diferencia; $i++) {
            $numero .= '0';
        }

        $numero .= $id;

        return $numero;
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
        return $this->fechaEmision->format('Y-m-d');
    }

    /**
     * @return DateTime
     */
    public function getFechaVigencia()
    {
        return $this->fechaVigencia->format('Y-m-d');
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
     * @return boolean
     */
    public function estaActiva()
    {
        return $this->activa;
    }

    /**
     * @return float
     */
    public function getCostoDiferencia()
    {
        return $this->costoDiferencia;
    }

    /**
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
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

    /**
     * verifica si está dentro del periodo apto para renovar, que es menor igual a 30 días
     * @return bool
     */
    public function estaDentroDePeriodoAptoParaRenovar()
    {
        $fechaHoy  = new DateTime();
        $intervalo = $this->fechaVigencia->diff($fechaHoy);

        return $intervalo->days <= 30;
    }

    /**
     * verifica si está dentro del periodo apto para actualizar datos, que debe ser menor o igual a 90 días
     * @return bool
     */
    public function sePuedenActualizarDatos()
    {
        $fechaHoy  = new DateTime();
        $intervalo = $fechaHoy->diff($this->fechaEmision);

        return $intervalo->days <= 90;
    }

    /**
     * setear nuevamente los datos de la póliza
     * @param Vehiculo $vehiculo
     * @param Persona $asociadoAgente
     * @param Cobertura $cobertura
     * @param Costo $costo
     * @param Oficina $oficina
     * @throws NuevoCostoEsMenorAlCostoDePolizaException
     */
    public function actualizar(Vehiculo $vehiculo, Persona $asociadoAgente, Cobertura $cobertura, Costo $costo, Oficina $oficina)
    {
        if ($costo->getCosto() < $this->costo->getCosto()) {
            throw new NuevoCostoEsMenorAlCostoDePolizaException('EL COSTO GENERADO PARA LA PÓLIZA ES MENOR AL COSTO ACTUALMENTE ASIGNADO.');
        }
        
        if ($costo->getCosto() > $this->costo->getCosto()) {
            // el costo es mayor, por lo tanto activar bandera de pago diferencia y campo observaciones
            $this->costoDiferencia = $costo->getCosto() - $this->costo->getCosto();
            $this->observaciones   = 'SE OTORGA UN COSTO DE $' . (string)number_format($this->costoDiferencia, 2) . ' DEBIDO A QUE SE MODIFICÓ EL COSTO ASIGNADO A LA PÓLIZA. EL COSTO ORIGINAL ERA DE ' . $this->costo->costoFormateado() . ' Y SE ASIGNÓ UN NUEVO COSTO DE ' . $costo->costoFormateado();

            $this->estaPagada = false;
        }
        
        $this->vehiculo       = $vehiculo;
        $this->asociadoAgente = $asociadoAgente;
        $this->cobertura      = $cobertura;
        $this->costo          = $costo;
        $this->oficina        = $oficina;
    }

    /**
     * devuelve true si se modifica el costo de la póliza
     * @return bool
     */
    public function seActualizoPago()
    {
        return !is_null($this->costoDiferencia) && !$this->estaPagada;
    }

    /**
     * obtener el costo parcial de la póliza
     *
     * @return float
     */
    public function getCostoParcial()
    {
        return $this->costo->getCosto() * 0.5;
    }
}