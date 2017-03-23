// variables
var $datoAsociadoBuscar      = $('#datoAsociadoBuscar'),
	$formPoliza              = $('#formPoliza'),
	$tipoPersona             = $formPoliza.find('input.persona'),
	$buscarAsociado          = $('#buscarAsociado')
	numeroConceptosCobertura = 0;
// =====================================================

// agregar las validaciones pertinentes
validarCampos();

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
					validarCamposAsociadoProtegido();
					$('#capturarDatosAsociado').removeClass('hide');
					$('#asociadoNuevo').val('1');
					$(".hasNiceScroll").getNiceScroll().resize();
				});
			}

			if (resultado.estatus === 'OK') {
				// mostrar los resultados en un modal
				$('#resultadoAsociados').html(resultado.html);
				$('#modalResultadoAsociados').modal('show');
			}

		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			$('#loading').modal('hide');

			console.log(textStatus + ': ' + errorThrown);
		});
	}
});

$('#buscarOtroAsociadoProtegido').on('click', function(event) {
	$('#busquedaAsociado').removeClass('hide');
	$('#capturarDatosAsociado').addClass('hide');
	$('#datoAsociadoBuscar').focus();
});

// elegir un asociado protegido del modal y presentar información
$('#resultadoAsociados').on('click', 'button.seleccionarAsociado', function () {
	var $td         = $(this).parents('td').siblings('td.datos'),
		tipoPersona = $td.data('tipoPersona'),
		nombre      = $td.data('nombre'),
		paterno     = $td.data('paterno'),
		materno     = $td.data('materno'),
		razon       = $td.data('razon'),
		rfc         = $td.data('rfc'),
		calle       = $td.data('calle'),
		numExterior = $td.data('numExterior'),
		numInterior = $td.data('numInterior'),
		colonia     = $td.data('colonia'),
		cp          = $td.data('cp'),
		telefono    = $td.data('telefono'),
		email       = $td.data('email'),
		celular     = $td.data('celular');

	if (tipoPersona === 1) {
		$formPoliza.find('div.fisica').removeClass('hide');
		$formPoliza.find('div.moral').addClass('hide');

		$('#nombre').rules('add', {
			required: true,
			messages: {
				required: 'INGRESE EL NOMBRE'
			}
		});

		$('#paterno').rules('add', {
			required: true,
			messages: {
				required: 'INGRESE EL APELLIDO PATERNO'
			}
		});

		$('#razonSocial').rules('remove');
		$('#razonSocial').parents('div.form-group').removeClass('has-error');
		$('#razonSocial').siblings('p.has-error').remove();
		
		$('#pFisica').attr('checked', true);
		$('#razonSocial').val('');
		$('#nombre').val(nombre);
		$('#paterno').val(paterno);
		$('#materno').val(materno);
	}

	if (tipoPersona === 2) {
		$formPoliza.find('div.fisica').addClass('hide');
		$formPoliza.find('div.moral').removeClass('hide');

		$('#nombre').rules('remove');
		$('#nombre').parents('div.form-group').removeClass('has-error');
		$('#nombre').siblings('p.has-error').remove();

		$('#paterno').rules('remove');
		$('#paterno').parents('div.form-group').removeClass('has-error');
		$('#paterno').siblings('p.has-error').remove();

		$('#razonSocial').rules('add', {
			required: true,
			messages: {
				required: 'INGRESE LA RAZÓN SOCIAL'
			}
		});

		$('#pMoral').attr('checked', true);

		$('#nombre').val('');
		$('#paterno').val('');
		$('#materno').val('');
		$('#razonSocial').val(razon);
	}

	$('#rfc').val(rfc);
	$('#calleAsociado').val(calle);
	$('#numExteriorAsociado').val(numExterior);
	$('#numInteriorAsociado').val(numInterior);
	$('#coloniaAsociado').val(colonia);
	$('#cpAsociado').val(cp);
	$('#telefonoAsociado').val(telefono);
	$('#celularAsociado').val(celular);
	$('#emailAsociado').val(email);

	$datoAsociadoBuscar.val('');
	$('#busquedaAsociado').addClass('hide');
	validarCamposAsociadoProtegido();
	$('#capturarDatosAsociado').removeClass('hide');
	$('#asociadoNuevo').val('1');
	$(".hasNiceScroll").getNiceScroll().resize();

	$('#modalResultadoAsociados').modal('hide');
});

// cargar combo de modelos o mostrar el especifique en caso que sea = 1
$('#marca').on('change', function() {
	var url     = $(this).data('url'),
		marcaId = Number($(this).val());

	if (marcaId === 1) {
		$('#otraMarca, #otroModelo').removeClass('hide');
		$('#modelo').addClass('hide');

		$('#otraMarca').rules('add', {
			required: true,
			messages: {
				required: 'ESPECIFIQUE'
			}
		});

		$('#otroModelo').rules('add', {
			required: true,
			messages: {
				required: 'ESPECIFIQUE'
			}
		});

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
			$('#otraMarca').rules('remove');
			$('#otraMarca').parents('div.form-group').removeClass('has-error');
			$('#otraMarca').siblings('p.has-error').remove();

			$('#otroModelo').rules('add');

		}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
			$('#loading').modal('hide');
			console.log(textStatus + ': ' + errorThrown);
		});
	}
});

