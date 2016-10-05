@if(count($cobertura) > 0)
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
    @foreach($cobertura->getCostos()->getValues() as $costo)
        <option value="{{ $costo->getId() }}">{{ $costo->getVigencia()->getVigencia() . ' --- $' . number_format($costo->getCosto(), 2) }}</option>
    @endforeach
@else
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
@endif