$(document).ready(function() {
	var costo       = Number($('#costo').val()),
		$metodoPago = $('#metodoPago');

	init();
	$('#formPago').validate();

	$metodoPago.on('change', function() {
		if ($metodoPago.val() === '') {
			bootbox.alert('Por favor, seleccione el método de pago');
			return false;
		}

		// de contado
		if ($metodoPago.val() === '1') {
			// en efectivo
			$('#cobroEfectivo').removeClass('hide');
			$('#abono').addClass('hide');
			$('#cantidadAAbonar').rules('remove');
			$('#montoPago').rules('add', {
				required: true,
				min: Number($('#costo').val()),
				messages: {
					required: 'Campo obligatorio',
					min: 'Ingrese una cantidad igual o mayor a ' + costo
				}
			});

			$('#cambio').rules('add', {
				required: true,
				min: 0,
				messages: {
					required: 'Campo obligatorio',
					min: 'Ingrese una cantidad igual o mayor a 0'
				}
			});

		} else {
			$('#cobroEfectivo').addClass('hide');
			$('#montoPago').rules('remove');
			$('#cambio').rules('remove');
		}
	});

	// procesar pago
	$('#realizarCobro').on('click', function () {
		if ($('#formPago').valid()) {
			$.ajax({
				url:      $('#formPago').attr('action'),
				type:     'post',
				dataType: 'json',
				data:     $('#formPago').serialize(),
				beforeSend: function() {
					$('#loading').modal('show');
				}

			}).done(function (respuesta) {
				$('#loading').modal('hide');

				if (respuesta.estatus === 'fail') {
					bootbox.alert('OCURRIÓ UN ERROR AL REGISTRAR EL PAGO DE LA PÓLIZA. INTENTE DE NUEVO');
				}

				if (respuesta.estatus === 'OK') {
					bootbox.alert('PAGO DE PÓLIZA REGISTRADO CON ÉXITO', function () {
						// evaluar si se mandará a abrir el formato final o el parcial
						if (respuesta.sePuedeGenerarFormato === 'OK') {
							// abrir formato final
							window.open($('#urlFormato').val());
						}

						if (respuesta.generarFormatoParcial === 'OK') {
							// abrir formato parcial
							window.open($('#urlFormatoParcial').val());
						}

						// redirigir a pantalla principal
						window.location.href = $('#urlPrincipal').val();
					});

				}

			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				$('#loading').modal('hide');
				console.log(textStatus + ': ' + errorThrown);
				bootbox.alert('OCURRIÓ UN ERROR AL REGISTRAR EL PAGO DE LA PÓLIZA. INTENTE DE NUEVO');
			});
		}
	});

	// agregando la validación de cantidad a abonar cuando es pago parcial o semestral
	$('#cantidadAAbonar').on('keyup', function () {
		var cantidad = Number($(this).val());

		$('#montoPago').rules('add', {
			min: cantidad,
			messages: {
				min: 'Ingrese una cantidad igual o mayor a ' + cantidad
			}
		});
	});

	// pago cambio
	$('#montoPago').on('keyup', function(event) {
		var cambio;
		if ($metodoPago.val() === '1') {
			// efectivo de contado
			cambio = Number($(this).val()) - costo;
			$('#cambio').val(cambio);
		}
	});
});