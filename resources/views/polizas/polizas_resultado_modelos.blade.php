@if(count($marca->getModelos()->getValues()))
    <option value="">SELECCIONE</option>
    <option value="1">OTRO</option>
    @foreach($marca->getModelos()->getValues() as $modelo)
        <option value="{{ $modelo->getId() }}">{{ $modelo->getModelo() }}</option>
    @endforeach
@else
    <option value="1">OTRO</option>
    <option value="">SELECCIONE</option>
@endif