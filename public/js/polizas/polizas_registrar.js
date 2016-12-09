$(document).ready(function() {
	// variables
	var $datosAsociado         = $('#datosAsociado'),
		$datosVehiculo         = $('#datosVehiculo'),
		$datosCobertura        = $('#datosCobertura'),
		$busquedaVehiculo      = $('#busquedaVehiculo'),
		$datoVehiculoBuscar    = $('#datoVehiculoBuscar'),
		$datoAsociadoBuscar    = $('#datoAsociadoBuscar'),
		$datosAsociadoAgente   = $('#datosAsociadoAgente'),
		$formPoliza            = $('#formPoliza'),
		$buscarAsociado        = $('#buscarAsociado');

	// focus a primer elemento
	setTimeout(function () {
		$('#datoVehiculoBuscar').focus();
	}, 500);

	// validación a formulario
	init();
	$formPoliza.validate();
	agregaValidacionesElementos($formPoliza);
	// =====================================================

	// evitar submit normal
	$('#datoVehiculoBuscar, #datoAsociadoBuscar').on('keypress', function(event) {
		if (event === 13 || event.which === 13) {
			return false;
		}
	});

	// buscar vehículo mediante serie o motor
	$datoVehiculoBuscar.on('keyup', function(event) {
		var url = $(this).data('url');

		if (event === 13 || event.which === 13) {
			$.ajax({
				url:      url,
				type:     'post',
				dataType: 'json',
				data:     { dato: $datoVehiculoBuscar.val(), _token: $formPoliza.find('input[name="_token"]').val() },
				beforeSend: function() {
					$('#loading').modal('show');
				}

			}).done(function (resultado) {
				$('#loading').modal('hide');

				if (resultado.estatus === 'fail') {
					bootbox.alert('NO SE ENCONTRARON VEHÍCULOS QUE COINCIDAN CON EL PARÁMETRO: ' + $datoVehiculoBuscar.val() + ".\n\r POR FAVOR, REGISTRE LOS DATOS DEL VEHÍCULO.", function () {
						$('#registro').html(resultado.html);
						$('#numSerie').val($datoVehiculoBuscar.val());
						$('#numMotor').val($datoVehiculoBuscar.val());
						$datoVehiculoBuscar.val('');
						$busquedaVehiculo.addClass('hide');
						$datosAsociadoAgente.removeClass('hide');
						$('#vehiculoNuevo').val('1');
					});
				}

				if (resultado.estatus === 'OK') {
					bootbox.alert(resultado.mensaje, function () {
						if (resultado.sePuedeRenovar === 'OK') {
							$('#registro').html(resultado.html);
							$datosAsociadoAgente.removeClass('hide');
						}
					});
				}

			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				$('#loading').modal('hide');
				console.log(textStatus + ': ' + errorThrown);
				bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR LA BÚSQUEDA DE VEHÍCULO. INTENTE DE NUEVO.');
			});
		}
	});
	
	// renovar póliza
	$('#modalResultadoVehiculos').on('click', 'button.renovar', function () {
		var polizaId = $(this).data('id');

		bootbox.confirm('¿CONFIRMA QUE SE RENOVARÁ LA PÓLIZA A ESTE VEHÍCULO?', function (r) {
			if (r) {
				var url      = $('#urlBuscarPolizaExistente').val(),
					datos    = {
						polizaId: polizaId,
						_token:   $formPoliza.find('input[name="_token"]').val(),
					};

				$.ajax({
					url:        url,
					type:       'post',
					dataType:   'json',
					data:       datos,
					beforeSend: function () {
						$('#loading').modal('show');
					}

				}).done(function (resultado) {
					$('#loading').modal('hide');
					$('#registro').html(resultado.html);
					$busquedaVehiculo.addClass('hide');
					$datosAsociadoAgente.removeClass('hide');

				}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
					console.log(textStatus + ': ' + errorThrown);
					$('#loading').modal('hide');
					bootbox.alert('OCURRIÓ UN ERROR AL REALIZAR EL PROCESO DE RENOVACIÓN. INTENTE DE NUEVO');
				});

				$('#modalResultadoVehiculos').modal('hide');
			}
		});
	});

	// buscar vehículo nuevamente
	$('#botonBuscarVehiculoNuevamente').on('click', function () {
		$busquedaVehiculo.removeClass('hide');
		$datosVehiculo.addClass('hide');
		$datosAsociado.addClass('hide');
		$datosAsociadoAgente.addClass('hide');
		$datosCobertura.addClass('hide');
		$datoVehiculoBuscar.focus();
	});

	// cancelar registro
	$('#cancelar').on('click', function (event) {
		event.preventDefault();

		bootbox.confirm('¿DESEA CANCELAR LA CAPTURA Y REGRESAR AL LISTADO DE PÓLIZAS?', function (e) {
			if (e === true) {
				window.location.href = $('#cancelar').attr('href');
			}
		});
	});

	// change a asociado agente
	$('#asociadoAgente').on('change', function (event) {
		if ($(this).val() === '1') {
			$('#datosCapturaAsociadoAgente').removeClass('hide');
		} else {
			$('#datosCapturaAsociadoAgente').addClass('hide');
		}
	});

	// registrar póliza
	$('#registrarPoliza').on('click', function () {
		// validación de form de pólizas
		if (!$formPoliza.valid()) {
			return false;
		}

		// validación de búsqueda de asociado
		if ($buscarAsociado.val() === '0') {
			bootbox.alert('POR FAVOR, BUSQUE Y SELECCIONE A UN ASOCIADO PROTEGIDO.', function () {
				setTimeout(function () {
					$datoAsociadoBuscar.focus();
				}, 500);
			});

			return false;
		}

		$.ajax({
			url:      $formPoliza.attr('action'),
			type:     'post',
			dataType: 'json',
			data:     $formPoliza.serialize(),
			beforeSend: function() {
				$('#loading').modal('show');
			}

		}).done(function (respuesta) {
			$('#loading').modal('hide');

			if (respuesta.estatus === 'fail') {
				bootbox.alert('OCURRIÓ UN ERROR AL GUARDAR LA PÓLIZA. POR FAVOR, INTENTE DE NUEVO.');
			}

			if (respuesta.estatus === 'OK') {
				bootbox.alert('PÓLIZA GENERADA CON ÉXITO.', function() {
					// redireccionar a pago de póliza
					window.location.href = $('#urlPago').val() + '/' + respuesta.id;
				});
			}

		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			console.log(textStatus + ': ' + errorThrown);
			$('#loading').modal('hide');
			bootbox.alert('OCURRIÓ UN ERROR AL GUARDAR LA PÓLIZA. POR FAVOR, INTENTE DE NUEVO.');
		});
	});
});