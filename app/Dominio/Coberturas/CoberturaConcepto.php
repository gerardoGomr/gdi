<?php
namespace GDI\Dominio\Coberturas;

/**
 * Class CoberturaConcepto
 * @package GDI\Dominio\Coberturas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CoberturaConcepto
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $concepto;

	/**
	 * class CoberturaConcepto constructor
	 * @param string $concepto
	 */
	public function __construct($concepto)
	{
		$this->concepto = $concepto;
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
    public function getConcepto()
    {
        return $this->concepto;
    }
}