@if(!is_null($marca) && count($marca->getModelos()->getValues()) > 0)
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
    @foreach($marca->getModelos()->getValues() as $modelo)
        <option value="{{ $modelo->getId() }}">{{ $modelo->getModelo() }}</option>
    @endforeach
@else
    <option value="">SELECCIONE</option>
    <option value="-1">OTRO</option>
@endif