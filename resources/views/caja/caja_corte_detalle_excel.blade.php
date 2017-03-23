<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table>
    <tr>
        <td><strong>AUDITOR:</strong></td>
        <td>{{ $corte->getAuditor()->nombreCompleto() }}</td>
    </tr>
    <tr>
        <td><strong>OFICINA:</strong></td>
        <td>{{ $corte->getOficina()->getNombre() }}</td>
    </tr>
    <tr>
        <td><strong>FECHA:</strong></td>
        <td>{{ \GDI\Aplicacion\Fecha::convertir($corte->fecha()) }}</td>
    </tr>
</table>

<table border="1">
    <thead>
    <tr>
        <th>FECHA</th>
        <th>ASOCIADO PROTEGIDO</th>
        <th>CAPTURÓ</th>
        <th>COSTO TOTAL</th>
        <th>FORMA DE PAGO</th>
        <th>PAGO EFECTIVO</th>
        <th>PAGO TARJETA</th>
        <th>PAGO CHEQUE</th>
    </tr>
    </thead>
    <tbody>
    @foreach($corte->getPolizasPagos() as $polizaPago)
        <tr>
            <td>{{ $polizaPago->getPoliza()->getFechaEmision() }}</td>
            <td>{{ $polizaPago->getPoliza()->getVehiculo()->getAsociadoProtegido()->nombreCompleto() }}</td>
            <td>{{ $polizaPago->getPoliza()->getUsuarioCaptura()->nombreCompleto() }}</td>
            <td>{{ $polizaPago->getPoliza()->getCosto()->costoFormateado() }}</td>
            <td>{{ $polizaPago->getPoliza()->formaPago() }}</td>
            <td>{{ $polizaPago->esPagoEnEfectivo() ? $polizaPago->abonoFormateado() : '-' }}</td>
            <td>{{ $polizaPago->esPagoConTarjeta() ? $polizaPago->abonoFormateado() : '-' }}</td>
            <td>{{ $polizaPago->esPagoConCheque() ? $polizaPago->abonoFormateado() : '-' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>