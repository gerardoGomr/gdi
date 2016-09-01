<?php
namespace GDI\Dominio\Coberturas;

/**
 * Class Vigencia
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Vigencia
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $vigencia;

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
    public function getVigencia()
    {
        return $this->vigencia;
    }
}