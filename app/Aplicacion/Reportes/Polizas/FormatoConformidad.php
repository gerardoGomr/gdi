<?php
namespace GDI\Aplicacion\Reportes\Polizas;

use DateTime;
use GDI\Aplicacion\Fecha;
use GDI\Dominio\Polizas\Poliza;
use TCPDF;

/**
 * Class FormatoConformidad
 *
 * @package GDI\Aplicacion\Reportes\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class FormatoConformidad extends TCPDF
{
    /**
     * @var Poliza
     */
    private $poliza;

    /**
     * Poliza constructor.
     * @param Poliza $poliza
     */
    public function __construct(Poliza $poliza)
    {
        $this->poliza = $poliza;
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    /**
     * override parent´s header
     */
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'GRUPO DE DESARROLLO INTEGRAL DE TRANSPORTE; A. C.', false, true, 'R');
        $this->SetFont('helvetica', 'BI', 16);
        $this->Cell(0, 10, 'Su seguridad en el transporte', false, true, 'R');
        // imagen
        $this->Image(asset('img/logo.png'), 10, 20, 75);
        $this->Image(asset('img/logo.png'), 10, 170, 75);
        $this->Ln(25);
    }

    public function Footer() {}

    /**
     * generar el reporte
     *
     * @return string
     */
    public function generar()
    {
        // TODO: Implement generar() method.
        $this->SetTitle('Formato de conformidad');
        $this->AddPage();
        $this->contenidoPrincipal();
        $this->Ln(15);
        $this->Header();
        $this->contenidoPrincipal();
        // linea primera hoja
        $this->Line(70, 125, 140, 125);
        $this->Line(0, 146, 210, 146);
        // linea segunda hoja
        $this->Line(70, 260, 140, 260);
        $this->Output('FORMATO DE CONFORMIDAD', 'I');
    }

    private function contenidoPrincipal()
    {
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, session('usuario')->getOficina()->getNombre() . ', a ' . Fecha::convertir((new DateTime())->format('Y-m-d')), false, true, 'R');
        $this->Ln(5);
        $this->MultiCell(0, 5, $this->textoConformidad(), false, 'J');
        $this->Ln(20);
        $this->Cell(0, 5, 'FIRMA DE CONFORMIDAD', false, true, 'C');
        $this->Cell(0, 5, 'DEL ASOCIADO PROTEGIDO', false, true, 'C');
    }

    /**
     * devuelve el contenido del texto de conformidad, asignando los
     * valores reales de la póliza en cuestión
     *
     * @return string
     */
    private function textoConformidad()
    {
        return "Grupo de Desarrollo Integral del Transporte, A.C.; conviene en otorgar al Asociado Protegido del Certificado de Aceptación " . $this->poliza->getId() . " en dos pagos parciales, siendo el primer pago como mínimo del 50% ($" . $this->poliza->getCostoParcial() . ") y el segundo pago de $" . $this->poliza->getCostoParcial() . " en un lapso no mayor a 30 días naturales en el cual se le entregará al Asociado Protegido el Recibo Fiscal. Si el Asociado Protegido no cumpliera con el segundo pago dentro del plazo convenido en el Certificado de Aceptación quedará cancelado y no se le otorgará reembolso alguno; esto operará a la firma de este documento. En caso de que ocurriera algún siniestro dentro del plazo convenido, el Asociado Protegido se compromete a efectuar el pago total y su deducible correspondiente para que la empresa se haga responsable del siniestro acontecido.\n\nSe firma el presente, quedando sujetos a dar cumplimiento a lo estipulado en el presente documento.";
    }
}