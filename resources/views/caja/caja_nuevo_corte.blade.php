<div id="modalNuevoCorte" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">GENERAR NUEVO CORTE DE CAJA</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/caja/cortes/nuevo" id="formGenerarCorte" class="form-horizontal">
                    <div class="form-group">
                        <label for="fechaCorte" class="col-md-3 col-lg-2 control-label">FECHA DE CORTE:</label>
                        <div class="col-md-4 col-lg-3">
                            <input type="text" name="fechaCorte" id="fechaCorte" class="form-control required" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-3 col-lg-offset-2">
                            {{ csrf_field() }}
                            <button type="button" id="generarCorte" class="btn btn-primary"><i class="fa fa-save"></i> GENERAR CORTE DE CAJA</button>
                            <span id="loadingGenerarCorte" class="hide text-primary"><i class="fa fa-spinner fa-spin fa-3x"></i> GENERANDO CORTE DE CAJA...</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>