<div class="row">
    <div class="col-md-7">
        <table>
            <tr>
                <td class="strong">AUDITOR:</td>
                <td>{{ $corte->getAuditor()->nombreCompleto() }}</td>
            </tr>
            <tr>
                <td class="strong">OFICINA:</td>
                <td>{{ $corte->getOficina()->getNombre() }}</td>
            </tr>
            <tr>
                <td class="strong">FECHA:</td>
                <td>{{ \GDI\Aplicacion\Fecha::convertir($corte->fecha()) }}</td>
            </tr>
        </table>
    </div>
    <div class="col-md-5">
        <a href="/caja/cortes/pdf/{{ base64_encode($corte->getId()) }}" class="btn btn-inverse" target="_blank"><i class="fa fa-file"></i> EXPORTAR A PDF</a>
        <a href="/caja/cortes/excel/{{ base64_encode($corte->getId()) }}" class="btn btn-inverse"><i class="fa fa-table"></i> EXPORTAR A EXCEL</a>
    </div>
</div>

<table class="table table-striped table-bordered table-hover table-primary">
    <thead>
    <tr>
        <th>FECHA</th>
        <th>ASOCIADO PROTEGIDO</th>
        <th>CAPTURÓ</th>
        <th>COSTO TOTAL</th>
        <th>FORMA DE PAGO</th>
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
        </tr>
    @endforeach
    </tbody>
</table>