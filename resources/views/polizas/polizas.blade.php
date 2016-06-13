@extends('app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <div class="innerAll">
                        <h4 class="margin-none pull-left">Pólizas registradas</h4>
                        <a href="{{ url('polizas/registrar') }}" class="pull-right btn btn-primary"><i class="fa fa-plus-square"></i> Registrar nueva póliza</a>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <h5 class="innerAll margin-none border-bottom">Búsqueda avanzada</h5>
                                <div class="innerAll">
                                    <div class="form-group">
                                        <input type="text" name="buscador" class="form-control">
                                    </div>
                                </div>

                                <div class="col-separator-h"></div>

                                <div class="innerAll">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th>Asociado</th>
                                                <th>Vehículo</th>
                                                <th>Domicilio</th>
                                                <th>Póliza</th>
                                                <th>Servicio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Asociado</td>
                                                <td>Vehículo</td>
                                                <td>Domicilio</td>
                                                <td>Póliza</td>
                                                <td>Servicio</td>
                                            </tr>
                                            <tr>
                                                <td>Asociado</td>
                                                <td>Vehículo</td>
                                                <td>Domicilio</td>
                                                <td>Póliza</td>
                                                <td>Servicio</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop