<?php
namespace GDI\Aplicacion\Reportes\Caja;

use GDI\Aplicacion\Fecha;
use GDI\Aplicacion\Reportes\ReporteGDI;
use GDI\Dominio\Oficinas\CorteCaja;

class ReporteCorteCaja extends ReporteGDI
{
    /**
     * @var CorteCaja
     */
    private $corte;

    /**
     * ReporteCorteCaja constructor.
     *
     * @param CorteCaja $corte
     */
    public function __construct(CorteCaja $corte)
    {
        $this->corte = $corte;

        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }

    /**
     * generar el reporte
     *
     * @return string
     */
    public function generar()
    {
        // TODO: Implement generar() method.
        $this->SetTitle('Corte de Caja');
        $this->AddPage();

        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 5, 'CORTE DE CAJA', false, true, 'C');

        $this->Ln(8);

        $this->SetFont('helvetica', '', 10);
        $html = '<table><tr>
        <td width="100"><b>AUDITOR:</b></td>
        <td>' . $this->corte->getAuditor()->nombreCompleto() .'</td>
    </tr>
    <tr>
        <td><b>OFICINA:</b></td>
        <td>'. $this->corte->getOficina()->getNombre() .'</td>
    </tr>
    <tr>
        <td><b>FECHA:</b></td>
        <td>'. Fecha::convertir($this->corte->fecha()) .'</td>
    </tr>
</table>';

        $this->writeHTML($html, true, false, false);

        $this->Ln(8);
        $this->SetFont('helvetica', '', 7);

        $html = '<table style="margin: 5px;" cellpadding="5" border="1">
    <thead>
    <tr bgcolor="#c2c2c2">
        <th width="50"><b>FECHA</b></th>
        <th><b>ASOCIADO PROTEGIDO</b></th>
        <th><b>CAJERO</b></th>
        <th><b>COSTO TOTAL</b></th>
        <th><b>FORMA DE PAGO</b></th>
        <th><b>PAGO EFECTIVO</b></th>
        <th><b>PAGO TARJETA</b></th>
        <th><b>PAGO CHEQUE</b></th>
    </tr>
    </thead>
    <tbody>';

        $subtotalEfectivo = $subtotalTarjeta = $subtotalCheque = 0;

        foreach($this->corte->getPolizasPagos() as $polizaPago) {
            $abonoEfectivo = $abonoTarjeta = $abonoCheque = '-';
            if ($polizaPago->esPagoEnEfectivo()) {
                $abonoEfectivo    = $polizaPago->abonoFormateado();
                $subtotalEfectivo += $polizaPago->getAbono();
            }

            if ($polizaPago->esPagoConTarjeta()) {
                $abonoTarjeta    = $polizaPago->abonoFormateado();
                $subtotalTarjeta += $polizaPago->getAbono();
            }

            if ($polizaPago->esPagoConCheque()) {
                $abonoEfectivo    = $polizaPago->abonoFormateado();
                $subtotalCheque += $polizaPago->getAbono();
            }

        $html .= '<tr>
            <td width="50">'. $polizaPago->getPoliza()->getFechaEmision() .'</td>
            <td>'. $polizaPago->getPoliza()->getVehiculo()->getAsociadoProtegido()->nombreCompleto() .'</td>
            <td>'. $polizaPago->getPoliza()->getUsuarioCaptura()->nombreCompleto() .'</td>
            <td>'. $polizaPago->getPoliza()->getCosto()->costoFormateado() .'</td>
            <td>'. $polizaPago->getPoliza()->formaPago() .'</td>
            <td>'. $abonoEfectivo .'</td>
            <td>'. $abonoTarjeta .'</td>
            <td>'. $abonoCheque .'</td>
        </tr>';
    }
        $html .= '</tbody>
<tfoot>
<tr bgcolor="#c2c2c2">
<td colspan="5" align="right"><b>SUBTOTALES:</b></td>
<td><b>$' .number_format($subtotalEfectivo, 2). '</b></td>
<td><b>$' .number_format($subtotalTarjeta, 2). '</b></td>
<td><b>$' .number_format($subtotalCheque, 2). '</b></td>
</tr>
</tfoot>
</table>';

        $this->writeHTML($html, true, false, false);
        $this->Ln(8);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(120, 5, 'TOTAL INGRESOS DEL CORTE:', false, false, 'R');
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0, 5, '$' . number_format($subtotalEfectivo + $subtotalTarjeta + $subtotalCheque, 2), false, true);
        $this->Output('CORTE DE CAJA', 'I');
    }
}