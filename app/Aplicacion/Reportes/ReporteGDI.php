<?php
namespace GDI\Aplicacion\Reportes;

use TCPDF;

/**
 * Class ReporteJohanna
 * @package Siacme\Aplicacion\Reportes
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class ReporteGDI extends TCPDF
{
    /**
     * encabezado de reporte
     */
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, '', false, true, 'R');
        $this->Cell(0, 10, '', false, true, 'R');
        // imagen
        $this->Image(asset('img/logo.png'), 10, 10, 75);
        $this->Ln(25);
    }

    /**
     * pie de reporte, mostrar numero de hojas
     */
    public function Footer() {
        $this->Line(10, 282, 200, 282);
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'B', 8);
        // Page number
        $this->Cell(0, 5, '5a. CALLE PONIENTE SUR No. 127 INT.1 TEL. Y FAX: (01-961) 612-91-36  TEL. (01-961) 612-86-98   E-MAIL: gdipolizas@hotmail.com', false, true);
        $this->Cell(0, 5, 'LADA SIN COSTO 01-800-714-52-70  EN CASO DE SINIESTRO LLAMAR A CABINA 961 23 3 83 88  TUXTLA GUTIÉRREZ, CHIAPAS', false, true);
    }

    /**
     * generar el reporte
     * @return string
     */
    abstract public function generar();
}