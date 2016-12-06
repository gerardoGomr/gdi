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
                                        <div class="box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">VEHÍCULOS</h5>
                                            <div class="innerAll" id="busquedaVehiculo">
                                                <p class="text-muted">ES NECESARIO QUE ESCRIBA EL NÚMERO DE SERIE O MOTOR DEL VEHÍCULO PARA BUSCARLO DENTRO DEL SISTEMA. UNA VEZ QUE LO ESCRIBA, PRESIONE ENTER.</p>
                                                <div class="separator bottom"></div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="datoVehiculoBuscar">NUM. SERIE O MOTOR:</label>
                                                    <div class="col-md-5">
                                                        <input type="text" name="datoVehiculoBuscar" id="datoVehiculoBuscar" class="form-control" data-url="{{ url('polizas/vehiculos/buscar') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="innerAll hide" id="datosVehiculo">
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-3">VEHICULO:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" id="vehiculoRenovar"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-3">ASOCIADO PROTEGIDO:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" id="asociadoProtegidoRenovar"></p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="control-label col-md-3">COBERTURA:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" id="coberturaRenovar"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="innerAll hide" id="capturarDatosVehiculo">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="modalidad">MODALIDAD:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="modalidad" id="modalidad">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="-1">OTRO</option>
                                                            @foreach($modalidades as $modalidad)
                                                                <option value="{{ $modalidad->getId() }}">{{ $modalidad->getModalidad() }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group hide" id="especifiqueOtraModalidad">
                                                    <div class="col-md-4 col-md-offset-3">
                                                        <input type="text" name="otraModalidad" id="otraModalidad" class="form-control" placeholder="ESPECIFIQUE MODALIDAD">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="servicio">SERVICIO:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="servicio" id="servicio">
                                                            <option value="">SELECCIONE</option>
                                                            @foreach($servicios as $servicio)
                                                                <option value="{{ $servicio->getId() }}">{{ $servicio->getServicio() }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="separator hide"></div>
                                                        <input type="text" name="otroServicio" id="otroServicio" class="form-control hide" placeholder="ESCRIBA EL SERVICIO">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="marca">MARCA:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="marca" id="marca" data-url="{{ url('polizas/modelos/buscar') }}">
                                                            <option value="">SELECCIONE</option>
                                                            @foreach($marcas as $marca)
                                                                <option value="{{ $marca->getId() }}">{{ $marca->getMarca() }}</option>
                                                            @endforeach
                                                        </select>
                                                        <br>
                                                        <input type="text" name="otraMarca" id="otraMarca" class="form-control hide" placeholder="ESCRIBA LA NUEVA MARCA">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="modelo">MODELO:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="modelo" id="modelo">

                                                        </select>
                                                        <br>
                                                        <input type="text" name="otroModelo" id="otroModelo" class="form-control hide" placeholder="ESCRIBA EL NUEVO MODELO">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="anio">AÑO:</label>
                                                    <div class="col-md-1">
                                                        <input type="text" name="anio" id="anio" class="form-control" maxlength="4" placeholder="4 dígitos">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="numSerie">NUM. SERIE:</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="numSerie" id="numSerie" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="numMotor">NUM. MOTOR:</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="numMotor" id="numMotor" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="placas">PLACAS:</label>
                                                    <div class="col-md-4">
                                                        <input type="text" name="placas" id="placas" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="capacidad">CAPACIDAD:</label>
                                                    <div class="col-md-2">
                                                        <div class="input-group">
                                                            <input type="text" name="capacidad" id="capacidad" class="form-control" placeholder="" maxlength="2">
                                                            <span class="input-group-addon">PASAJEROS</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="datosAsociado" class="hide box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">ASOCIADO PROTEGIDO</h5>
                                            <div class="innerAll">
                                                <div class="form-group" id="busquedaAsociado">
                                                    <label class="control-label col-md-3" for="datoAsociadoBuscar">DATO DE ASOCIADO PROTEGIDO A BUSCAR:</label>
                                                    <div class="col-md-7">
                                                        <div class="input-group">
                                                            <input type="text" name="datoAsociadoBuscar" id="datoAsociadoBuscar" class="form-control" placeholder="ESCRIBA NOMBRES, RAZÓN SOCIAL O RFC" data-url="{{ url('polizas/asociados/buscar') }}">
                                                            <span class="input-group-addon" data-toggle="tooltip" data-original-title="PARA BUSCAR, PRESIONE ENTER SOBRE ESTE CAMPO" data-placement="top"><i class="fa fa-info-circle"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="capturarDatosAsociado" class="hide">
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
                                                        <div class="col-md-5">
                                                            <input type="text" name="nombre" id="nombre" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group fisica hide">
                                                        <label class="control-label col-md-3" for="paterno">A. PATERNO:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" name="paterno" id="paterno" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group fisica hide">
                                                        <label class="control-label col-md-3" for="materno">A. MATERNO:</label>
                                                        <div class="col-md-3">
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
                                                        <div class="col-md-3">
                                                            <input type="text" name="rfc" id="rfc" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="calleAsociado">CALLE:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="calleAsociado" id="calleAsociado" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="">NÚMEROS:</label>
                                                        <div class="col-md-1">
                                                            <input type="text" name="numExteriorAsociado" id="numExteriorAsociado" class="form-control" placeholder="Exterior">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="text" name="numInteriorAsociado" id="numInteriorAsociado" class="form-control" placeholder="Interior">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="coloniaAsociado">COLONIA:</label>
                                                        <div class="col-md-5">
                                                            <input type="text" name="coloniaAsociado" id="coloniaAsociado" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="cpAsociado">C.P.:</label>
                                                        <div class="col-md-2">
                                                            <input type="text" name="cpAsociado" id="cpAsociado" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="ciudadAsociado">CIUDAD:</label>
                                                        <div class="col-md-5">
                                                            <select name="ciudadAsociado" id="ciudadAsociado" class="form-control">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="1">TUXTLA GUTIÉRREZ</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="telefonoAsociado">TELÉFONO:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" name="telefonoAsociado" id="telefonoAsociado" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="celularAsociado">CELULAR:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" name="celularAsociado" id="celularAsociado" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="emailAsociado">EMAIL:</label>
                                                        <div class="col-md-3">
                                                            <input type="text" name="emailAsociado" id="emailAsociado" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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

                                        <div id="datosCobertura" class="hide box-generic padding-none animated fadeInUp">
                                            <h5 class="innerAll border-bottom bg-gray">COBERTURAS</h5>
                                            <div class="innerAll">
                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="coberturaServicio">SERVICIO:</label>
                                                    <div class="col-md-4">
                                                        <p class="form-control-static" id="coberturaServicio"></p>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="coberturaTipo">TIPO:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="coberturaTipo" id="coberturaTipo" data-url="{{ url('polizas/coberturas/buscar') }}">
                                                            <option value="">SELECCIONE</option>
                                                            <option value="1">LOCAL</option>
                                                            <option value="2">BÁSICA</option>
                                                            <option value="3">AMPLIA</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-md-3" for="cobertura">COBERTURA:</label>
                                                    <div class="col-md-4">
                                                        <select class="form-control" name="cobertura" id="cobertura" data-url="{{ url('polizas/coberturas/vigencias/buscar') }}">

                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="seleccionCobertura">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3 vigenciaCobertura" for="vigenciaCobertura">COSTOS:</label>
                                                        <div class="col-md-4">
                                                            <select class="form-control vigenciaCobertura" name="vigenciaCobertura" id="vigenciaCobertura">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="-1">OTRO</option>
                                                                @foreach($vigencias as $vigencia)
                                                                    <option value="{{ $vigencia->getId() }}">{{ $vigencia->getVigencia() }} MESES</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="hide" id="registroCobertura">
                                                    <div class="form-group">
                                                        <label for="nombreCobertura" class="control-label col-md-3">NOMBRE:</label>
                                                        <div class="col-md-7">
                                                            <input type="text" name="nombreCobertura" id="nombreCobertura" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="vigencias hide">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3" for="vigencias">VIGENCIAS:</label>
                                                        <div class="col-md-4">
                                                            <select class="form-control" name="vigencias" id="vigencias">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="-1">OTRO</option>
                                                                @foreach($vigencias as $vigencia)
                                                                    <option value="{{ $vigencia->getId() }}">{{ $vigencia->getVigencia() }} MESES</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group nuevaVigencia hide">
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
                                                        <div class="col-md-2">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                <input type="text" name="nuevoCosto" id="nuevoCosto" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="conceptoCobertura" class="control-label col-md-3">CONCEPTO:</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <select class="form-control" name="conceptoCobertura" id="conceptoCobertura">
                                                                    <option value="">SELECCIONE</option>
                                                                    @foreach($coberturasConceptos as $coberturaConcepto)
                                                                        <option value="{{ $coberturaConcepto->getId() }}">{{ $coberturaConcepto->getConcepto() }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="input-group-btn">
                                                                    <button type="button" id="agregarConceptoCobertura" class="btn btn-primary" data-toggle="tooltip" data-original-title="AGREGAR A RESPONSABILIDADES" data-placement="top"><i class="fa fa-plus-square"></i></button>
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
                                                        <tbody id="responsabilidadDesglose">

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
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" name="polizaNueva" id="polizaNueva">
                                        <input type="hidden" name="asociadoNuevo" id="asociadoNuevo">
                                        <input type="hidden" name="asociadoProtegidoId" id="asociadoProtegidoId">
                                        <input type="hidden" name="vehiculoNuevo" id="vehiculoNuevo">
                                        <input type="hidden" name="coberturaNueva" id="coberturaNueva">
                                        <input type="hidden" id="buscarAsociado" value="0">
                                        <input type="hidden" id="urlPago" value="{{ url('polizas/pagar/') }}">
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