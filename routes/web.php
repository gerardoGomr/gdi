<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * rutas agrupadas en el middleware de autenticación
 * @author Gerardo Adrián Gómez Ruiz, <gerardo.gomr@gmail.com>
 * @version 1.0
 */

Route::group(['middleware' => ['usuarioAutenticado']], function () {
    // ruta principal del sistema
    Route::get('/', 'Polizas\PolizasController@index');

    // ruta para ver polizas registradas
    Route::get('polizas', 'Polizas\PolizasController@index');

    // ruta para buscar pólizas
    Route::post('polizas/buscar', 'Polizas\PolizasController@buscarPolizas');

    // ruta para buscar pólizas en la captura
    Route::post('polizas/buscar-existente', 'Polizas\PolizasController@buscarPolizaExistente');

    // ruta para ver la vista de registro de nueva póliza/
    Route::get('polizas/registrar', 'Polizas\PolizasController@verFormRegistro');

    // ruta para ver la vista de edición de póliza
    Route::get('polizas/editar/{polizaId?}', 'Polizas\PolizasController@verFormEdicion');

    // ruta para buscar vehiculos en la captura de pólizas
    Route::post('polizas/vehiculos/buscar', 'Polizas\PolizasController@buscarVehiculos');

    // ruta para buscar asociados en la captura de pólizas
    Route::post('polizas/asociados/buscar', 'Polizas\PolizasController@buscarAsociados');

    // ruta para buscar modelos de vehiculos dependiendo la marca
    Route::post('polizas/modelos/buscar', 'Polizas\PolizasController@buscarModelos');

    // ruta para buscar coberturas en base al servicio y tipo
    Route::post('polizas/coberturas/buscar', 'Polizas\PolizasController@buscarCoberturas');

    // ruta para buscar vigencias de coberturas en base a la cobertura y la modalidad
    Route::post('polizas/coberturas/vigencias/buscar', 'Polizas\PolizasController@buscarVigenciasCobertura');

    // ruta para registrar una nueva póliza
    Route::post('polizas/registrar', [
        'as'   => 'poliza-registrar',
        'uses' => 'Polizas\PolizasController@registrar',
    ]);

    // ruta para construir vista de pago de pólizas
    Route::get('polizas/pagar/{polizaId?}', 'Polizas\PolizasController@verFormPago');

    // ruta para procesar pago de póliza
    Route::post('polizas/pagar', 'Polizas\PolizasController@pagarPoliza');

    // ruta para 2o pago parcial
    Route::post('polizas/pagar/parcial', 'Polizas\PolizasController@pagarPolizaParcial');

    // ruta para 2o pago parcial
    Route::post('polizas/pagar/diferencia', 'Polizas\PolizasController@pagarPo|lizaDiferencia');

    // ruta para generar el formato de la póliza
    Route::get('polizas/formato/{polizaId?}', 'Polizas\PolizasController@formato');

    // ruta para generar el formato parcial de la póliza
    Route::get('polizas/formato-parcial/{polizaId?}', 'Polizas\PolizasController@formatoParcial');

    // ruta para generar el recibo de conformidad
    Route::get('polizas/conformidad/{polizaId?}', 'Polizas\PolizasController@formatoConformidad');

    // ruta para buscar responsabilidades
    Route::post('polizas/responsabilidad/buscar', 'Polizas\PolizasController@bucarResponsabilidades');

    // ruta para agregar una responsabilidad a la cobertura
    Route::post('cobertura/responsabilidad/agregar', 'Coberturas\CoberturasController@agregarResponsabilidad');

    //ruta para eliminar una responsabilidad de la cobertura
    Route::post('cobertura/responsabilidad/eliminar', 'Coberturas\CoberturasController@eliminarResponsabilidad');
});

// ruta para mostrar la vista de login
Route::get('login', function () {
    return view('login');
});

// ruta para loguear al usuario
Route::post('login', 'LoginController@login');

//ruta para cerrar sesión del usuario
Route::get('logout', 'LoginController@logout');