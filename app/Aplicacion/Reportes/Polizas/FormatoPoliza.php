<?php
namespace GDI\Aplicacion\Reportes\Polizas;

use DateTime;
use GDI\Aplicacion\Fecha;
use GDI\Aplicacion\Reportes\ReporteGDI;
use GDI\Dominio\Polizas\Poliza;

/**
 * Class FormatoPoliza
 * @package GDI\Aplicacion\Reportes\Polizas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class FormatoPoliza extends ReporteGDI
{
    /**
     * @var Poliza
     */
    private $poliza;

    /**
     * @var string
     */
    private $html;

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
     * generar el reporte
     * @return string
     */
    public function generar()
    {
        // TODO: Implement generar() method.
        $this->SetTitle('Formato de póliza');
        $this->AddPage();
        $this->SetFont('helvetica', 'B', 10);
        if ($this->poliza->tienePagoParcial()) {
            $this->SetTextColor(255, 0, 0);
            $this->Cell(0, 5, 'PAGO PARCIAL', false, true, '');
            $this->SetTextColor(0, 0, 0);
            $this->Ln(3);
        }

        $this->SetFillColor(174, 174, 174);
        $this->Cell(0, 5, 'DATOS DEL ASOCIADO PROTEGIDO', true, true, '', true);
        $this->SetFont('helvetica', '', 8);
        $this->generarEstructuraAsociadoProtegido();
        $this->writeHTML($this->html, true, false, false);

        $this->Ln(6);

        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(174, 174, 174);
        $this->Cell(120, 5, 'DATOS DEL VEHICULO', true, false, '', true);
        $this->Cell(60, 5, 'LUGAR Y FECHA DE EXPEDICIÓN', true, true, '', true);
        $this->SetFont('helvetica', '', 7);
        $this->generarEstructuraVehiculo();

        $this->Ln(10);

        $this->SetFont('helvetica', 'B', 10);
        $this->SetFillColor(174, 174, 174);
        $this->Cell(120, 5, 'COBERTURAS CONTRATADAS', true, false, '', true);
        $this->Cell(60, 5, 'COSTO', true, true, '', true);
        $this->SetFont('helvetica', '', 7);
        $this->generarEstructuraCobertura();

        $this->Ln(5);

        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(60);
        $this->MultiCell(0, 5, 'PARA HACER EFECTIVA LAS COBERTURAS CONTRATADAS, SERA NECESARIO QUE SE CUMPLAN CON LAS CONDICIONES GENERALES QUE SE ANEXAN', false, 'R');

        $this->Ln(20);

        $this->Cell(0, 5, 'FUNCIONARIO AUTORIZADO', false, true, 'R');

        $this->Line(150, 225, 198, 225);
        $this->Output('POLIZA', 'I');
    }

    /**
     * construye la sección de asociado protegido
     */
    private function generarEstructuraAsociadoProtegido()
    {
        $this->html = '
            <table style="margin: 5px;"  cellpadding="5">
                <tbody>
                    <tr>
                        <td style="width: 350px; border-left: solid 1px #000000; border-right: solid 1px #000000">
                            <table>
                                <tr>
                                    <td style="width: 25%"><strong>NOMBRE:</strong></td>
                                    <td style="width: 75%;">' . $this->poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() . '</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:160px; border-right: solid 1px #000000">
                            <table>
                                <tr>
                                    <td><strong>PÓLIZA:</strong></td>
                                    <td> ' . $this->poliza->getId() . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 350px; border-left: solid 1px #000000;  border-right: solid 1px #000000">
                            <table>
                                <tr>
                                    <td style="width: 25%"><strong>DIRECCIÓN:</strong></td>
                                    <td style="width: 75%;">' . $this->poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getCalle() . '</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:160px; border-right: solid 1px #000000">
                            <table>
                                <tr>
                                    <td><strong>No. ASOC. PROTEG.:</strong></td>
                                    <td>' . $this->poliza->getVehiculo()->getAsociadoProtegido()->getId() . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 350px; border-left: solid 1px #000000; border-right: solid 1px #000000">
                            <table>
                                <tr>
                                    <td style="width: 25%"><strong>POBLACIÓN:</strong></td>
                                    <td style="width: 75%;">' . $this->poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getUnidadAdministrativa()->getUnidad() . '</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:160px; border-right: solid 1px #000000">
                            <table>
                                <tr>
                                    <td><strong>FORMA DE PAGO:</strong></td>
                                    <td>' . $this->poliza->formaPago() . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 350px; border-left: solid 1px #000000; border-right: solid 1px #000000; border-bottom: solid 1px #000000;">&nbsp;</td>
                        <td style="width:160px; border-right: solid 1px #000000; border-bottom: solid 1px #000000;">
                            <table>
                                <tr>
                                    <td><strong>No. ASOC. COLAB.:</strong></td>
                                    <td>' . $this->poliza->getAsociadoAgente()->getId() . '</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        ';
    }

    /**
     * construye la sección de vehículo
     */
    private function generarEstructuraVehiculo()
    {
        $this->Cell(20, 5, 'MARCA:', 'L', false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getModelo()->getMarca()->getMarca(), false, false, '');
        $this->Cell(40, 5, 'TIPO DE VEHÍCULO:', false, false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getModalidad()->getModalidad(), false, false, '');
        $this->SetFont('helvetica', 'B', 7);
        $this->Cell(60, 5, 'TUXTLA GUTIÉRREZ, CHIAPAS', 'LR', true, 'C');

        $this->SetFont('helvetica', '', 7);
        $this->Cell(20, 5, 'MODELO:', 'L', false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getModelo()->getModelo(), false, false, '');
        $this->Cell(40, 5, 'No. DE SERIE:', false, false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getNumeroSerie(), false, false, '');
        $this->Cell(60, 5, '', 'LR', true, '');

        $this->SetFont('helvetica', '', 7);
        $this->Cell(20, 5, 'PLACAS:', 'L', false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getPlacas(), false, false, '');
        $this->Cell(40, 5, 'No. DE MOTOR:', false, false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getNumeroMotor(), false, false, '');
        $this->Cell(60, 5, '', 'LR', true, '');

        $this->SetFont('helvetica', '', 7);
        $this->Cell(20, 5, 'SERVICIO:', 'LB', false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getServicio()->getServicio(), 'B', false, '');
        $this->Cell(40, 5, 'CAPACIDAD:', 'B', false, '');
        $this->Cell(30, 5, $this->poliza->getVehiculo()->getCapacidad() . ' PASAJEROS', 'B', false, '');
        $this->SetFont('helvetica', 'B', 7);
        $this->Cell(60, 5, Fecha::convertir((new DateTime())->format('Y-m-d')), 'LRB', true, 'C');
    }

    /**
     * construye la sección de coberturas
     */
    private function generarEstructuraCobertura()
    {
        $this->SetFont('helvetica', 'B', 6);

        $this->Cell(50, 5, 'CONCEPTO', 'L', false, '');
        $this->Cell(35, 5, 'LIMITE DE RESPONSABILIDAD', false, false, '');
        $this->Cell(35, 5, 'CUOTA EXTRAORDINARIA', 'R', true);

        $this->SetFont('helvetica', '', 6);

        foreach ($this->poliza->getCobertura()->getResponsabilidades() as $responsabilidades) {
            $this->Cell(50, 5, $responsabilidades->getCoberturaConcepto()->getConcepto(), 'L', false, '');
            $this->Cell(35, 5, $responsabilidades->getLimiteResponsabilidad(), false, false, '');
            $this->Cell(35, 5, $responsabilidades->getCuotaExtraordinaria(), 'R', true);
        }
//        $this->Cell(50, 5, 'DAÑOS MATERIALES:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, 'COSTO:', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, 'ROBO TOTAL:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, '', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, 'R. C. DAÑOS A TERCEROS:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, 'RECARGOS:', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, 'GASTOS MÉDICOS DEL COND. POR ACC. AUT.:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, '', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, 'RESP. CIVIL VIAJERO EN ACC. AUT.:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, 'TOTAL A PAGAR:', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, 'MUERTE AL COND. POR ACC. AUTOM.:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, '', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, 'DEFENSA JURÍDICA:', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, '1er PAGO', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, '', 'L', false, '');
//        $this->Cell(35, 5, '', false, false, '');
//        $this->Cell(35, 5, '', 'R', false, '');
//        $this->Cell(20, 5, '', false, false);
//        $this->Cell(40, 5, '', 'R', true);
//
//        $this->Cell(50, 5, '', 'LB', false, '');
//        $this->Cell(35, 5, '', 'B', false, '');
//        $this->Cell(35, 5, '', 'BR', false, '');
//        $this->Cell(20, 5, '2o PAGO', 'B', false);
//        $this->Cell(40, 5, '', 'RB', true);
    }
}