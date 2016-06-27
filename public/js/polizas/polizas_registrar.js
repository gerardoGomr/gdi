$(document).ready(function() {
	// variables
	var $datosAsociado       = $('#datosAsociado'),
		$datosVehiculo       = $('#datosVehiculo'),
		$datosCobertura      = $('#datosCobertura'),
		$busquedaVehiculo    = $('#busquedaVehiculo'),
		$datoVehiculo        = $('#datoVehiculo'),
		$datoAsociado        = $('#datoAsociado'),
		$datosAsociadoAgente = $('#datosAsociadoAgente'),
		$formPoliza          = $('#formPoliza'),
		$registrarAsociado   = $('#registrarAsociado'),
		$tipoPersona         = $formPoliza.find('input.persona'),
		$polizaNueva		 = $('#polizaNueva'),
		$asociadoNuevo		 = $('#asociadoNuevo'),
		$vehiculoNuevo		 = $('#vehiculoNuevo'),
		$coberturaNueva		 = $('#coberturaNueva'),
		$buscarAsociado		 = $('#buscarAsociado'),
		$asociadoElegido     = $('#asociadoElegido');

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
				//$busquedaVehiculo.addClass('hide');
				//$datosAsociado.removeClass('hide');
				//$datosAsociadoAgente.removeClass('hide');
				$('#vehiculoNoEncontrado').text('NO SE ENCONTRARON COINCIDENCIAS DE NÚMERO DE SERIE O MOTOR " ' + $datoVehiculo.val() + ' "');
				$('#vehiculoNoEncontrado').removeClass('hide');
				$('#numSerie').val($datoVehiculo.val());
				$('#numMotor').val($datoVehiculo.val());
				$datoVehiculo.val('');
				$datosVehiculo.removeClass('hide');
				$datosCobertura.removeClass('hide');
				//$('#acciones').find('.hide').removeClass('hide');

				// setTimeout(function () {
				// 	$('#datoAsociado').focus();
				// }, 500);
			});
		}
	});

	// buscar asociado mediante dato: nombre, RFC
	$datoAsociado.on('keyup', function(event) {
		if (event === 13 || event.which === 13) {
			/*bootbox.alert('NO SE ENCONTRARON COINCIDENCIAS CON EL PARÁMETRO ' + $(this).val() + '. POR FAVOR, REGISTRE LOS DATOS DEL ASOCIADO PROTEGIDO.', function () {
				$registrarAsociado.removeClass('hide');
				$buscarAsociado.val('1');
			});*/
			$('#resultadoAsociados').click();
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
					$datoAsociado.focus();
				}, 500);
			});

			return false;
		}
	});

	// focus a primer elemento
	setTimeout(function () {
		$('#datoVehiculo').focus();
	}, 500);
});