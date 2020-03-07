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
Route::group(['middleware' => ['guest']], function () {
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});
Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => 'Coordinador'], function () {

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
        Route::get('/colegios-electorales/selectColegio','ColegioElectoralController@selectColegiosElectorales');

        //Persona
        Route::get('/usuarios', 'PersonaController@index');
        Route::post('/usuarios/registrar', 'PersonaController@store');
        Route::put('/usuarios/actualizar', 'PersonaController@update');
        Route::put('/usuarios/agregarVoto','PersonaController@agregarVoto');
        Route::put('/usuarios/quitarVoto','PersonaController@quitarVoto');

    });

    Route::group(['middleware' => 'Administrador'], function () {

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
        Route::get('/colegios-electorales/selectColegio','ColegioElectoralController@selectColegiosElectorales');

        //Persona
        Route::get('/usuarios', 'PersonaController@index');
        Route::post('/usuarios/registrar', 'PersonaController@store');
        Route::put('/usuarios/actualizar', 'PersonaController@update');
        Route::put('/usuarios/agregarVoto','PersonaController@agregarVoto');
        Route::put('/usuarios/quitarVoto','PersonaController@quitarVoto');

        //Partidos
        Route::get('/partidos','PartidoController@index');
        Route::get('/partidos/selectPartido','PartidoController@selectPartido');
        Route::post('/partidos/registrar','PartidoController@store');
        Route::put('/partidos/actualizar','PartidoController@update');

        //Candidatos
        Route::get('/candidatos','CandidatoController@index');
//        Route::get('/candidatos/selectPartido','CandidatoController@selectPartido');
        Route::post('/candidatos/registrar','CandidatoController@store');
        Route::put('/candidatos/actualizar','CandidatoController@update');

        //users
        Route::get('/users', 'UserController@index');
        Route::post('/users/registrar', 'UserController@store');
        Route::put('/users/actualizar', 'UserController@update');
        Route::put('/users/activar','UserController@activar');
        Route::put('/users/desactivar','UserController@desactivar');

//Roles
        Route::get('/roles', 'RolController@index');
        Route::get('/roles/selectRol', 'RolController@selectRol');
    });


});



//Simpatizantes
//Route::get('/simpatizantes', 'SimpatizanteController@index');
//Route::post('/simpatizantes/registrar', 'SimpatizanteController@store');
//Route::put('/simpatizantes/actualizar', 'SimpatizanteController@update');
//Route::put('/simpatizantes/agregarVoto','SimpatizanteController@agregarVoto');
//Route::put('/simpatizantes/quitarVoto','SimpatizanteController@quitarVoto');

//Route::get('/', 'Auth\LoginController@showLoginForm');
//Route::post('/login', 'Auth\LoginController@login')->name('login');
//Route::get('/home', 'HomeController@index')->name('home');
