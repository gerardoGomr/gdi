$(document).ready(function() {
    $('#formFiltro').find('input.fecha').datepicker({
        autoclose: true,
        language:  'es',
        format:    'dd/mm/yyyy'
    });

    $('#buscar').on('click', function () {
        $.ajax({
            url:        $('#formFiltro').attr('action'),
            type:       'post',
            dataType:   'json',
            data:       $('#formFiltro').serialize(),
            beforeSend: function () {
                $('#loading').modal('show');
            }

        }).done(function (respuesta) {
            $('#loading').modal('hide');

            $('#resultadoBusqueda').html(respuesta.html);
            datatables('#tablaPolizas', 0);

        }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loading').modal('hide');

            bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA. INTENTE DE NUEVO.')
        });
    });

    datatables('#tablaPolizas', 0);
});