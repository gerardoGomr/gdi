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
                                    @if(count($polizas) > 0)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>ASOCIADO</th>
                                                    <th>VEHICULO</th>
                                                    <th>COSTO</th>
                                                    <th>VIGENCIA</th>
                                                    <th>SERVICIO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($polizas as $poliza)
                                                    <tr>
                                                        <td>{{ $poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}</td>
                                                        <td>{{ $poliza->getVehiculo()->detalles() }}</td>
                                                        <td>${{ number_format($poliza->getCosto()->getCosto(), 2) }}</td>
                                                        <td>{{ $poliza->getCosto()->getVigencia()->getVigencia() }} MESES</td>
                                                        <td>{{ $poliza->getVehiculo()->getServicio()->getServicio() }}</td>
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
    <script src="{{ asset('js/polizas.js') }}"></script>
@stop