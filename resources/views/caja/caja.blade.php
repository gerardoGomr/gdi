@extends('app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h2 class="innerAll"><i class="fa fa-usd"></i> CORTES DE CAJA</h2>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    <a href="#modalNuevoCorte" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR NUEVO CORTE DE CAJA</a>
                                    <div class="separator"></div>
                                    <div id="resultadoBusqueda" data-url="{{ url('caja/cortes') }}">
                                        @include('caja.caja_cortes')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('caja.caja_nuevo_corte')
    @include('caja.caja_corte_detalle')
    @include('loading')
@stop

@section('js')
    <script src="{{ asset('js/caja/caja.js') }}"></script>
@stop