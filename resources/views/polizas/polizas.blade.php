@extends('app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h2 class="innerAll"><i class="fa fa-list"></i> PÓLIZAS REGISTRADAS</h2>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <h4 class="innerAll bg-gray border-bottom margin-bottom-none">REGISTRO DE POLIZAS</h4>
                                <div class="innerAll">
                                    <a href="{{ url('polizas/registrar') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR NUEVA PÓLIZA</a>
                                    <button type="button" id="abrirBuscador" class="btn btn-default"><i class="fa fa-search"></i> MOSTRAR BÚSQUEDA AVANZADA</button>
                                    <button type="button" id="cerrarBuscador" class="btn btn-default hide"><i class="fa fa-minus"></i> OCULTAR BÚSQUEDA AVANZADA</button>
                                </div>

                                <form role="form" action="{{ url('polizas/buscar') }}" id="formFiltro" method="post" class="form-horizontal hide">
                                    {{ csrf_field() }}
                                    <div class="innerAll inner-2x">
                                        <div class="form-group">
                                            <label for="estatusPoliza" class="control-label col-md-3 col-lg-2">ESTATUS:</label>
                                            <div class="col-md-4 col-lg-3">
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="estatusPoliza" value="1"> ACTIVAS
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="estatusPoliza" value="0"> CANCELADAS
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="control-label col-md-3 col-lg-2">FECHA EMISIÓN:</label>
                                            <div class="col-md-2">
                                                <input type="text" name="entreFechaEmision" class="form-control fecha" placeholder="ENTRE FECHA" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="yFechaEmision" class="form-control fecha" placeholder="Y FECHA" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="" class="control-label col-md-3 col-lg-2">FECHA VIGENCIA:</label>
                                            <div class="col-md-2">
                                                <input type="text" name="entreFechaVigencia" class="form-control fecha" placeholder="ENTRE FECHA" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="yFechaVigencia" class="form-control fecha" placeholder="Y FECHA" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-offset-3 col-lg-offset-2">
                                                <button id="buscar" type="button" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="innerAll">
                                    <div class="separator"></div>
                                    <div id="resultadoBusqueda">
                                        @include('polizas.polizas_resultados')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@include('loading')

@section('js')
    <script src="{{ asset('js/polizas/polizas.js') }}"></script>
@stop