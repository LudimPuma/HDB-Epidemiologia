<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\DatoPaciente;
use App\Servicio;
use App\Patologia;
use App\FormularioEnfermedadesNotificacionInmediata;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Dompdf\Options;
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
    // Crear una nueva instancia del modelo FormularioEnfermedadesNotificacionInmediata
    $formulario = new FormularioEnfermedadesNotificacionInmediata();

    // Asignar los valores de los campos del formulario al modelo
    $formulario->h_clinico = $request->input('h_clinico');
    $formulario->fecha = $request->input('fecha');
    $formulario->cod_pato = $request->input('patologia');
    $formulario->cod_servi = $request->input('servicio_inicio_sintomas');
    $formulario->notificador = $request->input('notificador');
    $formulario->acciones = $request->input('acciones');
    $formulario->observaciones = $request->input('observaciones');

    // Guardar el formulario en la base de datos
    $formulario->save();

    //$idFormulario = $formulario->id_f_notificacion_inmediata;
    // Redireccionar a una página de éxito o mostrar un mensaje de confirmación
    //return redirect()->route('vista-previa-pdf', $idFormulario);
    //return redirect()->route('view_form_2')->with('success', 'Los datos han sido guardados exitosamente.');

    // Obtener los datos relacionados del formulario
    $paciente = $formulario->datoPaciente;
    $patologia = $formulario->patologia;
    $servicio = $formulario->servicio;

    // Crear una instancia de Dompdf
    $dompdf = new Dompdf();

    // Obtener la fecha y hora actual en horario de Bolivia
    $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
    $fechaActual = Carbon::now('America/La_Paz')->format('d/m/Y ');

    // Cargar el contenido HTML de la vista previa
    $html = view('one.form_2_pdf', compact('formulario', 'paciente', 'patologia', 'servicio', 'fechaHoraActual', 'fechaActual'))->render();
    $dompdf->loadHtml($html);

    // Generar el PDF
    $dompdf->render();

    // Obtener el contenido del PDF generado
    $pdfContent = $dompdf->output();

    // Guardar el PDF en el servidor
    $pdfPath = public_path('Formulario_Enfermedades_Notificacion_Inmediata.pdf');
    file_put_contents($pdfPath, $pdfContent);

    // Descargar el PDF
    $response = response()->download($pdfPath, 'Formulario_Enfermedades_Notificacion_Inmediata.pdf')->deleteFileAfterSend();

    // Redirigir a otra vista después de descargar el PDF
    return redirect()->route('view_form_2')->with('success', 'Los datos han sido guardados exitosamente.')->withHeaders($response->headers->all());
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
        $fechaActual = Carbon::now('America/La_Paz')->format('d/m/Y ');

        // Cargar el contenido HTML de la vista previa
        $html = view('one.form_2_pdf', compact('formulario', 'paciente', 'patologia', 'servicio','fechaHoraActual','fechaActual'))->render();
        $dompdf->loadHtml($html);
        // Generar el PDF
        $dompdf->render();
        // Opcional: Guardar el PDF en el servidor
        $dompdf->stream('Formulario_Enfermedades_Notificaion_Inmediata.pdf');
        // Opcional: Descargar el PDF en el navegador
        return $dompdf->stream('Formulario_Enfermedades_Notificaion_Inmediata.pdf');
    }


    public function generarReporte(Request $request)
    {
        //dd('mensaje');
        // Obtén los datos del reporte
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        dd($fechaInicio, $fechaFin);
        $reporte = FormularioEnfermedadesNotificacionInmediata::whereBetween('fecha', [$fechaInicio, $fechaFin])->get();

        //dd($reporte);
        // Configuración de dompdf
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);

        // Renderizar la vista del PDF
        $pdf = view('one.reporte_form2_pdf', ['reporte' => $reporte])->render();

        // Cargar el contenido del PDF en dompdf
        $dompdf->loadHtml($pdf);

        // Renderizar el PDF
        $dompdf->render();

        // Descargar el PDF
        $dompdf->stream('reporte.pdf');
    }

    public function mostrarGrafica()
    {
        // Obtener el año actual
        $year = Carbon::now()->year;

        // Consultar la cantidad de casos registrados por patología en cada mes del año actual
        $datosGrafica = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata')
            ->join('epidemiologia.patologia', 'formulario_enfermedades_notificacion_inmediata.cod_pato', '=', 'patologia.cod_patologia')
            ->select(DB::raw('extract(month from fecha) as mes, patologia.nombre as patologia, count(*) as total_casos'))
            ->whereYear('fecha', $year)
            ->groupBy('mes', 'patologia')
            ->get();

        // Organizar los datos para la gráfica
        $labels = [
            "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
        ];
        $datasets = [];
        $colorPalette = ['#56243f', '#72a100', '#9dd3e3', '#127aaf', '#864882']; // Definir una paleta de colores

        foreach ($datosGrafica as $index => $dato) {
            $mes = (int) $dato->mes;
            $patologia = $dato->patologia;
            $totalCasos = $dato->total_casos;

            // Asignar un color específico a cada patología de acuerdo con la paleta de colores
            $colorIndex = $index % count($colorPalette);
            $color = $colorPalette[$colorIndex];

            if (!isset($datasets[$patologia])) {
                $datasets[$patologia] = [
                    'label' => $patologia,
                    'backgroundColor' => 'transparent',
                    'borderColor' => $color, // Asignar el color correspondiente
                    'pointStyle' => 'circle',
                    'pointBackgroundColor' => $color, // Asignar el color correspondiente
                    'data' => array_fill(0, 12, 0),
                ];
            }

            $datasets[$patologia]['data'][$mes - 1] = $totalCasos;
        }

        $datasets = array_values($datasets); // Convertir el array asociativo a un array indexado

        return view('principal', compact('labels', 'datasets'));
    }







    // public function visualizarPDF()
    // {
    //     // Obtener el formulario más reciente (suponiendo que estás usando Eloquent)
    //     $formulario = FormularioEnfermedadesNotificacionInmediata::latest()->first();

    //     if (!$formulario) {
    //         // El formulario no existe, puedes mostrar un mensaje de error o redirigir a otra página
    //         return redirect()->back()->with('error', 'No se encontró el formulario solicitado.');
    //     }

    //     // Obtener los datos relacionados del formulario
    //     $paciente = $formulario->datoPaciente;
    //     $patologia = $formulario->patologia;
    //     $servicio = $formulario->servicio;

    //     // Crear una instancia de Dompdf
    //     $dompdf = new Dompdf();

    //     // Obtener la fecha y hora actual en horario de Bolivia
    //     $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
    //     $fechaActual = Carbon::now('America/La_Paz')->format('d/m/Y');

    //     // Cargar el contenido HTML de la vista previa (asumiendo que tienes una vista llamada "vista_previa_pdf.blade.php")
    //     $html = view('vista_previa_pdf', compact('formulario', 'paciente', 'patologia', 'servicio', 'fechaHoraActual', 'fechaActual'))->render();
    //     $dompdf->loadHtml($html);

    //     // Opcional: Establecer opciones de configuración de Dompdf
    //     $dompdf->setPaper('A4', 'portrait');

    //     // Generar el PDF
    //     $dompdf->render();

    //     // Opcional: Guardar el PDF en el servidor (elimina esta línea si no deseas guardar el PDF)
    //     // $dompdf->save('ruta/del/servidor/Formulario_Enfermedades_Notificaion_Inmediata.pdf');

    //     // Opcional: Descargar el PDF en el navegador
    //     return $dompdf->stream('Formulario_Enfermedades_Notificaion_Inmediata.pdf');
    // }


}
