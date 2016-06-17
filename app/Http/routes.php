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

Route::get('/', function () {
    return view('principal');
});

Route::get('polizas', 'Polizas\PolizasController@index');
Route::get('polizas/registrar', 'Polizas\PolizasController@verFormRegistro');
Route::post('polizas/registrar', [
    'as' => 'poliza-registrar',
    'use' => 'Polizas\PolizasController@registrar',
]);

Route::get('login', function () {
    return view('login');
});
