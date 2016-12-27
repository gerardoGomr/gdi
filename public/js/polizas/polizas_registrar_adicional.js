// variables
var $datoAsociadoBuscar    = $('#datoAsociadoBuscar'),
	$formPoliza            = $('#formPoliza'),
	$tipoPersona           = $formPoliza.find('input.persona'),
	$buscarAsociado        = $('#buscarAsociado');
// =====================================================

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
			$buscarAsociado.val('1');

			if(resultado.estatus === 'fail') {
				bootbox.alert('NO SE ENCONTRARON ASOCIADOS QUE COINCIDAN CON EL PARÁMETRO: ' + $datoAsociadoBuscar.val() + ".\n\r POR FAVOR, REGISTRE LOS DATOS DEL ASOCIADO.", function () {

					$datoAsociadoBuscar.val('');
					$('#busquedaAsociado').addClass('hide');
					$('#capturarDatosAsociado').removeClass('hide');
					$('#asociadoNuevo').val('1');
				});
			}

			if (resultado.estatus === 'OK') {
				// mostrar los resultados en un modal

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
$('#modalidad').on('change', function() {
	if ($(this).val() === '-1') {
		$('#especifiqueOtraModalidad').removeClass('hide').focus();
	} else {
		$('#especifiqueOtraModalidad').addClass('hide');

		if ($('#cobertura').val() !== '' && $('#cobertura').val() !== '-1') {
			var url = $('#cobertura').data('url');
			buscarVigenciasCostos(url);
		}
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

// change a modelo de carro
$('#modelo').on('change', function (event) {
	if ($(this).val() === '-1') {
		$('#otroModelo').removeClass('hide');
		$('#otroModelo').siblings('div.separator').removeClass('hide');
		$('#otroModelo').focus();
	} else {
		$('#otroModelo').addClass('hide');
		$('#otroModelo').siblings('div.separator').addClass('hide');
	}
});

// change a cobertura tipo
$('#coberturaTipo').on('change', function() {
	var url = $(this).data('url');

	if ($(this).val() !== '' && $('#servicio').val() !== '') {
		$.ajax({
			url:      url,
			type:     'post',
			dataType: 'json',
			data: { coberturaTipoId: $('#coberturaTipo').val(), servicioId: $('#servicio').val(), _token: $formPoliza.find('input[name="_token"]').val() },
			beforeSend: function() {
				$('#loading').modal('show');
			}

		}).done(function (resultado) {
			$('#loading').modal('hide');
			$('#cobertura').html(resultado.html);

		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			$('#loading').modal('hide');
			console.log(textStatus + ': ' + errorThrown);
		});
	}
});

// change a cobertura
$('#cobertura').on('change', function (event) {
	var url = $(this).data('url');

	if ($(this).val() === '-1') {
		$('#registroCobertura').removeClass('hide');
		$('div.vigencias').removeClass('hide');
		$('#seleccionCobertura').addClass('hide');
		$('#desgloseResponsabilidades').addClass('hide');

		return false;

	} else {
		$('#registroCobertura').addClass('hide');
		$('div.vigencias').addClass('hide');
		$('#seleccionCobertura').removeClass('hide');
		$('#desgloseResponsabilidades').removeClass('hide');
	}

	if ($(this).val() === '') {
		bootbox.alert('SELECCIONE UNA COBERTURA.');

		return false;
	}

	if ($('#modalidad').val() === '') {
		bootbox.alert('POR FAVOR, SELECCIONE UNA MODALIDAD.');

		return false;
	}

	buscarVigenciasCostos(url);
});

// change a nueva vigencia
$('#vigenciasCobertura').on('change', function (event) {
	if ($(this).val() === '-1') {
		$('div.vigencias').removeClass('hide');
	} else {
		$('div.vigencias').addClass('hide');
	}
});

// change a nueva vigencia
$('#vigencias').on('change', function (event) {
	if ($(this).val() === '-1') {
		$formPoliza.find('div.nuevaVigencia').removeClass('hide');
	} else {
		$formPoliza.find('div.nuevaVigencia').addClass('hide');
	}
});

$('#agregarConceptoCobertura').on('click', function(event) {
	var concepto = $('#conceptoCobertura option:selected').text(),
		agregado = false;

	$('#responsabilidadDesglose').find('input.concepto').each(function() {
		if ($(this).val() === $('#conceptoCobertura').val()) {
			agregado = true;
		}
	});

	if (agregado) {
		bootbox.alert('ESTE CONCEPTO YA HA SIDO AGREGADO.');
		return false;
	}

	if ($('#conceptoCobertura').val() !== '') {
		var html = '<tr>' +
			'<td>' + concepto + '<input type="hidden" class="concepto" name="concepto[]" value="' + $('#conceptoCobertura').val() + '"></td>'+
			'<td><input type="text" name="limResponsabilidad[]" class="form-control"></td>'+
			'<td><input type="text" name="cuotaExtraordinaria[]" class="form-control"></td>'+
			'</tr>';

		$('#responsabilidadDesglose').append(html);
	}
});

// agregar una responsabilidad a cobertura
$('#agregarConceptoCoberturaExistente').on('click', function () {

	/*if ($('#limiteResponsabilidadExistente').val() === '' || $('#cuotaExtraordinariaExistente').val() === '' || $('#conceptoCoberturaExistente').val() === '') {
		bootbox.alert('ESPECIFIQUE EL CONCEPTO DE COBERTURA, LÍMITE DE RESPONSABILIDAD Y LA CUOTA EXTRAORDINARIA');
		return false;
	}*/

	var url      = $(this).data('url'),
		polizaId = $(this).data('id');

	$.ajax({
		url:        url,
		type:       'post',
		dataType:   'json',
		data:       {
			polizaId:              polizaId,
			coberturaConceptoId:   $('#conceptoCoberturaExistente').val(),
			responsabilidadId:     $('#responsabilidad').val(),
			limiteResponsabilidad: $('#limiteResponsabilidadExistente').val(),
			cuotaExtraordinaria:   $('#cuotaExtraordinariaExistente').val(),
			_token:                $formPoliza.find('input[name="_token"]').val()
		},
		beforeSend: function () {
			$('#loading').modal('show');
		}

	}).done(function (resultado) {
		$('#loading').modal('hide');

		if (resultado.estatus === 'fail') {
			var mensaje = resultado.mensaje !== '' ? resultado.mensaje : '';
			bootbox.alert('OCURRIÓ UN ERROR AL AGREGAR LA RESPONSABILIDAD A LA COBERTURA.' + mensaje);
		}

		if (resultado.estatus === 'OK') {
			bootbox.alert('RESPONSABILIDAD AGREGADA CON ÉXITO.');
			$('#responsabilidadDesgloseExistente').html(resultado.html);
		}

	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		$('#loading').modal('hide');
		console.log(textStatus + ': ' + errorThrown);
		bootbox.alert('OCURRIÓ UN ERROR AL AGREGAR LA RESPONSABILIDAD A LA COBERTURA.');
	});
});

// eliminar una responsabilidad de la cobertura existente
$('#responsabilidadDesgloseExistente').on('click', 'button.quitarResponsabilidad', function () {
	var url               = $('#urlEliminarResponsabilidad').val(),
		polizaId          = $('#agregarConceptoCoberturaExistente').data('id'),
		responsabilidadId = $(this).data('responsabilidadId');

	bootbox.confirm('¿REALMENTE DESEA ELIMINAR ESTA RESPONSABILIDAD DE LA COBERTURA?', function (r) {
		if (r) {
			$.ajax({
				url:        url,
				type:       'post',
				dataType:   'json',
				data:       {
					polizaId:          polizaId,
					responsabilidadId: responsabilidadId,
					_token:            $formPoliza.find('input[name="_token"]').val()
				},
				beforeSend: function () {
					$('#loading').modal('show');
				}

			}).done(function (resultado) {
				$('#loading').modal('hide');

				if (resultado.estatus === 'fail') {
					var mensaje = resultado.mensaje !== '' ? resultado.mensaje : '';
					bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR LA RESPONSABILIDAD DE LA COBERTURA. ' + mensaje);
				}

				if (resultado.estatus === 'OK') {
					bootbox.alert('RESPONSABILIDAD ELIMINADA CON ÉXITO.');
					$('#responsabilidadDesgloseExistente').html(resultado.html);
				}

			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				$('#loading').modal('hide');
				console.log(textStatus + ': ' + errorThrown);
				bootbox.alert('OCURRIÓ UN ERROR AL ELIMINAR LA RESPONSABILIDAD DE LA COBERTURA.');
			});
		}
	});
});

// mostrar responsabilidades en base a la coberturas conceptos
$('#conceptoCoberturaExistente').on('change', function(event) {
	var url = $(this).data('url');

	$.ajax({
		url:      url,
		type:     'post',
		dataType: 'json',
		data:     { coberturaConceptoId: $(this).val(), _token: $formPoliza.find('input[name="_token"]').val() },
		beforeSend: function() {
			$('#loading').modal('show');
		}

	}).done(function (resultado) {
		$('#loading').modal('hide');
		$('#responsabilidad').html(resultado.html);

	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		$('#loading').modal('hide');
		console.log(textStatus + ': ' + errorThrown);
	});
});

// mostrar campos adicionales a responsabilidades
$('#responsabilidad').on('change', function(event) {
	if ($(this).val() === '-1') {
		$('#datosResponsabilidadExistente').removeClass('hide');
	} else {
		$('#datosResponsabilidadExistente').addClass('hide');
	}
});

/**
 * buscar vigencias costos en base a cobertura y modalidad
 * @param url
 */
function buscarVigenciasCostos(url) {
	$.ajax({
		url:      url,
		type:     'post',
		dataType: 'json',
		data: { coberturaId: $('#cobertura').val(), modalidadId: $('#modalidad').val(), _token: $formPoliza.find('input[name="_token"]').val() },
		beforeSend: function() {
			$('#loading').modal('show');
		}

	}).done(function (resultado) {
		$('#loading').modal('hide');
		$('#vigenciaCobertura').html(resultado.html);

		$('#desgloseResponsabilidades').removeClass('hide').html(resultado.htmlResponsabilidades);

	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		$('#loading').modal('hide');
		console.log(textStatus + ': ' + errorThrown);
	});
}