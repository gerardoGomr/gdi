@extends('app')

@section('contenido')
    <div class="row error">
        <div class="col-md-4 col-md-offset-1 center">
            <div class="center">
                <img src="{{ asset('img/error-icon-bucket.png') }}" class="error-icon">
            </div>
        </div>
        <div class="col-md-5 content center">
            <h1 class="strong">LO SENTIMOS</h1>
            <h4 class="innerB">LA PÁGINA SOLICITADA NO EXISTE.</h4>
            <div class="well">
                <a href="{{ url('/') }}" class="btn btn-primary"><i class="fa fa-home"></i> VOLVER A INICIO</a>
            </div>
        </div>
    </div>
@stop