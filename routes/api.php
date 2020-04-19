<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    Route::resource('/provincias', 'ProvinciasController');
    Route::resource('/circunscripciones', 'CircunscripcionesController');
    Route::resource('/municipios', 'MunicipiosController');
    Route::resource('/distritos', 'DistritosController');
    Route::resource('/recintos', 'RecintosController');
    Route::resource('/colegios_electorales', 'ColegiosElectoralesController');
    Route::resource('/people', 'PeopleController');
    Route::resource('/users', 'UsersController');
    Route::resource('/votantes', 'VotantesController');
    Route::resource('/roles', 'RolesController');
    Route::resource('/roles_users', 'RolesUsersController');
    Route::resource('/coordinadores_comites_bases', 'CoordinadnoresComitesBasesController');
    Route::resource('/miembros_comites_bases', 'MiembrosComitesBasesController');
});

Route::group(['prefix' => '/advanced'], function(){
    Route::get('/municipios/{name}', 'MunicipiosController@searchByProvincias');
    Route::get('/distritos/{name}', 'DistritosController@getByMunicipios');
    Route::get('/distritos/circunscripciones/{name}', 'DistritosController@getByCircunscripciones');
    Route::get('/recintos/distritos/{name}', 'RecintosController@getByDistritos');
    Route::get('/recintos/municipios/{name}', 'RecintosController@getByMunicipios');
    Route::get('/colegios_electorales/recintos/{name}', 'ColegiosElectoralesController@getByMunicipios');
    Route::get('/colegios_electorales/coordinadores/{name}', 'ColegiosElectoralesController@getByCoordinadores');

    Route::get('/votantes/circunscripciones/{name}', 'VotantesController@getByCircunscripciones');
    Route::get('/votantes/municipios/{name}', 'VotantesController@getByMunicipios');
    Route::get('/votantes/distritos/{name}', 'VotantesController@getByDistritos');
    Route::get('/votantes/recintos/{name}', 'VotantesController@getByRecintos');
    Route::get('/votantes/colegios_electorales/{name}', 'VotantesController@getByColegiosElectorales');
});