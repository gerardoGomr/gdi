<div class="row">
    <div class="col-md-3">
        <label for="conceptoCobertura" class="control-label">CONCEPTO:</label>
        <select class="form-control" name="conceptoCobertura" id="conceptoCoberturaExistente">
            <option value="">SELECCIONE</option>
            @foreach($coberturasConceptos as $coberturaConcepto)
                <option value="{{ $coberturaConcepto->getId() }}">{{ $coberturaConcepto->getConcepto() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label for="limiteResponsabilidadExistente" class="control-label">LIMITE RESPONSABILIDAD:</label>
        <input type="text" name="limiteResponsabilidadExistente" id="limiteResponsabilidadExistente" class="form-control">
    </div>
    <div class="col-md-3">
        <label for="cuotaExtraordinariaExistente" class="control-label">CUOTA EXTRAORDINARIA:</label>
        <input type="text" name="cuotaExtraordinariaExistente" id="cuotaExtraordinariaExistente" class="form-control">
    </div>
    <div class="col-md-3">
        <br>
        <button type="button" id="agregarConceptoCoberturaExistente" class="btn btn-info" data-url="{{ url('polizas/responsabilidad/agregar') }}" data-id="{{ $poliza->getId() }}"><i class="fa fa-save"></i> AGREGAR RESPONSABILIDAD</button>
        <input type="hidden" name="" id="urlEliminarResponsabilidad" value="{{ url('polizas/responsabilidad/eliminar') }}">
    </div>
</div>
<div class="separator"></div>
<table class="table table-bordered">
    <thead class="bg-gray">
    <tr>
        <th>CONCEPTO</th>
        <th>LIM. RESPONSABILIDAD</th>
        <th>CUOTA EXTRAORDINARIA</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody id="responsabilidadDesgloseExistente">
    @if ($cobertura->tieneResponsabilidades())
        @foreach($cobertura->getResponsabilidades() as $responsabilidad)
            <tr>
                <td>{{ $responsabilidad->getCoberturaConcepto()->getConcepto() }}</td>
                <td>{{ $responsabilidad->getLimiteResponsabilidad() }}</td>
                <td>{{ $responsabilidad->getCuotaExtraordinaria() }}</td>
                <td><button type="button" class="btn btn-danger btn-sm quitarResponsabilidad" data-toggle="tooltip" data-original-title="QUITAR RESPONSABILIDAD" data-responsabilidad-id="{{ $responsabilidad->getId() }}"><i class="fa fa-times"></i></button></td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>