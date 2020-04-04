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
    
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::get('/login', 'Auth\LoginController@showLoginForm');

//Route::group(['middleware' => ['auth']], function () {

Route::get('/logout' , function(){
        \Session::flush();
        return redirect()->to('/');
});
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main')->middleware('auth');

//    Route::group(['middleware' => 'Coordinador'], function () {
//
//        Route::get('/colegios','ColegioController@index');
//        Route::post('/colegios/registrar','ColegioController@store');
//        Route::put('/colegios/actualizar','ColegioController@update');
//        Route::get('/colegios/selectColegio','ColegioController@selectColegio');
//
//        //Recinto
//        Route::get('/recintos','RecintoController@index');
//        Route::post('/recintos/registrar','RecintoController@store');
//        Route::put('/recintos/actualizar','RecintoController@update');
//        Route::get('/recintos/selectRecinto','RecintoController@selectRecinto');
//
//        //colegios electorales
//        Route::get('/colegios-electorales','ColegioElectoralController@index');
//        Route::post('/colegios-electorales/registrar','ColegioElectoralController@store');
//        Route::put('/colegios-electorales/actualizar','ColegioElectoralController@update');
//        Route::get('/colegios-electorales/selectColegio','ColegioElectoralController@selectColegiosElectorales');
//
//        //Persona
//        Route::get('/usuarios', 'PersonaController@index');
//        Route::post('/usuarios/registrar', 'PersonaController@store');
//        Route::put('/usuarios/actualizar', 'PersonaController@update');
//        Route::put('/usuarios/agregarVoto','PersonaController@agregarVoto');
//        Route::put('/usuarios/quitarVoto','PersonaController@quitarVoto');
//
//        Route::get('/electores', 'ElectoreController@index');
//        Route::post('/electores/registrar', 'ElectoreController@store');
//        Route::put('/electores/actualizar', 'PersonaController@update');
//        Route::put('/electores/agregarVoto','ElectorrController@agregarVoto');
//        Route::put('/electores/quitarVoto','ElectorController@quitarVoto');
//
//    });

//    Route::group(['middleware' => 'Administrador'], function () {

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

        //Electores
        Route::get('/electores', 'ElectoreController@index');
        Route::post('/electores/registrar', 'ElectoreController@store');
//        Route::put('/usuarios/actualizar', 'PersonaController@update');
        Route::put('/electores/agregarVoto','ElectorrController@agregarVoto');
        Route::put('/electores/quitarVoto','ElectorController@quitarVoto');

        //Partidos
        Route::get('/partidos','PartidoController@index');
        Route::get('/partidos/selectPartido','PartidoController@selectPartido');
        Route::get('/partidos/totalPartidos', 'PartidoController@getTotalPartidos');
        Route::post('/partidos/registrar','PartidoController@store');
        Route::put('/partidos/actualizar','PartidoController@update');

        //Candidatos
        Route::get('/candidatos','CandidatoController@index');
        Route::get('/candidatos/selectCandidato','CandidatoController@selectCandidato');
        Route::get('/candidatos/selectCandidatura','CandidatoController@selectCandidatura');
        Route::post('/candidatos/registrar','CandidatoController@store');
        Route::put('/candidatos/actualizar','CandidatoController@update');

        //Votos
        Route::get('/votos','VotosController@index');
        Route::post('/votos/registrar','VotosController@store');
        Route::put('/votos/actualizar','VotosController@update');
        Route::get('/votos/totalVoto','VotosController@calcularVotosCandidato');
        Route::get('/votos/totalNulo','VotosController@calcularVotosNulo');
        Route::get('/votos/selectTotalVotos', 'VotosController@selectTotalVotos');
        //users
        Route::get('/users', 'UserController@index');
        Route::post('/users/registrar', 'UserController@store');
        Route::put('/users/actualizar', 'UserController@update');
        Route::put('/users/activar','UserController@activar');
        Route::put('/users/desactivar','UserController@desactivar');
        Route::get('/users/selectUsuario', 'UserController@selectUsuario');
        Route::get('/users/selectUsuarioFiltro', 'UserController@selectUsuarioFiltro');

//Roles
        Route::get('/roles', 'RolController@index');
        Route::get('/roles/selectRol', 'RolController@selectRol');
//    });


//});



//Simpatizantes
//Route::get('/simpatizantes', 'SimpatizanteController@index');
//Route::post('/simpatizantes/registrar', 'SimpatizanteController@store');
//Route::put('/simpatizantes/actualizar', 'SimpatizanteController@update');
//Route::put('/simpatizantes/agregarVoto','SimpatizanteController@agregarVoto');
//Route::put('/simpatizantes/quitarVoto','SimpatizanteController@quitarVoto');

//Route::get('/', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login')->name('login');
//Route::get('/home', 'HomeController@index')->name('home');
