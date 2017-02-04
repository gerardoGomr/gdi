<div id="capturarDatosVehiculo" class="box-generic padding-none animated fadeInUp">
    <h5 class="innerAll border-bottom bg-gray">DATOS DEL VEHÍCULO</h5>
    <div class="form-group">
        <label class="control-label col-md-3" for="modalidad">MODALIDAD:</label>
        <div class="col-md-4">
            <select class="form-control" name="modalidad" id="modalidad">
                <option value="">SELECCIONE</option>
                <option value="-1">OTRO</option>
                @foreach($modalidades as $modalidad)
                    <option value="{{ $modalidad->getId() }}" {!! $poliza->getVehiculo()->getModalidad()->getId() === $modalidad->getId() ? 'selected' : '' !!}>{{ $modalidad->getModalidad() }}</option>
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
        <label class="control-label col-md-3" for="marca">MARCA:</label>
        <div class="col-md-4">
            <select class="form-control" name="marca" id="marca" data-url="{{ url('polizas/modelos/buscar') }}">
                <option value="">SELECCIONE</option>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->getId() }}" {!! $poliza->getVehiculo()->getModelo()->getMarca()->getId() === $marca->getId() ? 'selected' : '' !!}>{{ $marca->getMarca() }}</option>
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
                @foreach($poliza->getVehiculo()->getModelo()->getMarca()->getModelos() as $modelo)
                    <option value="{{ $modelo->getId() }}" {!! $poliza->getVehiculo()->getModelo()->getId() === $modelo->getId() ? 'selected' : '' !!}>{{ $modelo->getModelo() }}</option>
                @endforeach
            </select>
            <br>
            <input type="text" name="otroModelo" id="otroModelo" class="form-control hide" placeholder="ESCRIBA EL NUEVO MODELO">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3" for="anio">AÑO:</label>
        <div class="col-md-1">
            <input type="text" name="anio" id="anio" class="form-control" maxlength="4" placeholder="4 dígitos" value="{{ $poliza->getVehiculo()->getAnio() }}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3" for="numSerie">NUM. SERIE:</label>
        <div class="col-md-4">
            <input type="text" name="numSerie" id="numSerie" class="form-control" value="{{ $poliza->getVehiculo()->getNumeroSerie() }}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3" for="numMotor">NUM. MOTOR:</label>
        <div class="col-md-4">
            <input type="text" name="numMotor" id="numMotor" class="form-control" value="{{ $poliza->getVehiculo()->getNumeroMotor() }}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3" for="placas">PLACAS:</label>
        <div class="col-md-4">
            <input type="text" name="placas" id="placas" class="form-control" value="{{ $poliza->getVehiculo()->getPlacas() }}">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3" for="capacidad">CAPACIDAD:</label>
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" name="capacidad" id="capacidad" class="form-control" placeholder="" maxlength="2" value="{{ $poliza->getVehiculo()->getCapacidad() }}">
                <span class="input-group-addon">PASAJEROS</span>
            </div>
        </div>
    </div>
    <input type="hidden" name="vehiculoId" value="{{ $poliza->getVehiculo()->getId() }}">
</div>

