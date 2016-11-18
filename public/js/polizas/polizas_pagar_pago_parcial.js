$(document).ready(function() {
	var costo       = Number($('#costo').val()),
		$metodoPago = $('#metodoPago');

	init();
	$('#formPago').validate();

	// metodo de pago
	$metodoPago.on('change', function() {
		evaluarMetodoYFormaPago();
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
	
	// funcion para evaluar el medio y forma de pago
	function evaluarMetodoYFormaPago () {
		if ($metodoPago.val() === '') {
			bootbox.alert('Por favor, seleccione el método de pago');
			return false;
		}

		// en efectivo
		if ($metodoPago.val() === '1') {
			// en efectivo
			$('#cobroEfectivo').removeClass('hide');

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


		// parcial
		/*if ($formaPago.val() === '2') {
			// calcular el costo minimo a cubrir
			var costoMinimo = costo * 0.5;

			if ($metodoPago.val() === '1') {
				// en efectivo
				$('#abono').removeClass('hide');
				$('#cobroEfectivo').removeClass('hide');
				$('#cantidadAAbonar').rules('add', {
					required: true,
					min: costoMinimo,
					max: costo,
					messages: {
						required: 'Campo obligatorio',
						min: 'Ingrese una cantidad igual o mayor a ' + costoMinimo,
						max: 'Ingrese una cantidad menor a ' + costo
					}
				});

				$('#montoPago').rules('add', {
					required: true,
					messages: {
						required: 'Campo obligatorio'
					}
				});

				$('#cambio').rules('add', {
					required: true,
					messages: {
						required: 'Campo obligatorio'
					}
				});

			} else {
				$('#cobroEfectivo').addClass('hide');
				$('#montoPago').rules('remove');
				$('#cambio').rules('remove');

				// tarjeta de crédito
				$('#abono').removeClass('hide');

				$('#cantidadAAbonar').rules('add', {
					required: true,
					min: costoMinimo,
					max: costo,
					messages: {
						required: 'Campo obligatorio',
						min: 'Ingrese una cantidad igual o mayor a ' + costoMinimo,
						max: 'Ingrese una cantidad menor a ' + costo
					}
				});
			}
		}*/
	}

	// agregando la validación de cantidad a abonar cuando es pago parcial o semestral
	/*$('#cantidadAAbonar').on('keyup', function () {
		var cantidad = Number($(this).val());

		$('#montoPago').rules('add', {
			min: cantidad,
			messages: {
				min: 'Ingrese una cantidad igual o mayor a ' + cantidad
			}
		});
	});*/

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