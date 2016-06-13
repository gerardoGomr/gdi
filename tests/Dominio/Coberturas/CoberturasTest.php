<?php

use GDI\Dominio\Coberturas\Cobertura;
use GDI\Dominio\Coberturas\CoberturaTipo;
use GDI\Dominio\Coberturas\CoberturaConcepto;
use GDI\Dominio\Coberturas\ResponsabilidadCobertura;
use GDI\Dominio\Polizas\Servicio;
use GDI\Aplicacion\Coleccion;

class CoberturasTest extends PHPUnit_Framework_TestCase
{
	public function testSePuedeAgregarResponsabilidadDaniosMaterialesACoberturaLocal()
	{
		$cobertura = new Cobertura('Local default', new CoberturaTipo(CoberturaTipo::LOCAL), new Servicio(Servicio::FEDERAL), new Coleccion());
		$responsabilidad = new ResponsabilidadCobertura(new CoberturaConcepto('R.C. Viajero'), 'HASTA 1, 500 D.S.M.V.G.D.F.');

		//$this->assertEquals(CoberturaTipo::LOCAL, $cobertura->getCoberturaTipo());
		$cobertura->agregarResponsabilidad($responsabilidad);
	}

	public function testSePuedeAgregarResponsabilidadDaniosMaterialesACoberturaBasica()
	{
		$cobertura = new Cobertura('Básica default', new CoberturaTipo(CoberturaTipo::BASICA), new Servicio(Servicio::FEDERAL), new Coleccion());
		$responsabilidad = new ResponsabilidadCobertura(new CoberturaConcepto('R.C. Daños a Terceros'), 'HASTA 1, 500 D.S.M.V.G.D.F.');

		//$this->assertEquals(CoberturaTipo::LOCAL, $cobertura->getCoberturaTipo());
		$cobertura->agregarResponsabilidad($responsabilidad);
	}

	public function testSePuedeAgregarCualquierResponsabilidadACoberturaAmplia()
	{
		$cobertura = new Cobertura('Amplia default', new CoberturaTipo(CoberturaTipo::AMPLIA), new Servicio(Servicio::FEDERAL), new Coleccion());
		$responsabilidad = new ResponsabilidadCobertura(new CoberturaConcepto('Asesoría Jurídica'), 'HASTA 1, 500 D.S.M.V.G.D.F.');

		//$this->assertEquals(CoberturaTipo::LOCAL, $cobertura->getCoberturaTipo());
		$cobertura->agregarResponsabilidad($responsabilidad);
	}
}