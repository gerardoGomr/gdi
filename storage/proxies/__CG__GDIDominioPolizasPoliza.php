<?php

namespace DoctrineProxies\__CG__\GDI\Dominio\Polizas;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Poliza extends \GDI\Dominio\Polizas\Poliza implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'id', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'asociadoAgente', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'vehiculo', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'cobertura', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'fechaEmision', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'fechaVigencia', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'medioPago', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'formaPago', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'estaPagada', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'costo', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'oficina', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'polizaPago'];
        }

        return ['__isInitialized__', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'id', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'asociadoAgente', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'vehiculo', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'cobertura', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'fechaEmision', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'fechaVigencia', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'medioPago', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'formaPago', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'estaPagada', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'costo', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'oficina', '' . "\0" . 'GDI\\Dominio\\Polizas\\Poliza' . "\0" . 'polizaPago'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Poliza $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getMedioPago()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMedioPago', []);

        return parent::getMedioPago();
    }

    /**
     * {@inheritDoc}
     */
    public function getFormaPago()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFormaPago', []);

        return parent::getFormaPago();
    }

    /**
     * {@inheritDoc}
     */
    public function estaPagada()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'estaPagada', []);

        return parent::estaPagada();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getAsociadoAgente()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAsociadoAgente', []);

        return parent::getAsociadoAgente();
    }

    /**
     * {@inheritDoc}
     */
    public function getVehiculo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVehiculo', []);

        return parent::getVehiculo();
    }

    /**
     * {@inheritDoc}
     */
    public function getCobertura()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCobertura', []);

        return parent::getCobertura();
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaEmision()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaEmision', []);

        return parent::getFechaEmision();
    }

    /**
     * {@inheritDoc}
     */
    public function getFechaVigencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFechaVigencia', []);

        return parent::getFechaVigencia();
    }

    /**
     * {@inheritDoc}
     */
    public function getEstaPagada()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEstaPagada', []);

        return parent::getEstaPagada();
    }

    /**
     * {@inheritDoc}
     */
    public function getCosto()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCosto', []);

        return parent::getCosto();
    }

    /**
     * {@inheritDoc}
     */
    public function getOficina()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOficina', []);

        return parent::getOficina();
    }

    /**
     * {@inheritDoc}
     */
    public function generarVigencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'generarVigencia', []);

        return parent::generarVigencia();
    }

    /**
     * {@inheritDoc}
     */
    public function pagar($formaPago, $metodoPago, \GDI\Dominio\Polizas\PolizaPago $polizaPago = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'pagar', [$formaPago, $metodoPago, $polizaPago]);

        return parent::pagar($formaPago, $metodoPago, $polizaPago);
    }

    /**
     * {@inheritDoc}
     */
    public function sePuedeGenerarFormato()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'sePuedeGenerarFormato', []);

        return parent::sePuedeGenerarFormato();
    }

    /**
     * {@inheritDoc}
     */
    public function esPagoParcial()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'esPagoParcial', []);

        return parent::esPagoParcial();
    }

}
