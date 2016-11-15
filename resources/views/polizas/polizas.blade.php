@extends('app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h2 class="innerAll">PÓLIZAS REGISTRADAS</h2>

                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    <a href="{{ url('polizas/registrar') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> Registrar nueva póliza</a>
                                    <div class="separator bottom"></div>
                                    <div class="separator bottom"></div>
                                    @if(count($polizas) > 0)
                                        <table class="table table-bordered" id="tablaPolizas">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>ASOCIADO</th>
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
                                                        <td>{{ $poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}</td>
                                                        <td>{{ $poliza->getVehiculo()->detalles() }}</td>
                                                        <td>{{ $poliza->getCosto()->costoFormateado() }}</td>
                                                        <td>{{ $poliza->getCosto()->getVigencia()->getVigencia() }} MESES</td>
                                                        <td>{{ $poliza->getVehiculo()->getServicio()->getServicio() }}</td>
                                                        <td>
                                                            @if($poliza->sePuedeGenerarFormato())
                                                                <a href="" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Imprimir formato"><i class="fa fa-print"></i></a>
                                                            @else
                                                                <a href="{{ url('polizas/pagar/' . base64_encode($poliza->getId())) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Pagar póliza"><i class="fa fa-dollar"></i></a>
                                                                @if($poliza->tienePagoParcial())
                                                                    <a href="" class="btn btn-warning btn-sm" data-toggle="tooltip" data-original-title="Imprimir formato parcial"><i class="fa fa-print"></i></a>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p class="text-medium center text-primary">SIN PÓLIZAS REGISTRADAS</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/polizas/polizas.js') }}"></script>
@stop