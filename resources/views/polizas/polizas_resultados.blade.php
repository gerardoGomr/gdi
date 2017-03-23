<?php
use GDI\Aplicacion\Fecha;
?>
@if(count($polizas) > 0)
    <table class="table table-bordered text-small" id="tablaPolizas" style="font-size: 10px;">
        <thead>
        <tr class="bg-primary">
            <th>No.</th>
            <th>FECHA EXPEDICIÓN</th>
            <th>ASOCIADO PROTEGIDO</th>
            <th>VEHICULO</th>
            <th>COSTO</th>
            <th>VIGENCIA</th>
            <th>SERVICIO</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($polizas as $poliza)
            <tr>
                <td>{{ $poliza->numero() }}</td>
                <td>{{ Fecha::convertir($poliza->getFechaEmision()) }}</td>
                <td>{{ $poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}</td>
                <td>{{ $poliza->getVehiculo()->detalles() }}</td>
                <td>{{ $poliza->getCosto()->costoFormateado() }}</td>
                <td>{{ $poliza->getCosto()->getVigencia()->getVigencia() }} MESES</td>
                <td>{{ $poliza->getCobertura()->getServicio()->getServicio() }}</td>
                <td>
                    <div class="btn-group" role="group">
                        @if($poliza->sePuedenActualizarDatos())
                            <a href="{{ url('polizas/editar/' . base64_encode($poliza->getId())) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-original-title="ACTUALIZAR DATOS"><i class="fa fa-edit"></i></a>
                        @endif
                        @if($poliza->sePuedeGenerarFormato())
                            <a href="{{ url('polizas/formato/' . base64_encode($poliza->getId())) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="IMPRIMIR FORMATO" target="_blank"><i class="fa fa-print"></i></a>
                        @else
                            <a href="{{ url('polizas/pagar/' . base64_encode($poliza->getId())) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="PAGAR PÓLIZA"><i class="fa fa-dollar"></i></a>
                            @if($poliza->tienePagoParcial())
                                <a href="{{ url('polizas/formato-parcial/' . base64_encode($poliza->getId())) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="IMPRIMIR FORMATO PARCIAL" target="_blank"><i class="fa fa-print"></i></a>
                            @endif
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p class="text-medium center text-primary">NO SE ENCONTRARON RESULTADOS</p>
@endif