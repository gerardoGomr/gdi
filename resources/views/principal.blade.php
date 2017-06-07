@extends('app')

@section('contenido')
    @if(session('message'))
        <div class="well">
            <h2 class="innerAll">{{ session('message') }}</h2>
            <a href="/caja/cortes" class="btn btn-success btn-md"><i class="fa fa-arrow-right"></i> IR A MÓDULO DE CORTES DE CAJA.</a>
        </div>
    @endif
@stop