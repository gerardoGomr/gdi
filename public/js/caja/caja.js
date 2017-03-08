$(document).ready(function() {
    var $formGenerarCorte = $('#formGenerarCorte');

    $('#fechaCorte').datepicker({
        autoclose: true,
        language:  'es',
        format:    'dd/mm/yyyy'

    }).on('show', function() {
        // Obtener valores actuales z-index de cada elemento
        var zIndexModal = $('#modalNuevoCorte').css('z-index');

        $('.datepicker').css('z-index', zIndexModal + 1);
    });

    init();
    $formGenerarCorte.validate();
    agregaValidacionesElementos($formGenerarCorte);

    // generar datatables si existen registros
    if ($('#existenCortes').val() === '1') {
        datatables('#tablaCortes', 0);
    }

    // Generar corte de caja
    $('#generarCorte').on('click', function () {
        if ($formGenerarCorte.valid()) {
            $.ajax({
                url:        $formGenerarCorte.attr('action'),
                type:       'post',
                dataType:   'json',
                data:       $formGenerarCorte.serialize(),
                beforeSend: function () {
                    $('#loadingGenerarCorte').removeClass('hide');
                    $('#generarCorte').addClass('hide');
                }

            }).done(function (respuesta) {
                console.log(respuesta.estatus);
                $('#loadingGenerarCorte').addClass('hide');
                $('#generarCorte').removeClass('hide');

                if (respuesta.estatus === 'OK') {
                    bootbox.alert('CORTE DE CAJA GENERADO CON ÉXITO', function () {
                        // abrir PDF del corte y redirigir a lista de cortes
                        window.open('');

                        recargarTablaCortes();
                    });
                }

                if (respuesta.estatus === 'fail') {
                    var mensaje = respuesta.mensaje !== '' ? respuesta.mensaje : '';
                    bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR EL CORTE DE CAJA. POR FAVOR INTENTE DE NUEVO.<br>' + mensaje);
                }

            }).fail(function (jqXhr, textStatus, errorThrown) {
                console.log(textStatus + ': ' + errorThrown);
                $('#loadingGenerarCorte').addClass('hide');
                $('#generarCorte').removeClass('hide');
                bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR EL CORTE DE CAJA. POR FAVOR INTENTE DE NUEVO');
            });
        }
    });

    // ver el detalle de un corte
    $('#resultadoBusqueda').on('click', 'button.verDetalle', function () {
        var id = $(this).data('id');

        $.ajax({
            url:        '/caja/cortes/detalle/' + id,
            type:       'GET',
            dataType:   'json',
            beforeSend: function () {
                $('#loading').modal('show');
            }

        }).done(function (respuesta) {
            console.log(respuesta.estatus);
            $('#loading').modal('hide');

            if (respuesta.estatus === 'OK') {
                $('#modalCorteDetalle').find('div.modal-body').html(respuesta.html);
                $('#modalCorteDetalle').modal('show');
            }

            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL ABRIR EL DETALLE DEL CORTE SELECCIONADO. POR FAVOR, INTENTE DE NUEVO');
            }

        }).fail(function (jqXhr, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loading').modal('hide');
            bootbox.alert('OCURRIÓ UN ERROR AL ABRIR EL DETALLE DEL CORTE SELECCIONADO. POR FAVOR, INTENTE DE NUEVO');
        });
    });
    
    // recargar tabla de cortes
    function recargarTablaCortes() {
        var url = $('#resultadoBusqueda').data('url');

        $.ajax({
            url:        url,
            type:       'post',
            dataType:   'json',
            beforeSend: function () {
                $('#loading').modal('show');
            }

        }).done(function (respuesta) {
            console.log(respuesta.estatus);
            $('#loading').modal('hide');

            if (respuesta.estatus === 'OK') {
                $('#resultadoBusqueda').html(respuesta.html);
            }

            if (respuesta.estatus === 'fail') {
                bootbox.alert('OCURRIÓ UN ERROR AL RECARGAR LA TABLA DE CORTES DE CAJA.');
            }

        }).fail(function (jqXhr, textStatus, errorThrown) {
            console.log(textStatus + ': ' + errorThrown);
            $('#loading').modal('hide');
            bootbox.alert('OCURRIÓ UN ERROR AL RECARGAR LA TABLA DE CORTES DE CAJA.');
        });
    }
});