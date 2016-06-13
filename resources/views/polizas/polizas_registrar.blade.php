@extends('app')

@section('contenido')
    <div class="row row-app margin-none">
        <div class="col-md-12">
            <div class="col-separator col-separator-first border-none">
                <div class="col-table">
                    <h4 class="innerAll">Agregar nueva póliza</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <form class="form-horizontal">
                                    <div class="innerAll">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-6">
                                                <div class="box-generic">
                                                    <h4 class="innerAll border-bottom">Buscar vehículos asociados a pólizas.</h4>
                                                    <div class="form-group">
                                                        <div class="col-md-10 col-md-offset-1">
                                                            <input type="text" name="datoVehiculo" id="datoVehiculo" class="form-control" placeholder="Escriba el número de serie o número de motor y presion ENTER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-6">
                                                <div class="box-generic">
                                                    <h4 class="innerAll border-bottom">Datos del asociado protegido</h4>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="modelo">Asociado protegido:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="datoAsociado" id="datoAsociado" class="form-control" placeholder="Ingrese nombres, domicilio, razón social o RFC y presion ENTER">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-6">
                                                <div class="box-generic">
                                                    <h4 class="innerAll border-bottom">Datos del vehículo</h4>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="marca">Marca:</label>
                                                        <div class="col-md-7">
                                                            <select class="form-control" name="marca" id="marca">
                                                                <option>Seleccione</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="modelo">Modelo:</label>
                                                        <div class="col-md-7">
                                                            <select class="form-control" name="modelo" id="modelo">
                                                                <option>Seleccione</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="anio">Año:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" name="anio" id="anio" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="servicio">Servicio:</label>
                                                        <div class="col-md-7">
                                                            <select class="form-control" name="servicio" id="servicio">
                                                                <option value="">Seleccione</option>
                                                                <option value="1">Estatal</option>
                                                                <option value="2">Federal</option>
                                                                <option value="3">Otro</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-lg-6">
                                                <div class="box-generic">
                                                    <h4 class="innerAll border-bottom">Coberturas</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop