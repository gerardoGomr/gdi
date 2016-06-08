<?php
namespace GDI\Dominio\Polizas;

use GDI\Dominio\Personas\Domicilio;
use GDI\Dominio\Personas\Persona;

/**
 * Class AsociadoAgente
 * @package GDI\Dominio\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class AsociadoAgente extends Persona
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Domicilio
     */
    private $domicilio;

    /**
     * AsociadoAgente constructor.
     * @param int $id
     * @param Domicilio $domicilio
     * @param null $nombre
     * @param null $paterno
     * @param null $materno
     */
    public function __construct($id = 0, Domicilio $domicilio = null, $nombre = null, $paterno = null, $materno = null)
    {
        $this->id        = $id;
        $this->domicilio = $domicilio;

        parent::__construct($nombre, $paterno, $materno);
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }
}