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
    Route::delete('/eliminar-IAAS-formulario/{codigoFormulario}', 'FormularioNotificacionPacienteController@eliminarFormulario')->name('eliminar.formulario');
    Route::put('/cambiarEstado/{codigoFormulario}', 'FormularioNotificacionPacienteController@estadoFormulario')->name('cambiar.estado');



    Route::post('/generar-reporte', 'FormularioNotificacionPacienteController@generarReporte')->name('generar.reporte');
    Route::post('/reporte-anual', 'FormularioNotificacionPacienteController@reporteAnual')->name('reporte.anual');
    Route::post('/informe-anual', 'FormularioNotificacionPacienteController@informeAnual')->name('informe.anual');
    Route::post('/reporte-anual-por-mes', 'FormularioNotificacionPacienteController@reporteAnualPorMes')->name('reporte.anual.por.mes.IAAS');
    Route::post('/reporte-por-rango-IAAS', 'FormularioNotificacionPacienteController@reporteRango')->name('reporte.por.rango.IAAS');


    //FORMULARIO ENFERMEDADES DE NOTIFICACION INMEDIATA
    Route::get('/historial_form_2', 'FormularioEnfermedadesNotificacionInmediataController@showViewForm')->name('view_form_2');
    Route::get('/buscar-paciente_form_2', 'FormularioEnfermedadesNotificacionInmediataController@searchHistorial')->name('buscar-paciente_form_2');
    Route::get('/buscar-formulario_2', 'FormularioEnfermedadesNotificacionInmediataController@buscarFormularioPorHClinico')->name('buscar-form_2');
    Route::get('/formulario/{id}', 'FormularioEnfermedadesNotificacionInmediataController@vistaPreviaPDF')->name('vista-previa-pdf');


    Route::get('/formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@mostrarFormulario')->name('formulario_Enf_Not_Inmediata');
    Route::post('/guardar-datos-formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@guardarDatos')->name('guardar_datos_form_Enf_Not_Inmediata');

    Route::post('/formulario/generar-reporte', 'FormularioEnfermedadesNotificacionInmediataController@generar')->name('formulario.generar');

    Route::get('/principal', 'FormularioEnfermedadesNotificacionInmediataController@mostrarGrafica')->name('principal');
    Route::get('/TablaEnfermadesNotificacionInmediata', 'FormularioEnfermedadesNotificacionInmediataController@tabla')->name('TablaE_N_I');
    // Route::get('/generar-pdf/{codigoFormulario}', 'FormularioEnfermedadesNotificacionInmediataController@generarPDF')->name('generar.pdf');
    Route::delete('/eliminar-formulario/{codigoFormulario}', 'FormularioEnfermedadesNotificacionInmediataController@eliminarFormulario')->name('eliminar.formulario.N-I');

    Route::post('/reporte-anual/Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@repAnual')->name('rep.anual.Enf.Not.Inmediata');
    Route::post('/reporte-anual/Por_Meses', 'FormularioEnfermedadesNotificacionInmediataController@reporteAnual')->name('reporte.anual.Enf.Not.Inmediata');
    Route::post('/reporte-por-rango-E_N_I', 'FormularioEnfermedadesNotificacionInmediataController@reporteRango')->name('reporte.por.rango.E_N_I');

    // web.php
// routes/web.php
Route::get('/visualizar-pdf', 'FormularioEnfermedadesNotificacionInmediataController@visualizarPDF')->name('formulario.visualizarPDF');


    //REPORTES
    Route::view('/Por_Gestion', 'Reportes.Por_Gestion')->name('Por.Gestion');
    Route::view('/Por_Mes', 'Reportes.Por_Mes')->name('Por.Mes');
    Route::view('/Por_Rango_Fecha', 'Reportes.Por_Rango_fecha')->name('Por.Rango_fecha');
    Route::view('/Por_Servicio', 'Reportes.Por_Servicio')->name('Por.Servicio');
//-----------------------------------------------------------------
});
