<?php
namespace GDI\Dominio\Personas;

/**
 * Class Domicilio
 * @package GDI\Dominio\Personas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Domicilio
{
    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $noExterior;

    /**
     * @var string
     */
    private $noInterior;

    /**
     * @var string
     */
    private $localidadColonia;

    /**
     * @var string
     */
    private $ciudad;

    /**
     * @var EntidadFederativa
     */
    private $estado;

    /**
     * @var string
     */
    private $codigoPostal;

    /**
     * Domicilio constructor.
     * @param string $calle
     * @param string $noExterior
     * @param string $noInterior
     * @param string $localidadColonia
     * @param string $codigoPostal
     * @param null $ciudad
     * @param EntidadFederativa $estado
     */
    public function __construct($calle = null, $noExterior = null, $noInterior = null, $localidadColonia = null, $codigoPostal = null, $ciudad = null, EntidadFederativa $estado = null)
    {
        $this->calle            = $calle;
        $this->noExterior       = $noExterior;
        $this->noInterior       = $noInterior;
        $this->localidadColonia = $localidadColonia;
        $this->codigoPostal     = $codigoPostal;
        $this->ciudad           = $ciudad;
        $this->estado           = $estado;
    }

    /**
     * @return string
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * @return string
     */
    public function getNoExterior()
    {
        return $this->noExterior;
    }

    /**
     * @return string
     */
    public function getNoInterior()
    {
        return $this->noInterior;
    }

    /**
     * @return string
     */
    public function getLocalidadColonia()
    {
        return $this->localidadColonia;
    }

    /**
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * @return EntidadFederativa
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * retorna el domicilio completo del asociado protegido
     * @return null|string
     */
    public function direccionCompleta()
    {
        $direccion = $this->calle;

        if (strlen($this->noExterior)) {
            $direccion .= ' ' . $this->noExterior;
        }

        if (strlen($this->noInterior)) {
            $direccion .= ' ' . $this->noInterior;
        }

        if (strlen($this->localidadColonia)) {
            $direccion .= ' ' . $this->localidadColonia;
        }

        if (strlen($this->codigoPostal)) {
            $direccion .= ' C. P. ' . $this->codigoPostal;
        }

        if (strlen($this->ciudad)) {
            $direccion .= ' ' . $this->ciudad;
        }

        if (!is_null($this->estado)) {
            $direccion .= ', ' . $this->nombreEstado();
        }

        return $direccion;
    }

    /**
     * comparar valor de estado y devolver su representación en cadena
     * @return string
     */
    private function nombreEstado()
    {
        $nombre = '';
        switch ($this->estado) {
            case EntidadFederativa::AGUASCALIENTES:
                $nombre = 'AGUASCALIENTES';
            break;

            case EntidadFederativa::BAJA_CALIFORNIA:
                $nombre = 'BAJA CALIFORNIA';
            break;

            case EntidadFederativa::BAJA_CALIFORNIA_SUR:
                $nombre = 'BAJA CALIFORNIA SUR';
            break;

            case EntidadFederativa::CAMPECHE:
                $nombre = 'CAMPECHE';
            break;

            case EntidadFederativa::CHIAPAS:
                $nombre = 'CHIAPAS';
            break;

            case EntidadFederativa::CHIHUAHUA:
                $nombre = 'CHIHUAHUA';
            break;

            case EntidadFederativa::CIUDAD_DE_MEXICO:
                $nombre = 'CIUDAD DE MÉXICO';
            break;

            case EntidadFederativa::COLIMA:
                $nombre = 'COLIMA';
            break;

            case EntidadFederativa::DURANGO:
                $nombre = 'DURANGO';
            break;

            case EntidadFederativa::ESTADO_DE_MEXICO:
                $nombre = 'ESTADO DE MÉXICO';
            break;

            case EntidadFederativa::GUANAJUATO:
                $nombre = 'GUANAJUATO';
            break;

            case EntidadFederativa::GUERRERO:
                $nombre = 'GUERRERO';
            break;

            case EntidadFederativa::HIDALGO:
                $nombre = 'HIDALGO';
            break;

            case EntidadFederativa::JALISCO:
                $nombre = 'JALISCO';
            break;

            case EntidadFederativa::MICHOACAN:
                $nombre = 'MICHOACÁN';
            break;

            case EntidadFederativa::MORELOS:
                $nombre = 'MORELOS';
            break;

            case EntidadFederativa::NAYARIT:
                $nombre = 'NAYARIT';
            break;

            case EntidadFederativa::NUEVO_LEON:
                $nombre = 'NUEVO LEÓN';
            break;

            case EntidadFederativa::OAXACA:
                $nombre = 'OAXACA';
            break;

            case EntidadFederativa::PUEBLA:
                $nombre = 'PUEBLA';
            break;

            case EntidadFederativa::QUERETARO:
                $nombre = 'QUERÉTARO';
            break;

            case EntidadFederativa::QUINTANA_ROO:
                $nombre = 'QUINTANA ROO';
            break;

            case EntidadFederativa::SAN_LUIS_POTOSI:
                $nombre = 'SAN_LUIS_POTOSÍ';
            break;

            case EntidadFederativa::SINALOA:
                $nombre = 'SINALOA';
            break;

            case EntidadFederativa::SONORA:
                $nombre = 'SONORA';
            break;

            case EntidadFederativa::TABASCO:
                $nombre = 'TABASCO';
            break;

            case EntidadFederativa::TAMAULIPAS:
                $nombre = 'TAMAULIPAS';
            break;

            case EntidadFederativa::TLAXCALA:
                $nombre = 'TLAXCALA';
            break;

            case EntidadFederativa::VERACRUZ:
                $nombre = 'VERACRUZ';
            break;

            case EntidadFederativa::YUCATAN:
                $nombre = 'YUCATÁN';
            break;

            default:
                $nombre = 'CHIAPAS';
                break;
        }

        return $nombre;
    }
}