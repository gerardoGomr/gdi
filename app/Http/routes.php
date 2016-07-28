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

Route::group(['middleware' => 'usuarioAutenticado'], function() {
    /**
     * ruta principal del sistema
     */
    Route::get('/', function () {
        return view('principal');
    });

    /**
     * ruta para ver las pólizas registradas
     */
    Route::get('polizas', 'Polizas\PolizasController@index');

    /**
     * ruta para ver la vista de registro de nueva póliza
     */
    Route::get('polizas/registrar', 'Polizas\PolizasController@verFormRegistro');

    /**
     * ruta para buscar vehiculos en la captura de pólizas
     */
    Route::post('polizas/vehiculos/buscar', 'Polizas\PolizasController@buscarVehiculos');

    /**
     * ruta para buscar asociados en la captura de pólizas
     */
    Route::post('polizas/asociados/buscar', 'Polizas\PolizasController@buscarAsociados');

    /**
     * ruta para buscar modelos de vehiculos dependiendo la marca
     */
    Route::post('polizas/modelos/buscar', 'Polizas\PolizasController@buscarModelos');

    /**
     * ruta para registrar una nueva póliza
     */
    Route::post('polizas/registrar', [
        'as' => 'poliza-registrar',
        'use' => 'Polizas\PolizasController@registrar',
    ]);
});

/**
 * ruta para mostrar la vista de login
 */
Route::get('login', function () {
    return view('login');
});

/**
 * ruta para loguear al usuario
 */
Route::post('login', 'LoginController@login');

/**
 * ruta para cerrar sesión del usuario
 */
Route::get('logout', 'LoginController@logout');