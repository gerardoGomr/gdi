@foreach($polizas as $poliza)
    <tr>
        <td>{{ $poliza->getVehiculo()->detalles() }}</td>
        <td>{{ $poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}</td>
        <td>
            @if($poliza->vigente())
                <span class="label label-success">VIGENTE</span>
                @if($poliza->estaDentroDePeriodoAptoParaRenovar())
                    <button type="button" class="btn btn-danger btn-sm renovar" data-id="{{ $poliza->getId() }}">RENOVAR PÓLIZA</button>
                @endif
            @else
                <button type="button" class="btn btn-danger btn-sm renovar" data-id="{{ $poliza->getId() }}">RENOVAR PÓLIZA</button>
            @endif
            <input type="hidden" class="vehiculo" value="{{ $poliza->getVehiculo()->detalles() }}">
            <input type="hidden" class="asociadoProtegido" value="{{ $poliza->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}">
            <input type="hidden" class="coberturaContratada" value="{{ $poliza->getCosto()->costoFormateado() . ': ' .$poliza->getCobertura()->detalles() }}">
        </td>
    </tr>
@endforeach