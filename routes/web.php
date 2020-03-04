<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido/contenido');
});

Route::get('/colegios','ColegioController@index');
Route::post('/colegios/registrar','ColegioController@store');
Route::put('/colegios/actualizar','ColegioController@update');
Route::get('/colegios/selectColegio','ColegioController@selectColegio');

//Recinto
Route::get('/recintos','RecintoController@index');
Route::post('/recintos/registrar','RecintoController@store');
Route::put('/recintos/actualizar','RecintoController@update');
Route::get('/recintos/selectRecinto','RecintoController@selectRecinto');

//colegios electorales
Route::get('/colegios-electorales','ColegioElectoralController@index');
Route::post('/colegios-electorales/registrar','ColegioElectoralController@store');
Route::put('/colegios-electorales/actualizar','ColegioElectoralController@update');

//Persona
Route::get('/usuarios', 'PersonaController@index');
Route::post('/usuarios/registrar', 'PersonaController@store');
Route::put('/usuarios/actualizar', 'PersonaController@update');