// modalidad selección de otro
$('#modalidad').on('change', function() {
	if ($(this).val() === '-1') {
		$('#otraModalidad').rules('add', {
			required: true,
			messages: {
				required: 'ESPECIFIQUE'
			}
		});

		$('#especifiqueOtraModalidad').removeClass('hide').focus();
	} else {
		$('#especifiqueOtraModalidad').addClass('hide');
		$('#otraModalidad').rules('remove');
		$('#otraModalidad').parents('div.form-group').removeClass('has-error');
		$('#otraModalidad').siblings('p.has-error').remove();

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

		$('#nombre').rules('add', {
			required: true,
			messages: {
				required: 'INGRESE EL NOMBRE'
			}
		});

		$('#paterno').rules('add', {
			required: true,
			messages: {
				required: 'INGRESE EL APELLIDO PATERNO'
			}
		});

		$('#razonSocial').rules('remove');
		$('#razonSocial').parents('div.form-group').removeClass('has-error');
		$('#razonSocial').siblings('p.has-error').remove();
	}

	if ($(this).val() === '2') {
		$formPoliza.find('div.fisica').addClass('hide');
		$formPoliza.find('div.moral').removeClass('hide');

		$('#nombre').rules('remove');
		$('#nombre').parents('div.form-group').removeClass('has-error');
		$('#nombre').siblings('p.has-error').remove();
		
		$('#paterno').rules('remove');
		$('#paterno').parents('div.form-group').removeClass('has-error');
		$('#paterno').siblings('p.has-error').remove();

		$('#razonSocial').rules('add', {
			required: true,
			messages: {
				required: 'INGRESE LA RAZÓN SOCIAL'
			}
		});
	}
});

// change a modelo de carro
$('#modelo').on('change', function (event) {
	if ($(this).val() === '-1') {
		$('#otroModelo').removeClass('hide');
		$('#otroModelo').siblings('div.separator').removeClass('hide');
		$('#otroModelo').rules('add', {
			required: true,
			messages: {
				required: 'ESPECIFIQUE'
			}
		});
		$('#otroModelo').focus();
	} else {
		$('#otroModelo').addClass('hide');
		$('#otroModelo').rules('remove');
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
		validarCamposNuevaCobertura();
		$('.hasNiceScroll').getNiceScroll().resize();

		return false;

	} else {
		$('#registroCobertura').addClass('hide');
		$('div.vigencias').addClass('hide');
		$('#seleccionCobertura').removeClass('hide');
		$('#desgloseResponsabilidades').removeClass('hide');

		$('#nombreCobertura').rules('remove');
		$('#nombreCobertura').parents('div.form-group').removeClass('has-error');
		$('#nombreCobertura').siblings('p.has-error').remove();

		$('#vigencias').rules('remove');
		$('#vigencias').parents('div.form-group').removeClass('has-error');
		$('#vigencias').siblings('p.has-error').remove();

		$('#nuevoCosto').rules('remove');
		$('#nuevoCosto').parents('div.form-group').removeClass('has-error');
		$('#nuevoCosto').siblings('p.has-error').remove();
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
		++numeroConceptosCobertura;

		var html = '<tr>' +
			'<td>' + concepto + '<input type="hidden" class="concepto" name="concepto[]" value="' + $('#conceptoCobertura').val() + '"></td>'+
			'<td><input type="text" name="limResponsabilidad[]" id="limResponsabilidad_' + numeroConceptosCobertura + '" class="form-control"></td>'+
			'<td><input type="text" name="cuotaExtraordinaria[]" id="cuotaExtraordinaria_' + numeroConceptosCobertura + '" class="form-control"></td>'+
			'</tr>';

		$('#responsabilidadDesglose').append(html);

		$('#limResponsabilidad_' + numeroConceptosCobertura).rules('add', {
			required: true,
			messages: {
				required: 'CAMPO OBLIGATORIO'
			}
		});

		$('#cuotaExtraordinaria_' + numeroConceptosCobertura).rules('add', {
			required: true,
			messages: {
				required: 'CAMPO OBLIGATORIO'
			}
		});
	}
});

