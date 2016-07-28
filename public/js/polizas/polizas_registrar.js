$(document).ready(function() {
	// variables
	var $datosAsociado         = $('#datosAsociado'),
		$datosVehiculo         = $('#datosVehiculo'),
		$datosCobertura        = $('#datosCobertura'),
		$busquedaVehiculo      = $('#busquedaVehiculo'),
		$datoVehiculoBuscar    = $('#datoVehiculoBuscar'),
		$capturarDatosVehiculo = $('#capturarDatosVehiculo'),
		$datoAsociadoBuscar    = $('#datoAsociadoBuscar'),
		$datosAsociadoAgente   = $('#datosAsociadoAgente'),
		$formPoliza            = $('#formPoliza'),
		$tipoPersona           = $formPoliza.find('input.persona'),
		$buscarAsociado        = $('#buscarAsociado');

	// focus a primer elemento
	setTimeout(function () {
		$('#datoVehiculoBuscar').focus();
	}, 500);

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

						$('#numSerie').val($datoVehiculoBuscar.val());
						$('#numMotor').val($datoVehiculoBuscar.val());
						$datoVehiculoBuscar.val('');
						$busquedaVehiculo.addClass('hide');
						$capturarDatosVehiculo.removeClass('hide');
						$datosAsociado.removeClass('hide');
						$datosAsociadoAgente.removeClass('hide');
						$datosCobertura.removeClass('hide');
					});
				}

			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				$('#loading').modal('hide');
				console.log(textStatus + ': ' + errorThrown);
			});
		}
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

	// buscar asociado mediante dato: nombre, RFC
	$datoAsociadoBuscar.on('keyup', function(event) {
		var url = $(this).data('url');
		if (event === 13 || event.which === 13) {
			$.ajax({
				url:      url,
				type:     'post',
				dataType: 'json',
				data:     { datoAsociado: $datoAsociadoBuscar.val(), _token: $formPoliza.find('input[name="_token"]').val() },
				beforeSend: function () {
					$('#loading').modal('show');
				}

			}).done(function (resultado) {
				$('#loading').modal('hide');

				if(resultado.estatus === 'fail') {
					bootbox.alert('NO SE ENCONTRARON ASOCIADOS QUE COINCIDAN CON EL PARÁMETRO: ' + $datoAsociadoBuscar.val() + ".\n\r POR FAVOR, REGISTRE LOS DATOS DEL ASOCIADO.", function () {

						$datoAsociadoBuscar.val('');
						$('#busquedaAsociado').addClass('hide');
						$('#capturarDatosAsociado').removeClass('hide');
					});
				}

				if (resultado.estatus === 'OK') {

				}

			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				$('#loading').modal('hide');

				console.log(textStatus + ': ' + errorThrown);
			});
		}
	});

	// cargar combo de modelos o mostrar el especifique en caso que sea = 1
	$('#marca').on('change', function() {
		var url     = $(this).data('url'),
			marcaId = Number($(this).val());

		if (marcaId === 1) {
			$('#otraMarca, #otroModelo').removeClass('hide');
			$('#modelo').addClass('hide');
			$('#otraMarca').focus();
		}

		if (marcaId > 1) {
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: { marcaId: marcaId, _token: $formPoliza.find('input[name="_token"]').val() },
				beforeSend: function() {
					$('#loading').modal('show');
				}

			}).done(function (resultado) {
				$('#loading').modal('hide');

				$('#modelo').html(resultado.html).removeClass('hide');
				$('#otraMarca, #otroModelo').addClass('hide');

			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				$('#loading').modal('hide');
				console.log(textStatus + ': ' + errorThrown);
			});
		}
	});

	// modalidad selección de otro
	$('#modalidad').on('click', function() {
		if ($(this).val() === '1') {
			$('#especifiqueOtraModalidad').removeClass('hide').focus();
		} else {
			$('#especifiqueOtraModalidad').addClass('hide');
		}
	});

	// click en tipo de persona
	$tipoPersona.on('click', function () {
		if ($(this).val() === '1') {
			$formPoliza.find('div.fisica').removeClass('hide');
			$formPoliza.find('div.moral').addClass('hide');
		}

		if ($(this).val() === '2') {
			$formPoliza.find('div.fisica').addClass('hide');
			$formPoliza.find('div.moral').removeClass('hide');
		}
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

	// change a modelo de carro
	$('#modelo').on('change', function (event) {
		if ($(this).val() === '1') {
			$('#otroModelo').removeClass('hide');
			$('#otroModelo').siblings('div.separator').removeClass('hide');
			$('#otroModelo').focus();
		} else {
			$('#otroModelo').addClass('hide');
			$('#otroModelo').siblings('div.separator').addClass('hide');
		}
	});

	// change a servicio de vehículo
	$('#servicio').on('change', function (event) {
		var servicioTexto = $(this).find('option:selected').text();
		$('#coberturaServicio').text(servicioTexto);

		if ($(this).val() === '1') {
			$('#otroServicio').removeClass('hide');
			$('#otroServicio').siblings('div.separator').removeClass('hide');
			$('#otroServicio').focus();
		} else {
			$('#otroServicio').addClass('hide');
			$('#otroServicio').siblings('div.separator').addClass('hide');
		}
	});

	// change a asociado agente
	$('#asociadoAgente').on('change', function (event) {
		if ($(this).val() === '1') {
			$('#datosCapturaAsociadoAgente').removeClass('hide');
		} else {
			$('#datosCapturaAsociadoAgente').addClass('hide');
		}
	});

	// change a cobertura
	$('#cobertura').on('change', function (event) {
		if ($(this).val() === '1') {
			$('#registroCobertura').removeClass('hide');
			$('#vigenciaCobertura').addClass('hide');
			$formPoliza.find('label.vigenciaCobertura').addClass('hide');
		} else {
			$('#registroCobertura').addClass('hide');
			$('#vigenciaCobertura').removeClass('hide');
			$formPoliza.find('label.vigenciaCobertura').removeClass('hide');
		}
	});

	// change a nueva vigencia
	$('#vigencias').on('change', function (event) {
		if ($(this).val() === '1') {
			$formPoliza.find('div.nuevaVigencia').removeClass('hide');
		} else {
			$formPoliza.find('div.nuevaVigencia').addClass('hide');
		}
	});

	// registrar póliza
	$('#registrarPoliza').on('click', function (event) {
		event.preventDefault();
		// validación de form de pólizas

		// validación de búsqueda de asociado
		if ($buscarAsociado.val() === '0') {
			bootbox.alert('POR FAVOR, BUSQUE Y SELECCIONE A UN ASOCIADO PROTEGIDO.', function () {
				setTimeout(function () {
					$datoAsociadoBuscar.focus();
				}, 500);
			});

			return false;
		}
	});
});