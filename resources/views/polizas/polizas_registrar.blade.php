@extends('app')

@section('contenido')
    <div class="row row-app margin-none">
        <div class="col-md-12">
            <div class="col-separator col-separator-first border-none">
                <div class="col-table">
                    <h4 class="innerAll">AGREGAR NUEVA PÓLIZA</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <form class="form-horizontal" id="formPoliza" action="">
                                    <div class="innerAll">
                                        <span id="acciones">
                                            <a href="" id="registrarPoliza" class="hide btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR PÓLIZA</a>
                                            <a href="{{ url('polizas') }}" class="btn btn-default" id="cancelar"><i class="fa fa-times"></i> CANCELAR REGISTRO</a>
                                            <div class="separator"></div>
                                        </span>
                                        <div class="row">
                                            <div class="col-md-12 col-lg-6">
                                                <div id="busquedaVehiculo" class="box-generic padding-none">
                                                    <h4 class="innerAll border-bottom bg-gray">VEHÍCULOS ASOCIADOS A PÓLIZAS</h4>
                                                    <div class="innerAll">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3">VEHÍCULO:</label>
                                                            <div class="col-md-7">
                                                                <input type="text" name="datoVehiculo" id="datoVehiculo" class="form-control" placeholder="ESCRIBA EL NÚMERO DE SERIE O MOTOR Y PRESIONE ENTER">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="datosAsociado" class="box-generic padding-none hide">
                                                    <h4 class="innerAll border-bottom bg-gray">DATOS DE ASOCIADO PROTEGIDO</h4>
                                                    <div class="innerAll">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3" for="datoAsociado">ASOCIADO PROTEGIDO:</label>
                                                            <div class="col-md-7">
                                                                <input type="text" name="datoAsociado" id="datoAsociado" class="form-control" placeholder="ESCRIBA NOMBRES O RFC Y PRESIONE ENTER">
                                                            </div>
                                                        </div>

                                                        <div id="desgloseAsociado" class="innerAll hide" style="max-height: 400px; overflow-y: scroll;">
                                                            <table class="table table-bordered table-hover text-small">
                                                                <thead>
                                                                <tr class="bg-primary">
                                                                    <th>NOMBRE</th>
                                                                    <th>RFC</th>
                                                                    <th>DOMICILIO</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Gerardo Adrián Gómez Ruiz</td>
                                                                    <td>9611930080</td>
                                                                    <td>Av. Barrio Colón No. 261 Fracc. El Diamante</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div id="registrarAsociado" class="hide">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3" for="tipoPersona">TIPO PERSONA:</label>
                                                                <div class="col-md-7">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="tipoPersona" value="1" class="persona"> P. FÍSICA
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="tipoPersona" value="2" class="persona"> P. MORAL
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group fisica hide">
                                                                <label class="control-label col-md-3" for="nombre">NOMBRE:</label>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group fisica hide">
                                                                <label class="control-label col-md-3" for="paterno">A. PATERNO:</label>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="paterno" id="paterno" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group fisica hide">
                                                                <label class="control-label col-md-3" for="materno">A. MATERNO:</label>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="materno" id="materno" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group moral hide">
                                                                <label class="control-label col-md-3" for="razonSocial">RAZÓN SOCIAL:</label>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="razonSocial" id="razonSocial" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-md-3" for="rfc">R. F. C.:</label>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="rfc" id="rfc" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="datosVehiculo" class="box-generic padding-none hide">
                                                    <h4 class="innerAll border-bottom bg-gray">DATOS DEL VEHÍCULO</h4>
                                                    <div class="innerAll">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3" for="marca">ASOCIADO PROTEGIDO:</label>
                                                            <div class="col-md-7">
                                                                <span id="asociadoElegido">-</span>
                                                                <!--<button id="cambiarAsociado" class="btn btn-primary btn-stroke">Cambiar</button>-->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="modalidad">MODALIDAD:</label>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control" name="modalidad" id="modalidad">
                                                                            <option value="">SELECCIONE</option>
                                                                            <option value="2">TAXI</option>
                                                                            <option value="3">COMBI</option>
                                                                            <option value="4">URVAN</option>
                                                                            <option value="5">MOTOCARRO</option>
                                                                            <option value="6">MICROBUS</option>
                                                                            <option value="1">OTRO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="servicio">SERVICIO:</label>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control" name="servicio" id="servicio">
                                                                            <option value="">SELECCIONE</option>
                                                                            <option value="1">ESTATAL</option>
                                                                            <option value="2">FEDERAL</option>
                                                                            <option value="3">OTRO</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="marca">MARCA:</label>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control" name="marca" id="marca">
                                                                            <option>SELECCIONE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="modelo">MODELO:</label>
                                                                    <div class="col-md-7">
                                                                        <select class="form-control" name="modelo" id="modelo">
                                                                            <option>SELECCIONE</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="anio">AÑO:</label>
                                                                    <div class="col-md-3 col-lg-5">
                                                                        <input type="text" name="anio" id="anio" class="form-control" maxlength="4" placeholder="4 dígitos">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="numSerie">NUM. SERIE:</label>
                                                                    <div class="col-md-7">
                                                                        <input type="text" name="numSerie" id="numSerie" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="numMotor">NUM. MOTOR:</label>
                                                                    <div class="col-md-7">
                                                                        <input type="text" name="numMotor" id="numMotor" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="control-label col-md-3" for="capacidad">CAPACIDAD:</label>
                                                                    <div class="col-md-5 col-lg-7">
                                                                        <div class="input-group">
                                                                            <input type="text" name="capacidad" id="capacidad" class="form-control">
                                                                            <span class="input-group-addon">PASAJEROS</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-lg-6">
                                                <div id="datosAsociadoAgente" class="box-generic padding-none hide">
                                                    <h4 class="innerAll border-bottom bg-gray">ASOCIADO AGENTE</h4>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="asociadoAgente">&nbsp;</label>
                                                        <div class="col-md-7">
                                                            <select class="form-control" name="asociadoAgente" id="asociadoAgente">
                                                                <option value="">SELECCIONE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="datosCobertura" class="box-generic padding-none hide">
                                                    <h4 class="innerAll border-bottom bg-gray">COBERTURAS</h4>
                                                    <div class="innerAll">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3" for="coberturaServicio">SERVICIO:</label>
                                                            <div class="col-md-7"><span id="coberturaServicio"></span></div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3" for="coberturaTipo">TIPO:</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control" name="coberturaTipo" id="coberturaTipo">
                                                                    <option value="">SELECCIONE</option>
                                                                    <option value="1">LOCAL</option>
                                                                    <option value="2" selected="selected">BÁSICA</option>
                                                                    <option value="3">AMPLIA</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3" for="cobertura">COBERTURA:</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control" name="cobertura" id="cobertura">
                                                                    <option value="">SELECCIONE</option>
                                                                    <option value="1">OTRA</option>
                                                                    <option value="2">LOCAL DEFAULT</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-md-3" for="vigencia">VIGENCIA:</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control" name="vigencia" id="vigencia">
                                                                    <option value="">SELECCIONE</option>
                                                                    <option value="1">6 MESES</option>
                                                                    <option value="2">12 MESES</option>
                                                                    <option value="3">13 MESES</option>
                                                                    <option value="4">18 MESES</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <div class="hide" id="registroCobertura">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">NOMBRE:</label>
                                                                <div class="col-md-7">
                                                                    <input type="text" name="nombreCobertura" id="nombreCobertura" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">CONCEPTO:</label>
                                                                <div class="col-md-7">
                                                                    <div class="input-group">
                                                                        <select class="form-control" name="conceptoCobertura" id="conceptoCobertura">
                                                                            <option value="">SELECCIONE</option>
                                                                            <option value="1">OTRO</option>
                                                                            <option value="2">R.C. VIAJERO</option>
                                                                            <option value="2">ROBO TOTAL</option>
                                                                        </select>
                                                                        <div class="input-group-btn">
                                                                            <button id="agregarConceptoCobertura" class="btn btn-default" data-toggle="tooltip" data-original-title="AGREGAR A RESPONSABILIDADES" data-placement="top"><i class="fa fa-plus-square"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <table id="tablaReponsabilidades" class="table table-bordered">
                                                                <thead class="bg-gray">
                                                                    <tr>
                                                                        <th>CONCEPTO</th>
                                                                        <th>LIM. RESPONSABILIDAD</th>
                                                                        <th>CUOTA EXTRAORDINARIA</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input type="text" name="concepto[]" value="R.C. VIAJERO" class="form-control"></td>
                                                                        <td><input type="text" name="limResponsabilidad[]" value="HASTA 19D" class="form-control"></td>
                                                                        <td><input type="text" name="cuotaExtraordinaria[]" value="-" class="form-control"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        <div class="innerAll" id="desgloseCobertura">
                                                            <table>
                                                                <tr>
                                                                    <td>COSTO:</td>
                                                                    <td class="strong text-primary">$1, 500.00</td>
                                                                </tr>
                                                            </table>
                                                            <div class="separator"></div>
                                                            <table class="table table-bordered text-small">
                                                                <thead class="bg-primary">
                                                                <tr>
                                                                    <th>CONCEPTO</th>
                                                                    <th>LIM. RESPONSABILIDAD</th>
                                                                    <th>CUOTA EXTRAORDINARIA</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>DAÑOS MATERIALES:</td>
                                                                    <td>EXCLUÍDO</td>
                                                                    <td>-</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="polizaNueva" id="polizaNueva">
                                        <input type="hidden" name="asociadoNuevo" id="asociadoNuevo">
                                        <input type="hidden" name="vehiculoNuevo" id="vehiculoNuevo">
                                        <input type="hidden" name="coberturaNueva" id="coberturaNueva">

                                        <input type="hidden" id="buscarAsociado" value="0">
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

@section('js')
    <script src="{{ asset('public/js/polizas/polizas_registrar.js') }}"></script>
@stop