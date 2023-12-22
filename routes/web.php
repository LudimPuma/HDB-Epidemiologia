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
    //CRUD TIPOS DE INFECCIONES
    Route::resource('tipoInfeccion', 'TipoInfeccionController');
    //CRUD BACTERIAS
    Route::resource('bacteria', 'BacteriaController')->parameters([
        'bacteria' => 'bacteria'
    ]);
    //CRUD MEDICAMENTOS
    Route::resource('medicamento', 'MedicamentoController');
    //CRUD SERVICIOS
    Route::resource('servicio', 'ServicioController');
    //CRUD PROCEDIMIENTO INVASIVO
    Route::resource('procedimiento', 'ProcedimientoController');
    //CRUD TIPO DE MUESTRA
    Route::resource('tipoMuestra', 'TipoMuestraController');

    Route::resource('hongo', 'HongoController');
    Route::resource('patologia', 'PatologiaController')->parameters([
        'patologia' => 'patologia'
    ]);

//-----------------------------------------------------------------

//USUARIOS ROLES
    Route::resource('usuarios', UserController::class)->middleware('can:admin');
    Route::resource('roles', RoleController::class)->middleware('can:admin');;
    Route::resource('permissions', PermisoController::class)->middleware('can:admin');;
//****************************FORMULARIOS*******************************

    //FORMULARIO IAAS
    Route::get('/historial_form_1', 'FormularioNotificacionPacienteController@showViewForm')->name('view_form_1');
    Route::get('/formulario_IAAS', 'FormularioNotificacionPacienteController@mostrarFormulario')->name('formularioIAAS');
    Route::get('/buscar-paciente_form_1', 'FormularioNotificacionPacienteController@searchHistorial')->name('buscar-paciente_form_1');

    Route::post('/guardar-datos-formulario_IAAS', 'FormularioNotificacionPacienteController@guardarDatos')->name('guardar_datos_form_IAAS');
    Route::put('/actualizar-estado-IAAS/{formulario}','FormularioNotificacionPacienteController@update')->name('actualizar-estado.IAAS');
    Route::post('obtener-medicamentos/{id}', [FormularioNotificacionPacienteController::class, 'obtenerMedicamentos']);
    // Route::get('/principal', 'FormularioNotificacionPacienteController@grafica')->name('principal');

    //TABLA IAAS
    Route::get('/TablaIAAS', 'FormularioNotificacionPacienteController@tabla')->name('TablaIAAS');
    Route::get('/generar-pdf/{codigoFormulario}', 'FormularioNotificacionPacienteController@generarPDF')->name('generar.pdf');

    //REPORTES IAAS
    Route::post('/generar-reporte', 'FormularioNotificacionPacienteController@generarReporte')->name('generar.reporte');
    Route::post('/reporte-anual', 'FormularioNotificacionPacienteController@reporteAnual')->name('reporte.anual');
    Route::post('/reporte-anual-por-mes', 'FormularioNotificacionPacienteController@reporteAnualPorMes')->name('reporte.anual.por.mes.IAAS');
    Route::post('/reporte-por-rango-IAAS', 'FormularioNotificacionPacienteController@reporteRango')->name('reporte.por.rango.IAAS');
    Route::post('/reporte-trimestral-servicios-IAAS', 'FormularioNotificacionPacienteController@reporteIAASTrimestralSemestralServicio')->name('reporte.trimestral.semestral.por.servicio.IAAS');


    //INFORMES IAAS
    Route::post('/informe-anual', 'FormularioNotificacionPacienteController@informeAnual')->name('informe.anual');
    Route::post('/informe-semestral-trimestral-IAAS', 'FormularioNotificacionPacienteController@informeTrimestralSemestralIAASEspecifico')->name('informe.semestral.trimestral.IAAS');


    //FORMULARIO ENFERMEDADES DE NOTIFICACION INMEDIATA
    Route::get('/historial_form_2', 'FormularioEnfermedadesNotificacionInmediataController@showViewForm')->name('view_form_2');
    Route::get('/buscar-paciente_form_2', 'FormularioEnfermedadesNotificacionInmediataController@searchHistorial')->name('buscar-paciente_form_2');
    Route::get('/formulario-ENI/{id}', 'FormularioEnfermedadesNotificacionInmediataController@vistaPreviaPDF')->name('vista-previa-pdf');


    Route::get('/formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@mostrarFormulario')->name('formulario_Enf_Not_Inmediata');
    Route::post('/guardar-datos-formulario_Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@guardarDatos')->name('guardar_datos_form_Enf_Not_Inmediata');
    Route::put('/actualizar-estado-ENI/{formulario}','FormularioEnfermedadesNotificacionInmediataController@update')->name('actualizar-estado.ENI');
    Route::post('/formulario/generar-reporte', 'FormularioEnfermedadesNotificacionInmediataController@generar')->name('formulario.generar');

    Route::get('/principal', 'FormularioEnfermedadesNotificacionInmediataController@mostrarGrafica')->name('principal');
    Route::get('/TablaEnfermadesNotificacionInmediata', 'FormularioEnfermedadesNotificacionInmediataController@tabla')->name('TablaE_N_I');

    Route::post('/reporte-anual/Enf_Not_Inmediata', 'FormularioEnfermedadesNotificacionInmediataController@repAnual')->name('rep.anual.Enf.Not.Inmediata');
    Route::post('/reporte-anual/Por_Meses', 'FormularioEnfermedadesNotificacionInmediataController@reporteAnual')->name('reporte.anual.Enf.Not.Inmediata');
    Route::post('/reporte-por-rango-E_N_I', 'FormularioEnfermedadesNotificacionInmediataController@reporteRango')->name('reporte.por.rango.E_N_I');
    Route::post('/reporte-trimestral-semestral-por-servicio-E_N_I', 'FormularioEnfermedadesNotificacionInmediataController@reporteENITrimestralSemestralServicio')->name('reporte.trimestre.semestre.por.servicio.E_N_I');


    Route::post('/informe-anual-Tuberculosis-E_N_I', 'FormularioEnfermedadesNotificacionInmediataController@informeTuberculosis')->name('informe.Tuberculosis.E_N_I');
    Route::post('/informe-semestral-trimestral-Tuberculosis-E_N_I', 'FormularioEnfermedadesNotificacionInmediataController@informeTrimestralSemestralTuberculosis')->name('informe.trimestre.semestre.Tuberculosis.E_N_I');



    //REPORTES
    Route::view('/Por_Gestion', 'Reportes.Por_Gestion')->name('Por.Gestion')->middleware('can:button-reports');
    Route::view('/Por_Mes', 'Reportes.Por_Mes')->name('Por.Mes')->middleware('can:button-reports');
    Route::view('/Por_Rango_Fecha', 'Reportes.Por_Rango_fecha')->name('Por.Rango_fecha')->middleware('can:button-reports');
    Route::view('/Por_Servicio', 'Reportes.Por_Servicio')->name('Por.Servicio')->middleware('can:button-reports');
    Route::view('/Trimestral_Por_Servicio', 'Reportes.Trimestral_Por_Servicio')->name('Trimestral.Por.Servicio')->middleware('can:button-reports');
    Route::view('/Semestral_Por_Servicio', 'Reportes.Semestral_Por_Servicio')->name('Semestral.Por.Servicio')->middleware('can:button-reports');
    //INFORMES

    Route::view('/Informe-Semestral', 'Informes.Informe_Semestral')->name('Inf.Informe_Semestral')->middleware('can:button-informes');
    Route::view('/Informe-Trimestral', 'Informes.Informe_Trimestral')->name('Inf.Informe_Trimestral')->middleware('can:button-informes');
    Route::view('/Informe-Gestion', 'Informes.Informe_Gestion')->name('Inf.Informe_Gestion')->middleware('can:button-informes');
    //-----------------------------------------------------------------
    Route::get('/generar-backup', 'BackupController@generarBackup')->name('generar.backup');
});
