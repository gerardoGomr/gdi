@if(!is_null($cobertura))
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
    @foreach($cobertura->getCostos() as $costo)
        @if($costo->getModalidad()->getId() === $modalidad->getId())
            <option value="{{ $costo->getId() }}">{{ $costo->getVigencia()->getVigencia() . ' MESES --- $' . number_format($costo->getCosto(), 2) }}</option>
        @endif
    @endforeach
@else
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
@endif