<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FormularioNotificacionPacienteController;
use App\Http\Controllers\FormularioEnfermedadesNotificacionInmediataController;
Route::view('/', 'login')->name('login');
Route::post('/iniciar-sesion', [LoginController::class, 'login'])->name('iniciar-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::view('/principal', 'principal')->name('principal');
//****************************CRUDS*******************************
    //CRUD AGENTES CAUSALES
    Route::resource('agente', 'AgenteController');
    Route::get('/agente/search', 'AgenteController@search')->name('agente.search');
    //CRUD TIPOS DE INFECCIONES
    Route::resource('tipoInfeccion', 'TipoInfeccionController');
    Route::get('/tipo/search', 'TipoInfeccionController@search')->name('tipo.search');
    //CRUD BACTERIAS
    Route::resource('bacteria', 'BacteriaController')->parameters([
        'bacteria' => 'bacteria'
    ]);
    Route::get('/bacteria/search', 'BacteriaController@search')->name('bacteria.search');

    //CRUD MEDICAMENTOS
    Route::resource('medicamento', 'MedicamentoController');
    Route::get('/medicamento/search', 'MedicamentoController@search')->name('medicamento.search');

//-----------------------------------------------------------------


//****************************FORMULARIOS*******************************

    //FORMULARIO IAAS
    Route::get('/historial_form_1', 'FormularioNotificacionPacienteController@showViewForm')->name('view_form_1');
    Route::get('/formulario_IAAS', 'FormularioNotificacionPacienteController@mostrarFormulario')->name('formularioIAAS');
    Route::get('/buscar-paciente_form_1', 'FormularioNotificacionPacienteController@searchHistorial')->name('buscar-paciente_form_1');
    Route::get('/buscar-formulario_1', 'FormularioNotificacionPacienteController@buscarFormularioPorHClinico')->name('buscar-form_1');
    Route::post('/guardar-datos-formulario_IAAS', 'FormularioNotificacionPacienteController@guardarDatos')->name('guardar_datos_form_IAAS');

    Route::post('obtener-medicamentos/{id}', [FormularioNotificacionPacienteController::class, 'obtenerMedicamentos']);

    Route::get('/TablaIAAS', 'FormularioNotificacionPacienteController@tabla')->name('TablaIAAS');
    Route::get('/generar-pdf/{codigoFormulario}', 'FormularioNotificacionPacienteController@generarPDF')->name('generar.pdf');
    Route::delete('/eliminar-formulario/{codigoFormulario}', 'FormularioNotificacionPacienteController@eliminarFormulario')->name('eliminar.formulario');
    Route::post('/generar-reporte', 'FormularioNotificacionPacienteController@generarReporte')->name('generar.reporte');


    //FORMULARIO ENFERMEDADES DE NOTIFICACION INMEDIATA
    Route::get('/historial_form_2', 'FormularioEnfermedadesNotificacionInmediataController@showViewForm')->name('view_form_2');
    Route::get('/buscar-paciente_form_2', 'FormularioEnfermedadesNotificacionInmediataController@searchHistorial')->name('buscar-paciente_form_2');
    Route::get('/buscar-formulario_2', 'FormularioEnfermedadesNotificacionInmediataController@buscarFormularioPorHClinico')->name('buscar-form_2');
    Route::get('/formulario/{id}', 'FormularioEnfermedadesNotificacionInmediataController@vistaPreviaPDF')->name('vista-previa-pdf');


    Route::get('/formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@mostrarFormulario')->name('formulario_Enf_Not_Inmediata');
    Route::post('/guardar-datos-formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@guardarDatos')->name('guardar_datos_form_Enf_Not_Inmediata');

    Route::post('/formulario/generar-reporte', 'FormularioEnfermedadesNotificacionInmediataController@generar')->name('formulario.generar');

    Route::get('/principal', 'FormularioEnfermedadesNotificacionInmediataController@mostrarGrafica')->name('principal');


    // web.php
// routes/web.php
Route::get('/visualizar-pdf', 'FormularioEnfermedadesNotificacionInmediataController@visualizarPDF')->name('formulario.visualizarPDF');


//-----------------------------------------------------------------
});
