@if(!is_null($cortes))
    <table class="table table-striped table-bordered table-hover table-primary" id="tablaCortes">
        <thead>
        <tr>
            <th>FECHA</th>
            <th>AUDITOR</th>
            <th>CANTIDAD DE PÓLIZAS</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cortes as $corte)
            <tr>
                <td>{{ $corte->fecha() }}</td>
                <td>{{ $corte->getAuditor()->nombreCompleto() }}</td>
                <td>{{ $corte->cantidadPolizas() }}</td>
                <td>
                    <div class="btn-group btn-group-xs">
                        <button class="btn bg-primary verDetalle" type="button" data-toggle="tooltip" title="VER DETALLE" data-id="{{ $corte->getId() }}"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-danger eliminarCorte" type="button" data-toggle="tooltip" title="ELIMINAR CORTE"><i class="fa fa-times"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <input type="hidden" id="existenCortes" value="1">
@else
    <h4>NO SE HAN REGISTRADO CORTES DE CAJA.</h4>
    <input type="hidden" id="existenCortes" value="0">
@endif