<div id="datosAsociado" class="box-generic padding-none animated fadeInUp">
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

        <div id="capturarDatosAsociado">
            <div class="form-group">
                <label class="control-label col-md-3" for="tipoPersona">TIPO PERSONA:</label>
                <div class="col-md-7">
                    <div class="radio">
                        <label>
                            <input type="radio" name="tipoPersona" id="tipoPersona1" value="1" class="persona" {!! $poliza->getVehiculo()->getAsociadoProtegido()->esPersonaFisica() ? 'checked' : '' !!}> P. FÍSICA
                        </label>
                    </div>

                    <div class="radio">
                        <label>
                            <input type="radio" name="tipoPersona" id="tipoPersona2" value="2" class="persona" {!! $poliza->getVehiculo()->getAsociadoProtegido()->esPersonaMoral() ? 'checked' : '' !!}> P. MORAL
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group fisica {{ !$poliza->getVehiculo()->getAsociadoProtegido()->esPersonaFisica() ? 'hide' : '' }}">
                <label class="control-label col-md-3" for="nombre">NOMBRE:</label>
                <div class="col-md-5">
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getNombre() }}">
                </div>
            </div>

            <div class="form-group fisica {{ !$poliza->getVehiculo()->getAsociadoProtegido()->esPersonaFisica() ? 'hide' : '' }}">
                <label class="control-label col-md-3" for="paterno">A. PATERNO:</label>
                <div class="col-md-3">
                    <input type="text" name="paterno" id="paterno" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getPaterno() }}">
                </div>
            </div>

            <div class="form-group fisica {{ !$poliza->getVehiculo()->getAsociadoProtegido()->esPersonaFisica() ? 'hide' : '' }}">
                <label class="control-label col-md-3" for="materno">A. MATERNO:</label>
                <div class="col-md-3">
                    <input type="text" name="materno" id="materno" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getMaterno() }}">
                </div>
            </div>

            <div class="form-group moral {{ !$poliza->getVehiculo()->getAsociadoProtegido()->esPersonaMoral() ? 'hide' : '' }}">
                <label class="control-label col-md-3" for="razonSocial">RAZÓN SOCIAL:</label>
                <div class="col-md-7">
                    <input type="text" name="razonSocial" id="razonSocial" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getRazonSocial() }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3" for="rfc">R. F. C.:</label>
                <div class="col-md-3">
                    <input type="text" name="rfc" id="rfc" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getRfc() }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="calleAsociado">CALLE:</label>
                <div class="col-md-5">
                    <input type="text" name="calleAsociado" id="calleAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getCalle() }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3" for="">NÚMEROS:</label>
                <div class="col-md-1">
                    <input type="text" name="numExteriorAsociado" id="numExteriorAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getNumExterior() }}" placeholder="Exterior">
                </div>
                <div class="col-md-1">
                    <input type="text" name="numInteriorAsociado" id="numInteriorAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getNumInterior() }}" placeholder="Interior">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="coloniaAsociado">COLONIA:</label>
                <div class="col-md-5">
                    <input type="text" name="coloniaAsociado" id="coloniaAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getColonia() }}">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3" for="cpAsociado">C.P.:</label>
                <div class="col-md-2">
                    <input type="text" name="cpAsociado" id="cpAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getDomicilio()->getCp() }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="ciudadAsociado">CIUDAD:</label>
                <div class="col-md-5">
                    <select name="ciudadAsociado" id="ciudadAsociado" class="form-control">
                        <option value="">SELECCIONE</option>
                        @foreach($unidadesAdministrativas as $unidadAdministrativa)
                            <option value="{{ $unidadAdministrativa->getId() }}">{{ $unidadAdministrativa->getUnidad() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3" for="telefonoAsociado">TELÉFONO:</label>
                <div class="col-md-3">
                    <input type="text" name="telefonoAsociado" id="telefonoAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getTelefono() }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="celularAsociado">CELULAR:</label>
                <div class="col-md-3">
                    <input type="text" name="celularAsociado" id="celularAsociado" class="form-control" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getCelular() }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3" for="emailAsociado">EMAIL:</label>
                <div class="col-md-3">
                    <input type="text" name="emailAsociado" id="emailAsociado" class="form-control noUpperCase" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getEmail() }}">
                </div>
            </div>
            <input type="hidden" name="asociadoProtegidoId" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->getId() }}">
        </div>
    </div>
</div>

<div id="datosCobertura" class="box-generic padding-none animated fadeInUp">
    <h5 class="innerAll border-bottom bg-gray">COBERTURAS</h5>
    <div class="innerAll">
        <div class="form-group">
            <label class="control-label col-md-3" for="servicio">SERVICIO:</label>
            <div class="col-md-4">
                <select class="form-control" name="servicio" id="servicio">
                    <option value="">SELECCIONE</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->getId() }}" {!! $poliza->getCobertura()->getServicio()->getId() === $servicio->getId() ? 'selected' : '' !!}>{{ $servicio->getServicio() }}</option>
                    @endforeach
                </select>
                <div class="separator hide"></div>
                <input type="text" name="otroServicio" id="otroServicio" class="form-control hide" placeholder="ESCRIBA EL SERVICIO">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="coberturaTipo">TIPO:</label>
            <div class="col-md-4">
                <select class="form-control" name="coberturaTipo" id="coberturaTipo" data-url="{{ url('polizas/coberturas/buscar') }}">
                    <option value="">SELECCIONE</option>
                    <option value="1" {!! $poliza->getCobertura()->esCoberturaLocal() ? 'selected' : '' !!}>LOCAL</option>
                    <option value="2" {!! $poliza->getCobertura()->esCoberturaBasica() ? 'selected' : '' !!}>BÁSICA</option>
                    <option value="3" {!! $poliza->getCobertura()->esCoberturaAmplia() ? 'selected' : '' !!}>AMPLIA</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3" for="cobertura">COBERTURA:</label>
            <div class="col-md-4">
                <select class="form-control" name="cobertura" id="cobertura" data-url="{{ url('polizas/coberturas/vigencias/buscar') }}">
                    <option value="">SELECCIONE</option>
                    <option value="-1">OTRO</option>
                    @foreach($coberturas as $cobertura)
                        <option value="{{ $cobertura->getId() }}" {!! $poliza->getCobertura()->getId() === $cobertura->getId() ? 'selected' : '' !!}>{{ $cobertura->getNombre() }}</option>
                    @endforeach
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
                        @foreach($poliza->getCobertura()->getCostos() as $costo)
                            <option value="{{ $costo->getId() }}" {!! $poliza->getCosto()->getId() === $costo->getId() ? 'selected' : '' !!}>{{ $costo->getVigencia()->getVigencia() . ' MESES --- $' . number_format($costo->getCosto(), 2) }}</option>
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

        <div id="registroVigencias" class="hide">
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
        </div>

        <div id="registroResponsabilidades" class="hide">
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

        <div class="separator"></div>
        <div class="separator"></div>
        <div class="" id="desgloseResponsabilidades">
            <?php $cobertura = $poliza->getCobertura() ?>
            @include('polizas.polizas_resultado_responsabilidades')
        </div>
    </div>
</div>

@if($formaDeCargo === 'busqueda')
    <script src="{{ asset('js/polizas/polizas_registrar_adicional.js') }}"></script>
@endif