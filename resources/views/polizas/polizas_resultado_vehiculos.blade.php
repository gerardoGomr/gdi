<div class="modal fade" id="modalResultadoVehiculos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title">RESULTADO DE LA BÚSQUEDA</h3>
            </div>

            <div class="modal-body">
                <table class="table table-bordered table-hover text-small">
                    <thead>
                        <tr class="bg-primary">
                            <th>VEHÍCULO</th>
                            <th>ASOC. PROTEGIDO</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($polizas as $poliza)
                            <tr>
                                <td>{{ $poliza->getVehiculo()->detalles() }}</td>
                                <td>{{ $poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}</td>
                                <td>
                                    @if($poliza->vigente())
                                        <span class="label label-success">VIGENTE</span>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm">RENOVAR PÓLIZA</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>