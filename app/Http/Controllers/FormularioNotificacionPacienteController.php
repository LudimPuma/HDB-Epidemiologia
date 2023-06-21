<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antibiograma;
use App\NivelAntibiograma;
use App\DatoPaciente;
use App\Servicio;
use App\TipoInfeccion;
use App\ProcedimientoInmasivo;
use App\Agente;
use App\TipoMuestra;

class FormularioNotificacionPacienteController extends Controller
{
    public function mostrarFormulario()
    {
        // Consulta los datos necesarios de los modelos relacionados
        $antibiogramas = Antibiograma::all();
        $datosPacientes = DatoPaciente::all();
        $servicios = Servicio::all();
        $tiposInfeccion = TipoInfeccion::all();
        $procedimientosInmasivos = ProcedimientoInmasivo::all();
        $agentes = Agente::all();
        $tiposMuestra = TipoMuestra::all();
        $antibiogramas = Antibiograma::with('bacteria')->get();
        $nivelesAntibiograma = NivelAntibiograma::with('medicamento')->get();

        // Pasa los datos a la vista del formulario
        return view('one.formulario1', compact('antibiogramas', 'datosPacientes', 'servicios', 'tiposInfeccion', 'procedimientosInmasivos', 'agentes', 'tiposMuestra', 'antibiogramas', 'nivelesAntibiograma'));
    }

    public function guardarDatos(Request $request)
    {
    // Validar los datos del formulario
    $request->validate([
        'h_clinico' => 'required',
        'fecha_llenado' => 'required',
        'fecha_ingreso' => 'required',
        'servicio_inicio_sintomas' => 'required',
        'servicio_notificador' => 'required',
        'diagnostico_ingreso' => 'required',
        'diagnostico_sala' => 'required',
        'tipo_infeccion' => 'required',
        'uso_antimicrobanos' => 'required',
        'agente_causal' => 'required',
        'tipo_muestra_cultivo' => 'required',
        'procedimiento_invasivo' => 'required',
        'medidas_tomar' => 'required',
        'aislamiento' => 'required',
        'seguimiento' => 'required',
        'observacion' => 'required',
    ]);

    // Crear una nueva instancia del modelo FormularioNotificacionPaciente
    $formulario = new FormularioNotificacionPaciente();

    // Asignar los valores de los campos del formulario al modelo
    $formulario->h_clinico = $request->input('h_clinico');
    $formulario->fecha_llenado = $request->input('fecha_llenado');
    $formulario->fecha_ingreso = $request->input('fecha_ingreso');
    $formulario->servicio_inicio_sintomas = $request->input('servicio_inicio_sintomas');
    $formulario->servicio_notificador = $request->input('servicio_notificador');
    $formulario->diagnostico_ingreso = $request->input('diagnostico_ingreso');
    $formulario->diagnostico_sala = $request->input('diagnostico_sala');
    $formulario->tipo_infeccion = $request->input('tipo_infeccion');
    $formulario->uso_antimicrobanos = $request->input('uso_antimicrobanos');
    $formulario->agente_causal = $request->input('agente_causal');
    $formulario->tipo_muestra_cultivo = $request->input('tipo_muestra_cultivo');
    $formulario->procedimiento_invasivo = $request->input('procedimiento_invasivo');
    $formulario->medidas_tomar = $request->input('medidas_tomar');
    $formulario->aislamiento = $request->input('aislamiento');
    $formulario->seguimiento = $request->input('seguimiento');
    $formulario->observacion = $request->input('observacion');

    // Guardar el formulario en la base de datos
    $formulario->save();


    // Obtener el código del formulario recién guardado
    $codigoFormulario = $formulario->COD_FORM_NOTIFICACION_P;

    // Guardar los datos de antibiograma
    $antibiograma = new Antibiograma;
    $antibiograma->COD_FORMULARIO = $codigoFormulario;
    // Asignar los demás campos de antibiograma

    // Guardar el antibiograma en la base de datos
    $antibiograma->save();

    // Obtener el ID del antibiograma recién guardado
    $idAntibiograma = $antibiograma->ID_ANTIBIOGRAMA;

    // Guardar los datos de niveles de antibiograma
    $nivelesAntibiograma = new NivelesAntibiograma;
    $nivelesAntibiograma->ID_ANTIBIO = $idAntibiograma;
    // Asignar los demás campos de niveles de antibiograma

    // Guardar los niveles de antibiograma en la base de datos
    $nivelesAntibiograma->save();

    // Redireccionar a una página de éxito o mostrar un mensaje de confirmación
    return redirect()->route('formulario2')->with('success', 'Los datos han sido guardados exitosamente.');
    }

}
