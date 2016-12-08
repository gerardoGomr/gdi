@if ($cobertura->tieneResponsabilidades())
    <table class="table table-bordered">
        <thead class="bg-gray">
            <tr>
                <th>CONCEPTO</th>
                <th>LIM. RESPONSABILIDAD</th>
                <th>CUOTA EXTRAORDINARIA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cobertura->getResponsabilidades() as $responsabilidad)
                <tr>
                    <td>{{ $responsabilidad->getCoberturaConcepto()->getConcepto() }}</td>
                    <td>{{ $responsabilidad->getLimiteResponsabilidad() }}</td>
                    <td>{{ $responsabilidad->getCuotaExtraordinaria() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h4>NO TIENE RESPONSABILIDADES ASIGNADAS</h4>
@endif