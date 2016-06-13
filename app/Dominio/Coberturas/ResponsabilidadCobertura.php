<?php
namespace GDI\Dominio\Coberturas;

/**
 * Class CoberturaConcepto
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ResponsabilidadCobertura
{
	/**
	 * ejemplo: Daños Materiales
	 * @var CoberturaConcepto
	 */
	private $coberturaConcepto;

	/**
	 * ejemplo: Excluido, Hasta xx
	 * @var string
	 */
	private $limiteResponsabilidad;

	/**
	 * @var string
	 */
	private $cuotaExtraordinaria;

	/**
	 * Class ResponsabilidadCobertura constructor
	 * @param CoberturaConcepto $coberturaConcepto
	 * @param string $limiteResponsabilidad
	 * @param string $cuotaExtraordinaria
	 */
	public function __construct(CoberturaConcepto $coberturaConcepto, $limiteResponsabilidad = 'HASTA', $cuotaExtraordinaria = '')
	{
		$this->coberturaConcepto     = $coberturaConcepto;
		$this->limiteResponsabilidad = $limiteResponsabilidad;
		$this->cuotaExtraordinaria   = $cuotaExtraordinaria;
	}


    /**
     * @return CoberturaConcepto
     */
    public function getCoberturaConcepto()
    {
        return $this->coberturaConcepto;
    }

    /**
     * @return string
     */
    public function getLimiteResponsabilidad()
    {
        return $this->limiteResponsabilidad;
    }

    /**
     * @return string
     */
    public function getCuotaExtraordinaria()
    {
        return $this->cuotaExtraordinaria;
    }
}