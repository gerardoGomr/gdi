@if(count($coberturas) > 0)
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
    @foreach($coberturas as $cobertura)
        <option value="{{ $cobertura->getId() }}">{{ $cobertura->getNombre() }}</option>
    @endforeach
@else
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
@endif