// agregar una responsabilidad a cobertura
$('#desgloseResponsabilidades').on('click', 'button.agregarConceptoCoberturaExistente', function () {

	if ($('#conceptoCoberturaExistente').val() === '') {
		bootbox.alert('POR FAVOR, SELECCIONE UN CONCEPTO.');
		return false;
	}

	if ($('#responsabilidad').val() === '-1') {
		if ($('#limiteResponsabilidadExistente').val() === '' || $('#cuotaExtraordinariaExistente').val() === '') {
			bootbox.alert('POR FAVOR, INGRESE EL LÍMITE DE RESPONSABILIDAD Y LA CUOTA EXTRAORDINARIA.');
			return false;
		}
	}

	var url         = $(this).data('url'),
		coberturaId = $(this).data('id');

	$.ajax({
		url:        url,
		type:       'post',
		dataType:   'json',
		data:       {
			coberturaId:           coberturaId,
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
		console.log(resultado.estatus);

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
		coberturaId       = $('#agregarConceptoCoberturaExistente').data('id'),
		responsabilidadId = $(this).data('responsabilidadId');

	bootbox.confirm('¿REALMENTE DESEA ELIMINAR ESTA RESPONSABILIDAD DE LA COBERTURA?', function (r) {
		if (r) {
			$.ajax({
				url:        url,
				type:       'post',
				dataType:   'json',
				data:       {
					coberturaId:       coberturaId,
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
$('#desgloseResponsabilidades').on('change', 'select.conceptoCoberturaExistente', function(event) {
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
$('#desgloseResponsabilidades').on('change', 'select.responsabilidad', function(event) {
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
		url:        url,
		type:       'post',
		dataType:   'json',
		data:       {
			coberturaId: $('#cobertura').val(),
			modalidadId: $('#modalidad').val(),
			_token:      $formPoliza.find('input[name="_token"]').val()
		},
		beforeSend: function () {
			$('#loading').modal('show');
		}

	}).done(function (resultado) {
		$('#loading').modal('hide');
		$('#vigenciaCobertura').html(resultado.html);
		$('#vigenciaCobertura').rules('add', {
			required: true,
			messages: {
				required: 'POR FAVOR, SELECCIONE'
			}
		});

		$('#desgloseResponsabilidades').removeClass('hide').html(resultado.htmlResponsabilidades);
		$(".hasNiceScroll").getNiceScroll().resize();

	}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
		$('#loading').modal('hide');
		console.log(textStatus + ': ' + errorThrown);
	});
}

// Función para validar los campos del formulario
function validarCampos() {
	$('#tipoPersona1').rules('add', {
		required: true,
		messages: {
			required: 'SELECCION EL TIPO DE PERSONA'
		}
	});

	$('#tipoPersona2').rules('add', {
		required: true,
		messages: {
			required: 'SELECCION EL TIPO DE PERSONA'
		}
	});

	// vehiculo
	validarCamposVehiculo();

	// coberturas
	validarCamposCoberturas();
}

// validar campos del vehículo
function validarCamposVehiculo() {
	// vehículo
	$('#modalidad').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});

	$('#marca').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});

	$('#modelo').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});

	$('#anio').rules('add', {
		required: true,
		digits:   true,
		messages: {
			required: 'AÑO OBLIGATORIO'
		}
	});

	$('#numSerie').rules('add', {
		required: true,
		messages: {
			required: 'NÚMERO DE SERIE OBLIGATORIO'
		}
	});

	$('#numMotor').rules('add', {
		required: true,
		messages: {
			required: 'NÚMERO DE MOTOR OBLIGATORIO'
		}
	});

	$('#placas').rules('add', {
		required: true,
		messages: {
			required: 'PLACAS OBLIGATORIO'
		}
	});

	$('#capacidad').rules('add', {
		required: true,
		digits:   true,
		messages: {
			required: 'CAPACIDAD OBLIGATORIA'
		}
	});
}

// validar campos del asociado protegido
function validarCamposAsociadoProtegido() {
	$('#rfc').rules('add', {
		required: true,
		messages: {
			required: 'INGRESE EL RFC'
		}
	});

	$('#calleAsociado').rules('add', {
		required: true,
		messages: {
			required: 'INGRESE LA CALLE'
		}
	});

	$('#numExteriorAsociado').rules('add', {
		required: true,
		messages: {
			required: 'INGRESE EL NÚMERO EXTERIOR'
		}
	});

	$('#coloniaAsociado').rules('add', {
		required: true,
		messages: {
			required: 'INGRESE LA COLONIA'
		}
	});

	$('#cpAsociado').rules('add', {
		required: true,
		messages: {
			required: 'INGRESE EL CÓDIGO POSTAL'
		}
	});

	$('#ciudadAsociado').rules('add', {
		required: true,
		messages: {
			required: 'INGRESE LA CIUDAD'
		}
	});

	$('#telefonoAsociado').rules('add', {
		digits: true
	});

	$('#celularAsociado').rules('add', {
		digits: true
	});

	$('#emailAsociado').rules('add', {
		email: true,
		messages: {
			email: 'INGRESE UN CORREO VÁLIDO'
		}
	});
}

// validar campos de la cobertura
function validarCamposCoberturas() {
	$('#servicio').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});

	$('#coberturaTipo').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});

	$('#cobertura').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});
}

function validarCamposNuevaCobertura() {
	$('#nombreCobertura').rules('add', {
		required: true,
		messages: {
			required: 'CAMPO OBLIGATORIO'
		}
	});

	$('#vigencias').rules('add', {
		required: true,
		messages: {
			required: 'POR FAVOR, SELECCIONE'
		}
	});
	
	$('#nuevoCosto').rules('add', {
		required: true,
		number:   true,
		messages: {
			required: 'CAMPO OBLIGATORIO',
			number:   'INGRESE SOLO NÚMEROS'
		}
	});
}