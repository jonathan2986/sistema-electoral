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
});
