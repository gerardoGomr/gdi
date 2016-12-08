@extends('app')

@section('contenido')
    <div class="row row-app margin-none">
        <div class="col-md-12 col-lg-9">
            <div class="col-separator col-separator-first border-none">
                <div class="col-table">
                    <h4 class="innerAll">AGREGAR NUEVA PÓLIZA</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <form class="form-horizontal" id="formPoliza" action="{{ route('poliza-registrar') }}">
                                    {!! csrf_field() !!}
                                    <div class="innerAll">
                                        <span id="acciones">
                                            <button type="button" id="registrarPoliza" class="btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR PÓLIZA</button>
                                            <a href="{{ url('polizas') }}" class="btn btn-default" id="cancelar"><i class="fa fa-times"></i> CANCELAR REGISTRO</a>
                                        </span>
                                        <div class="separator"></div>
                                        <div class="box-generic padding-none animated fadeInUp" id="busquedaVehiculo">
                                            <h5 class="innerAll border-bottom bg-gray">BÚSQUEDA DE VEHÍCULOS</h5>
                                            <div class="innerAll">
                                                <p class="text-muted">ES NECESARIO QUE ESCRIBA EL NÚMERO DE SERIE O MOTOR DEL VEHÍCULO PARA BUSCARLO DENTRO DEL SISTEMA. UNA VEZ QUE LO ESCRIBA, PRESIONE ENTER.</p>
                                                <div class="separator bottom"></div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="datoVehiculoBuscar">NÚMERO SERIE O MOTOR:</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="datoVehiculoBuscar" id="datoVehiculoBuscar" class="form-control" data-url="{{ url('polizas/vehiculos/buscar') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="registro"></div>

                                        <div id="datosAsociadoAgente" class="hide box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">ASOCIADO AGENTE</h5>
                                            <div class="form-group">
                                                <label class="control-label col-md-3" for="asociadoAgente">NOMBRE:</label>
                                                <div class="col-md-5">
                                                    <select class="form-control" name="asociadoAgente" id="asociadoAgente">
                                                        <option value="">SELECCIONE</option>
                                                        @foreach($asociadosAgentes as $asociadoAgente)
                                                            <option value="{{ $asociadoAgente->getId() }}">{{ $asociadoAgente->nombreCompleto() }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="datosCapturaAsociadoAgente" class="hide">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="nombreAgente">NOMBRE:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="nombreAgente" id="nombreAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="paternoAgente">A. PATERNO:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="paternoAgente" id="paternoAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="maternoAgente">A. MATERNO:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="maternoAgente" id="maternoAgente" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="rfcAgente">RFC:</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="rfcAgente" id="rfcAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="calleAgente">CALLE:</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="calleAgente" id="calleAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="">NÚMEROS:</label>
                                                    <div class="col-md-1">
                                                        <input type="text" name="numExteriorAgente" id="numExteriorAgente" class="form-control" placeholder="Exterior">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <input type="text" name="numInteriorAgente" id="numInteriorAgente" class="form-control" placeholder="Interior">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="coloniaAgente">COLONIA:</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="coloniaAgente" id="coloniaAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="cpAgente">C.P.:</label>
                                                    <div class="col-md-2">
                                                        <input type="text" name="cpAgente" id="cpAgente" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="ciudadAgente">CIUDAD:</label>
                                                    <div class="col-md-5">
                                                        <select name="ciudadAgente" id="ciudadAgente" class="form-control">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="1">TUXTLA GUTIÉRREZ</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="telefonoAgente">TELÉFONO:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="telefonoAgente" id="telefonoAgente" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="celularAgente">CELULAR:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="celularAgente" id="celularAgente" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="emailAgente">EMAIL:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="emailAgente" id="emailAgente" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="polizaNueva" id="polizaNueva">
                                        <input type="hidden" name="asociadoNuevo" id="asociadoNuevo">
                                        <input type="hidden" name="asociadoProtegidoId" id="asociadoProtegidoId">
                                        <input type="hidden" name="vehiculoNuevo" id="vehiculoNuevo">
                                        <input type="hidden" name="coberturaNueva" id="coberturaNueva">
                                        <input type="hidden" id="buscarAsociado" value="0">
                                        <input type="hidden" id="urlPago" value="{{ url('polizas/pagar/') }}">
                                        <input type="hidden" id="urlBuscarPolizaExistente" value="{{ url('polizas/buscar-existente') }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('loading')
    @include('polizas.polizas_resultado_vehiculos')
    @include('polizas.polizas_resultado_asociados')

@stop

@section('js')
    <script src="{{ asset('js/polizas/polizas_registrar.js') }}"></script>
@stop