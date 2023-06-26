<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\DatoPaciente;
use App\Servicio;
use App\Patologia;
use App\FormularioEnfermedadesNotificacionInmediata;
use Dompdf\Dompdf;
use Carbon\Carbon;
class FormularioEnfermedadesNotificacionInmediataController extends Controller
{
    public function showViewForm()
    {
        return view('one.view_form_2');
    }
    public function searchHistorial(Request $request)
    {
        $patientId = $request->input('patientId');

        // Buscar al paciente en la base de datos por su ID
        $patient = DatoPaciente::where('n_h_clinico', $patientId)->first();

        if ($patient) {
            // El paciente fue encontrado, devolver los datos del paciente
            return response()->json([
                'found' => true,
                'patientData' => $patient
            ]);
        } else {
            // El paciente no fue encontrado
            return response()->json([
                'found' => false,
                'patientData' => null
            ]);
        }
    }



    public function mostrarFormulario(Request $request)
    {
        $id = $request->query('patientId');
        $nombre = $request->query('nombreCompleto');
        // Consulta los datos necesarios de los modelos relacionados
        $datosPacientes = DatoPaciente::all();
        $servicios = Servicio::all();
        $patologias = Patologia::all();


        // Pasa los datos a la vista del formulario
        return view('one.formulario2', compact('id','nombre', 'servicios', 'patologias'));
    }

    public function guardarDatos(Request $request)
    {

    // Validar los datos del formulario
    $request->validate([
        'n_historial' => 'required',
        //'fecha' => 'required',
        'patologia' => 'required',
        'servicio_inicio_sintomas' => 'required',
        'notificador' => 'required',
        'acciones' => 'required',
        'observaciones' => 'required',
    ]);

    // Crear una nueva instancia del modelo FormularioEnfermedadesNotificacionInmediata
    $formulario = new FormularioEnfermedadesNotificacionInmediata();

    // Asignar los valores de los campos del formulario al modelo
    $formulario->n_historial = $request->input('n_historial');
    //$formulario->fecha = $request->input('fecha');
    $formulario->patologia = $request->input('patologia');
    $formulario->servicio_inicio_sintomas = $request->input('servicio_inicio_sintomas');
    $formulario->notificador = $request->input('notificador');
    $formulario->acciones = $request->input('acciones');
    $formulario->observaciones = $request->input('observaciones');
    dd($request->all());
    // Guardar el formulario en la base de datos
    $formulario->save();

    // Redireccionar a una página de éxito o mostrar un mensaje de confirmación
    return redirect()->route('formulario_Enf_Not_Inmediata')->with('success', 'Los datos han sido guardados exitosamente.');
    }



    public function buscarFormularioPorHClinico(Request $request)
    {
        $hClinico = $request->input('hClinico');

        // Buscar el formulario por h_clinico
        $formulario = FormularioEnfermedadesNotificacionInmediata::where('h_clinico', $hClinico)->first();

        if (!$formulario) {
            // El formulario no existe, puedes mostrar un mensaje de error o redirigir a otra página
            return redirect()->back()->with('error', 'No se encontró ningún formulario para el historial clínico ingresado.');
        }

        // Redirigir a la vista previa del PDF con el ID del formulario
        return redirect()->route('vista-previa-pdf', $formulario->id_f_notificacion_inmediata);
    }



    public function vistaPreviaPDF($id)
    {
        // Obtener el formulario por ID
        $formulario = FormularioEnfermedadesNotificacionInmediata::find($id);

        if (!$formulario) {
            // El formulario no existe, puedes mostrar un mensaje de error o redirigir a otra página
            return redirect()->back()->with('error', 'No se encontró el formulario solicitado.');
        }

        // Obtener los datos relacionados del formulario
        $paciente = $formulario->datoPaciente;
        $patologia = $formulario->patologia;
        $servicio = $formulario->servicio;

        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();

        // Obtener la fecha y hora actual en horario de Bolivia
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');

        // Cargar el contenido HTML de la vista previa
        $html = view('one.form_2_pdf', compact('formulario', 'paciente', 'patologia', 'servicio','fechaHoraActual'))->render();
        $dompdf->loadHtml($html);



        // Opcional: Configurar opciones de Dompdf

        // Generar el PDF
        $dompdf->render();

        // Opcional: Guardar el PDF en el servidor
        $dompdf->stream('Formulario_Enfermedades_Notificaion_Inmediata.pdf');

        // Opcional: Descargar el PDF en el navegador
        return $dompdf->stream('Formulario_Enfermedades_Notificaion_Inmediata.pdf');
    }

}
