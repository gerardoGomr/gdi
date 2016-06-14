$(document).ready(function() {
	// variables
	var $datosAsociado    = $('#datosAsociado'),
		$datosVehiculo    = $('#datosVehiculo'),
		$datosCobertura   = $('#datosCobertura'),
		$busquedaVehiculo = $('#busquedaVehiculo'),
		$datoVehiculo     = $('#datoVehiculo'),
		$datoAsociado     = $('#datoAsociado'),
		$formPoliza		  = $('#formPoliza'),
		$registrarAsociado= $('#registrarAsociado'),
		$tipoPersona      = $formPoliza.find('input.persona');

	// evitar submit normal
	$('#datoVehiculo, #datoAsociado').on('keypress', function(event) {
		if (event === 13 || event.which === 13) {
			return false;
		}
	});

	// buscar vehículo mediante serie o motor
	$datoVehiculo.on('keyup', function(event) {
		if (event === 13 || event.which === 13) {
			bootbox.alert('NO SE ENCONTRARON COINCIDENCIAS CON EL PARÁMETRO ' + $(this).val() + '. POR FAVOR, REGISTRE LOS DATOS DEL VEHÍCULO.', function () {
				$busquedaVehiculo.addClass('hide');
				$datosAsociado.removeClass('hide');

				setTimeout(function () {
					$('#datoAsociado').focus();
				}, 500);
			});
		}
	});

	// buscar asociado mediante dato: nombre, RFC
	$datoAsociado.on('keyup', function(event) {
		if (event === 13 || event.which === 13) {
			bootbox.alert('NO SE ENCONTRARON COINCIDENCIAS CON EL PARÁMETRO ' + $(this).val() + '. POR FAVOR, REGISTRE LOS DATOS DEL ASOCIADO PROTEGIDO.', function () {
				$datosVehiculo.removeClass('hide');
				$datosCobertura.removeClass('hide');
				$('#acciones').find('.hide').removeClass('hide');
				$registrarAsociado.removeClass('hide');
			});
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
		})
	})

	// focus a primer elemento
	setTimeout(function () {
		$('#datoVehiculo').focus();
	}, 500);
});