<option value="">SELECCIONE</option>
<option value="-1">OTRA RESPONSABILIDAD</option>
@if(!is_null($responsabilidades))
	@foreach($responsabilidades as $responsabilidad)
	    <option value="{{ $responsabilidad->getId() }}">{{ $responsabilidad->getCoberturaConcepto()->getConcepto() }} - {{ $responsabilidad->getLimiteResponsabilidad() }} - {{ $responsabilidad->getCuotaExtraordinaria() }}</option>
	@endforeach
@endif