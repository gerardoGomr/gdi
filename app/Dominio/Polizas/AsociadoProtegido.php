<?php
namespace GDI\Dominio\Polizas;

use GDI\Dominio\Personas\Persona;

/**
 * Class AsociadoProtegido
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class AsociadoProtegido extends Persona
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $rfc;


    private $domicilio;

    /**
     * @var TipoPersona
     */
    private $tipoPersona;
}