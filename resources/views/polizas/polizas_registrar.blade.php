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
                                    <!-- <div class="widget widget-tabs">
                                        <div class="widget-head">
                                            <ul>
                                                <li class="active"><a href="#busquedaVehiculo" data-toggle="tab">BÚSQUEDA</a></li>
                                                <li><a href="#" data-toggle="tab">ASOCIADO</a></li>
                                                <li><a href="#" data-toggle="tab">VEHICULO</a></li>
                                                <li><a href="#" data-toggle="tab">COBERTURA</a></li>
                                                <li><a href="#" data-toggle="tab">ASOCIADO AGENTE</a></li>
                                            </ul>
                                        </div>
                                        <div class="widget-body">
                                            <div class="tab-content">
                                                
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="innerAll">
                                        <span id="acciones">
                                            <a href="" id="registrarPoliza" class="hide btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR PÓLIZA</a>
                                            <a href="{{ url('polizas') }}" class="btn btn-default" id="cancelar"><i class="fa fa-times"></i> CANCELAR REGISTRO</a>
                                            <div class="separator"></div>
                                        </span>

                                        <div class="box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">VEHÍCULOS</h5>
                                            <div class="innerAll" id="busquedaVehiculo">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="datoVehiculo">DATO A BUSCAR:</label>
                                                    <div class="col-md-8 col-lg-7">
                                                        <input type="text" name="datoVehiculo" id="datoVehiculo" class="form-control" placeholder="ESCRIBA EL NÚMERO DE SERIE O MOTOR Y PRESIONE ENTER">

                                                        <span id="vehiculoNoEncontrado" class="text-primary text-small hide"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="innerAll hide" id="datosVehiculo">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="modalidad">MODALIDAD:</label>
                                                    <div class="col-md-4">
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
                                                    <label class="control-label col-md-3 col-lg-4" for="servicio">SERVICIO:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="servicio" id="servicio">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="1">OTRO</option>
                                                            <option value="2">ESTATAL</option>
                                                            <option value="3">FEDERAL</option>
                                                        </select>
                                                        <div class="separator hide"></div>
                                                        <input type="text" name="otroServicio" id="otroServicio" class="form-control hide" placeholder="ESCRIBA EL SERVICIO">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="marca">MARCA:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="marca" id="marca">
                                                            <option>SELECCIONE</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="modelo">MODELO:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="modelo" id="modelo">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="1">OTRO</option>
                                                        </select>
                                                        <div class="separator hide"></div>
                                                        <input type="text" name="otroModelo" id="otroModelo" class="form-control hide" placeholder="ESCRIBA EL NUEVO MODELO">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="anio">AÑO:</label>
                                                    <div class="col-md-2 col-lg-3">
                                                        <input type="text" name="anio" id="anio" class="form-control" maxlength="4" placeholder="4 dígitos">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="numSerie">NUM. SERIE:</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="numSerie" id="numSerie" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="numMotor">NUM. MOTOR:</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="numMotor" id="numMotor" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="capacidad">CAPACIDAD:</label>
                                                    <div class="col-md-2 col-lg-3">
                                                        <div class="input-group">
                                                            <input type="text" name="capacidad" id="capacidad" class="form-control" placeholder="" maxlength="2">
                                                            <span class="input-group-addon">PASAJEROS</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="datosAsociado" class="box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">ASOCIADO PROTEGIDO</h5>
                                            <div class="innerAll">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="datoAsociado">DATO DE ASOCIADO PROTEGIDO A BUSCAR:</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <input type="text" name="datoAsociado" id="datoAsociado" class="form-control" placeholder="ESCRIBA NOMBRES, RAZÓN SOCIAL O RFC">
                                                            <span class="input-group-addon" data-toggle="tooltip" data-original-title="PARA BUSCAR, PRESIONE ENTER SOBRE ESTE CAMPO" data-placement="top"><i class="fa fa-info-circle"></i></span>
                                                        </div>
                                                    </div>
                                                    <a href="#resultadoAsociados" data-toggle="modal" class="">click</a>
                                                </div>

                                                <div id="registrarAsociado" class="hide">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-lg-4" for="tipoPersona">TIPO PERSONA:</label>
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
                                                        <label class="control-label col-md-3 col-lg-4" for="nombre">NOMBRE:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="nombre" id="nombre" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group fisica hide">
                                                        <label class="control-label col-md-3 col-lg-4" for="paterno">A. PATERNO:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="paterno" id="paterno" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group fisica hide">
                                                        <label class="control-label col-md-3 col-lg-4" for="materno">A. MATERNO:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="materno" id="materno" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group moral hide">
                                                        <label class="control-label col-md-3 col-lg-4" for="razonSocial">RAZÓN SOCIAL:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="razonSocial" id="razonSocial" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-lg-4" for="rfc">R. F. C.:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" name="rfc" id="rfc" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="datosAsociadoAgente" class="box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">ASOCIADO AGENTE</h5>
                                            <div class="form-group">
                                                <label class="control-label col-md-3 col-lg-4" for="asociadoAgente">NOMBRE:</label>
                                                <div class="col-md-7">
                                                    <select class="form-control" name="asociadoAgente" id="asociadoAgente">
                                                        <option value="">SELECCIONE</option>
                                                        <option value="1">OTRO</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="datosCapturaAsociadoAgente" class="hide">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="nombreAgente">NOMBRE:</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="nombreAgente" id="nombreAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="paternoAgente">A. PATERNO:</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="paternoAgente" id="paternoAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="maternoAgente">A. MATERNO:</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="maternoAgente" id="maternoAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="domicilioAgente">DOMICILIO:</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="domicilioAgente" id="domicilioAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="ciudadAgente">CIUDAD:</label>
                                                    <div class="col-md-7">
                                                        <input type="text" name="ciudadAgente" id="ciudadAgente" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="telefonoAgente">TELÉFONO:</label>
                                                    <div class="col-md-3">
                                                        <input type="text" name="telefonoAgente" id="telefonoAgente" class="form-control" placeholder="961 196 5858">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="datosCobertura" class="box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">COBERTURAS</h5>
                                            <div class="innerAll">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="coberturaServicio">SERVICIO:</label>
                                                    <div class="col-md-4"><span id="coberturaServicio"></span></div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="coberturaTipo">TIPO:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="coberturaTipo" id="coberturaTipo">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="1">LOCAL</option>
                                                            <option value="2" selected="selected">BÁSICA</option>
                                                            <option value="3">AMPLIA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-lg-4" for="cobertura">COBERTURA:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="cobertura" id="cobertura">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="1">OTRA</option>
                                                            <option value="2">LOCAL DEFAULT</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3 vigenciaCobertura" for="vigenciaCobertura">VIGENCIA:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control vigenciaCobertura" name="vigenciaCobertura" id="vigenciaCobertura">
                                                            <option value="">SELECCIONE</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="hide" id="registroCobertura">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-lg-4">NOMBRE:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="nombreCobertura" id="nombreCobertura" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-lg-4" for="vigencias">VIGENCIAS:</label>
                                                        <div class="col-md-7">
                                                            <select class="form-control" name="vigencias" id="vigencias">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="1">OTRA</option>
                                                                <option value="2">6 MESES</option>
                                                                <option value="3">12 MESES</option>
                                                                <option value="4">13 MESES</option>
                                                                <option value="5">18 MESES</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group nuevaVigencia">
                                                        <label for="nuevaVigencia" class="control-label col-md-3">NUEVA VIGENCIA</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <input type="text" name="nuevaVigencia" id="nuevaVigencia" class="form-control" maxlength="2">
                                                                <span class="input-group-addon">MESES</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="nuevoCosto" class="control-label col-md-3">NUEVO COSTO:</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                <input type="text" name="nuevoCosto" id="nuevoCosto" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 col-lg-4">CONCEPTO:</label>
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

                                                <div class="innerAll hide" id="desgloseCobertura">
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

    <div class="modal fade" id="resultadoAsociados">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Modal header</h3>
                </div>
    
                <div class="modal-body">
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
                <div class="modal-footer">
                    <a href="#" class="btn btn-default" data-dismiss="modal">Close</a> 
                    <a href="#" data-dismiss="modal" class="btn btn-primary">Save changes</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/js/polizas/polizas_registrar.js') }}"></script>
@stop