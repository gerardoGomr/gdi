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