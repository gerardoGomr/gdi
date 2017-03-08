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
                                <form role="form" action="{{ url('polizas/buscar') }}" id="formFiltro" method="post">
                                    <div class="innerAll inner-2x">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="periodo" class="control-label">ESTATUS:</label>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="anio" class="control-label">FECHA EMISIÓN:</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-7">
                                                            <input type="text" name="entreFechaEmision" class="form-control fecha" placeholder="ENTRE FECHA" readonly>
                                                        </div>
                                                        <br><br>
                                                        <div class="col-lg-6 col-md-7">
                                                            <input type="text" name="yFechaEmision" class="form-control fecha" placeholder="Y FECHA" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="anio" class="control-label">FECHA VIGENCIA:</label>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-7">
                                                            <input type="text" name="entreFechaVigencia" class="form-control fecha" placeholder="ENTRE FECHA" readonly>
                                                        </div>
                                                        <br><br>
                                                        <div class="col-lg-6 col-md-7">
                                                            <input type="text" name="yFechaVigencia" class="form-control fecha" placeholder="Y FECHA" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                {{ csrf_field() }}
                                                <button id="buscar" type="button" class="btn btn-primary"><i class="fa fa-search"></i> BUSCAR</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-separator-h"></div>
                                <div class="innerAll">
                                    <a href="{{ url('polizas/registrar') }}" class="btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR NUEVA PÓLIZA</a>
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