<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FormularioNotificacionPacienteController;

Route::view('/', 'login')->name('login');
Route::post('/iniciar-sesion', [LoginController::class, 'login'])->name('iniciar-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::view('/principal', 'principal')->name('principal');
//****************************CRUDS*******************************
    //CRUD AGENTES CAUSALES
    Route::resource('agente', 'AgenteController');
    //CRUD TIPOS DE INFECCIONES
    Route::resource('tipoInfeccion', 'TipoInfeccionController');
    //CRUD BACTERIAS
    Route::resource('bacteria', 'BacteriaController')->parameters([
        'bacteria' => 'bacteria'
    ]);
    //CRUD MEDICAMENTOS
    Route::resource('medicamento', 'MedicamentoController');

//-----------------------------------------------------------------


//****************************FORMULARIOS*******************************
    //busqueda historial paciente
    Route::get('/historial', 'BusquedaHistorialController@showHistorial')->name('historial');
    Route::get('/buscar-paciente', 'BusquedaHistorialController@searchHistorial')->name('buscar-paciente');

    //FORMULARIO IAAS
    Route::view('/opciones_formulario_IAAS', 'one.view_form_1')->name('vista_form_1');
    Route::get('/formulario_IAAS', 'FormularioNotificacionPacienteController@mostrarFormulario')->name('formularioIAAS');
    Route::post('/guardar-datos-formulario_IAAS', 'FormularioNotificacionPacienteController@guardarDatos')->name('guardar_datos_form_IAAS');

    Route::get('/obtener-medicamentos', [FormularioNotificacionPacienteController::class, 'obtenerMedicamentos']);


    //FORMULARIO ENFERMEDADES DE NOTIFICACION INMEDIATA
    Route::get('/historial_form_2', 'FormularioEnfermedadesNotificacionInmediataController@showViewForm')->name('view_form_2');
    Route::get('/buscar-paciente_form_2', 'FormularioEnfermedadesNotificacionInmediataController@searchHistorial')->name('buscar-paciente_form_2');
    Route::get('/buscar-formulario', 'FormularioEnfermedadesNotificacionInmediataController@buscarFormularioPorHClinico')->name('buscar-form_2');
    Route::get('/formulario/{id}', 'FormularioEnfermedadesNotificacionInmediataController@vistaPreviaPDF')->name('vista-previa-pdf');


    Route::get('/formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@mostrarFormulario')->name('formulario_Enf_Not_Inmediata')->middleware('web');
    Route::post('/guardar-datos-formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@guardarDatos')->name('guardar_datos_form_Enf_Not_Inmediata');

//-----------------------------------------------------------------
});
