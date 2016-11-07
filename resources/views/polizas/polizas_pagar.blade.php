@extends('app')

@section('contenido')
    <div class="row row-app margin-none">
        <div class="col-md-12 col-lg-9">
            <div class="col-separator col-separator-first border-none">
                <div class="col-table">
                    <h4 class="innerAll">PAGO DE PÓLIZA</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="box-generic padding-none">
                                                <h4 class="innerAll border-bottom bg-gray">PÓLIZA</h4>
                                                <dl class="dl-horizontal">
                                                    <dt>COBERTURA:</dt>
                                                    <dd>{{ $poliza->getCobertura()->getNombre() }}</dd>
                                                    <dt>COSTO:</dt>
                                                    <dd>${{ number_format($poliza->getCosto()->getCosto(), 2) }}</dd>
                                                    <dt>VIGENCIA:</dt>
                                                    <dd>{{ $poliza->getCosto()->getVigencia()->getVigencia() }} MESES</dd>
                                                    <dt>VEHÍCULO:</dt>
                                                    <dd>{{ $poliza->getVehiculo()->detalles() }}</dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="box-generic padding-none">
                                                <h4 class="innerAll border-bottom bg-gray">PAGO</h4>
                                                <p class="strong innerAll text-medium">Total a pagar: <span class="text-primary">${{ number_format($poliza->getCosto()->getCosto(), 2) }}</span></p>
                                                <form action="{{ url('polizas/pagar') }}" class="form-horizontal" role="form" id="formPago">
                                                    {!! csrf_field() !!}
                                                    <div class="form-group">
                                                        <label for="formaPago" class="control-label col-md-3">FORMA DE PAGO:</label>
                                                        <div class="col-md-5">
                                                            <select name="formaPago" id="formaPago" class="form-control required">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="{{ GDI\Dominio\Polizas\FormaPago::CONTADO }}">CONTADO</option>
                                                                <option value="{{ GDI\Dominio\Polizas\FormaPago::PARCIAL }}">PARCIAL</option>
                                                                <option value="{{ GDI\Dominio\Polizas\FormaPago::SEMESTRAL }}">SEMESTRAL</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="metodoPago" class="control-label col-md-3">MÉTODO DE PAGO:</label>
                                                        <div class="col-md-5">
                                                            <select name="metodoPago" id="metodoPago" class="form-control required">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="{{ GDI\Dominio\Polizas\MedioPago::EFECTIVO }}">EFECTIVO</option>
                                                                <option value="{{ GDI\Dominio\Polizas\MedioPago::TARJETA_CREDITO }}">TARJETA DE CRÉDITO</option>
                                                                <option value="{{ GDI\Dominio\Polizas\MedioPago::CHEQUE }}">CHEQUE</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="cobroEfectivo" class="hide">
                                                        <div class="form-group">
                                                            <label for="montoPago" class="control-label col-md-3">PAGO:</label>
                                                            <div class="col-md-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">$</span>
                                                                    <input type="text" name="montoPago" id="montoPago" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cambio" class="control-label col-md-3">CAMBIO:</label>
                                                            <div class="col-md-3">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">$</span>
                                                                    <input type="text" name="cambio" id="cambio" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center border-top innerTB">
                                                        <input type="hidden" id="costo" value="{{ $poliza->getCosto()->getCosto() }}">
                                                        <input type="hidden" name="polizaId" value="{{ base64_encode($poliza->getId()) }}">
                                                        <input type="hidden" id="urlPrincipal" value="{{ url('polizas') }}">
                                                        <input type="hidden" id="urlFormato" value="{{ url('polizas/formato/' . base64_encode($poliza->getId())) }}">
                                                        <input type="hidden" id="urlFormatoParcial" value="{{ url('polizas/formato/parcial/' . base64_encode($poliza->getId())) }}">
                                                        <button type="button" id="realizarCobro" class="btn btn-primary">REALIZAR COBRO</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
    <script src="{{ asset('js/polizas/polizas_pagar.js') }}"></script>
@stop