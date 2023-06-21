<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DatoPaciente;
use App\Servicio;
use App\Patologia;
class FormularioEnfermedadesNotificacionInmediataController extends Controller
{
    public function mostrarFormulario()
    {
        // Consulta los datos necesarios de los modelos relacionados
        $datosPacientes = DatoPaciente::all();
        $servicios = Servicio::all();
        $patologias = Patologia::all();


        // Pasa los datos a la vista del formulario
        return view('one.formulario2', compact('datosPacientes', 'servicios', 'patologias'));
    }

    public function guardarDatos(Request $request)
    {
    // Validar los datos del formulario
    $request->validate([
        'h_clinico' => 'required',
        'fecha' => 'required',
        'patologia' => 'required',
        'servicio_inicio_sintomas' => 'required',
        'notificador' => 'required',
        'acciones' => 'required',
        'observaciones' => 'required',
    ]);

    // Crear una nueva instancia del modelo FormularioEnfermedadesNotificacionInmediata
    $formulario = new FormularioEnfermedadesNotificacionInmediata();

    // Asignar los valores de los campos del formulario al modelo
    $formulario->h_clinico = $request->input('h_clinico');
    $formulario->fecha = $request->input('fecha');
    $formulario->patologia = $request->input('patologia');
    $formulario->servicio_inicio_sintomas = $request->input('servicio_inicio_sintomas');
    $formulario->notificador = $request->input('notificador');
    $formulario->acciones = $request->input('acciones');
    $formulario->observaciones = $request->input('observaciones');

    // Guardar el formulario en la base de datos
    $formulario->save();

    // Redireccionar a una página de éxito o mostrar un mensaje de confirmación
    return redirect()->route('formulario2')->with('success', 'Los datos han sido guardados exitosamente.');
    }

}
