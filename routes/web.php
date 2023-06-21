<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

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
Route::view('/', 'login')->name('login');
Route::post('/iniciar-sesion', [LoginController::class, 'login'])->name('iniciar-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::view('/principal', 'principal')->name('principal');
    Route::resource('agente', 'AgenteController');
    Route::resource('tipoInfeccion', 'TipoInfeccionController');
    Route::resource('bacteria', 'BacteriaController')->parameters([
        'bacteria' => 'bacteria'
    ]);
    //busqueda historial paciente
    Route::get('/historial', 'BusquedaHistorialController@showHistorial')->name('historial');

    Route::get('/buscar-paciente', 'BusquedaHistorialController@searchHistorial')->name('buscar-paciente');


    Route::resource('medicamento', 'MedicamentoController');
    //FORMULARIO IAAS
    Route::get('/formulario_IAAS', 'FormularioNotificacionPacienteController@mostrarFormulario')->name('formularioIAAS');
    Route::post('/guardar-datos-formulario_IAAS', 'FormularioNotificacionPacienteController@guardarDatos')->name('guardar_datos_form_IAAS');
    //FORMULARIO ENFERMEDADES DE NOTIFICACION INMEDIATA
    Route::get('/formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@mostrarFormulario')->name('formulario_Enf_Not_Inmediata');
    Route::post('/guardar-datos-formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@guardarDatos')->name('guardar_datos_form_Enf_Not_Inmediata');
});
