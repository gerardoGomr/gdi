<div class="row">
    <div class="col-md-3">
        <label for="conceptoCobertura" class="control-label">CONCEPTO:</label>
        <select class="form-control conceptoCoberturaExistente" name="conceptoCobertura" id="conceptoCoberturaExistente" data-url="{{ url('polizas/responsabilidad/buscar') }}">
            <option value="">SELECCIONE</option>
            @foreach($coberturasConceptos as $coberturaConcepto)
                <option value="{{ $coberturaConcepto->getId() }}">{{ $coberturaConcepto->getConcepto() }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label for="responsabilidad" class="control-label">RESPONSABILIDAD</label>
        <select class="form-control responsabilidad" name="responsabilidad" id="responsabilidad"></select>
    </div>
</div>
<div class="row hide" id="datosResponsabilidadExistente">
    <div class="col-md-3">
        <label for="limiteResponsabilidadExistente" class="control-label">LIMITE RESPONSABILIDAD:</label>
        <input type="text" name="limiteResponsabilidadExistente" id="limiteResponsabilidadExistente" class="form-control">
    </div>
    <div class="col-md-3">
        <label for="cuotaExtraordinariaExistente" class="control-label">CUOTA EXTRAORDINARIA:</label>
        <input type="text" name="cuotaExtraordinariaExistente" id="cuotaExtraordinariaExistente" class="form-control">
    </div>
</div>
<button type="button" id="agregarConceptoCoberturaExistente" class="btn btn-info agregarConceptoCoberturaExistente" data-url="{{ url('cobertura/responsabilidad/agregar') }}" data-id="{{ $cobertura->getId() }}"><i class="fa fa-save"></i> AGREGAR RESPONSABILIDAD</button>
<input type="hidden" name="" id="urlEliminarResponsabilidad" value="{{ url('cobertura/responsabilidad/eliminar') }}">

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