<table class="table table-primary text-small">
    <thead>
    <tr>
        <th>NOMBRE</th>
        <th>RFC</th>
        <th>CONTACTO</th>
        <th>DOMICILIO</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($asociados as $asociado)
        <tr>
            <td class="datos" data-tipo-persona="{{ $asociado->getTipoPersona() }}" data-nombre="{{ $asociado->getNombre() }}" data-paterno="{{ $asociado->getPaterno() }}" data-materno="{{ $asociado->getMaterno() }}" data-razon="{{ $asociado->getRazonSocial() }}" data-rfc="{{ $asociado->getRfc() }}" data-calle="{{ $asociado->getDomicilio()->getCalle() }}" data-num-exterior="{{ $asociado->getDomicilio()->getNumExterior() }}" data-num-interior="{{ $asociado->getDomicilio()->getNumInterior() }}" data-colonia="{{ $asociado->getDomicilio()->getColonia() }}" data-ciudad="" data-cp="{{ $asociado->getDomicilio()->getCp() }}" data-telefono="{{ $asociado->getTelefono() }}" data-email="{{ $asociado->getEmail() }}" data-celular="{{ $asociado->getCelular() }}">
                {{ $asociado->nombreCompleto() }}
            </td>
            <td>{{ $asociado->getRfc() }}</td>
            <td>{!! $asociado->getTelefono() . '<br>' . $asociado->getCelular() . '<br>' . $asociado->getEmail() !!}</td>
            <td>{{ $asociado->getDomicilio()->direccionCompleta() }}</td>
            <td><button class="btn btn-info seleccionarAsociado" type="button" data-toggle="tooltip" title="SELECCIONAR"><i class="fa fa-thumbs-o-up"></i></button></td>
        </tr>
    @endforeach
    </tbody>
</table>