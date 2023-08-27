<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\DatoPaciente;
use App\Servicio;
use App\Patologia;
use App\SeleccionPatologia;
use App\FormularioEnfermedadesNotificacionInmediata;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Dompdf\Options;
use PDF;

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
        $fechaActual = Carbon::now('America/La_Paz')->format('Y-m-d');
        // Pasa los datos a la vista del formulario
        return view('one.formulario2', compact('id','nombre', 'idFormulario', 'servicios', 'patologias','fechaActual'));
    }

    public function guardarDatos(Request $request)
    {

        // Validar los datos del formulario (puedes agregar reglas de validación según tus necesidades)
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
        //$formulario->cod_pato = $request->input('patologia');
        $formulario->cod_servi = $request->input('servicio_inicio_sintomas');
        $formulario->notificador = $request->input('notificador');
        $formulario->acciones = $request->input('acciones');
        $formulario->observaciones = $request->input('observaciones');

        // Guardar el formulario en la base de datos
        $formulario->save();

        // Obtener el ID del formulario que se generó automáticamente
        $idFormulario = $formulario->id_f_notificacion_inmediata;

        //TABLA SELECCION PATOLOGIA
        $patologiasSeleccionadas = $request->input('patologias_seleccionadas');


        // Decodificar el JSON y procesar las patologias seleccionadas
        $patologiasSeleccionadas = json_decode($patologiasSeleccionadas);

        // Crear una instancia de seleccionPatologia para cada patologia seleccionada
        foreach ($patologiasSeleccionadas as $codTipoPat) {
            $seleccionPatologia = new SeleccionPatologia();
            $seleccionPatologia->cod_form_n_i = $idFormulario;
            $seleccionPatologia->h_cli = $request->input('h_clinico');
            $seleccionPatologia->cod_pato = $codTipoPat;
            $seleccionPatologia->save();
        }
        return redirect()->route('principal')->with('success', 'Los datos han sido guardados exitosamente.');
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
        // $patologia = $formulario->patologia;
        $servicio = $formulario->servicio;
        $patologias = SeleccionPatologia::select('p.nombre')
            ->join('epidemiologia.patologia as p', 'p.cod_patologia', '=', 'seleccion_patologia.cod_pato')
            ->where('seleccion_patologia.cod_form_n_i', $id)
            ->get();
        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        // Obtener la fecha y hora actual en horario de Bolivia
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
        $fechaActual = Carbon::now('America/La_Paz')->format('d/m/Y ');

        // Cargar el contenido HTML de la vista previa
        $html = view('one.form_2_pdf', compact('formulario', 'paciente', 'servicio', 'patologias', 'fechaHoraActual', 'fechaActual'))->render();
        $dompdf->loadHtml($html);
        // Generar el PDF
        $dompdf->render();
        //Descargar el PDF en el navegador
        return $dompdf->stream('Formulario_Enfermedades_Notificaion_Inmediata.pdf');
    }

    public function generar(Request $request)
    {
        //$reporte=FormularioEnfermedadesNotificacionInmediata::whereMonth('fecha',date('m', strtotime($request->fecha)))->whereYear('fecha',date('Y', strtotime($request->fecha)))->get();
        // $data= compact('reporte');
        // $pdf = PDF::loadview('one.reporte_form2_pdf', $data);
        // return $pdf->stream();
    // Obtener el mes y año seleccionados del formulario
    // Obtener el mes y año seleccionados del formulario
        $fechaSeleccionada = $request->fecha;
        $mesSeleccionado = Carbon::parse($fechaSeleccionada)->month;
        $nombreMesSeleccionado = Carbon::parse($fechaSeleccionada)->locale('es')->monthName;
        $anioSeleccionado = Carbon::parse($fechaSeleccionada)->year;
        // Obtener todas las patologías disponibles
        $todasLasPatologias = Patologia::select('nombre')->get();

        // Consulta para obtener el conteo por patología
        $conteoPorPatologia = SeleccionPatologia::select(
            'p.nombre as patologia',
            DB::raw('COUNT(*) as total_casos')
        )
        ->rightJoin('epidemiologia.patologia as p', 'p.cod_patologia', '=', 'seleccion_patologia.cod_pato')
        ->rightJoin('epidemiologia.formulario_enfermedades_notificacion_inmediata as f', 'f.id_f_notificacion_inmediata', '=', 'seleccion_patologia.cod_form_n_i')
        ->whereMonth('f.fecha', $mesSeleccionado)
        ->whereYear('f.fecha', $anioSeleccionado)
        ->groupBy('p.nombre')
        ->get();
        // Combinar el conteo con todas las patologías para mostrar las que tienen 0 casos
        $conteoCombinado = collect([]);
        foreach ($todasLasPatologias as $patologia) {
            $conteo = $conteoPorPatologia->firstWhere('patologia', $patologia->nombre);
            if ($conteo) {
                $conteoCombinado->push($conteo);
            } else {
                $conteoCombinado->push([
                    'patologia' => $patologia->nombre,
                    'total_casos' => 0,
                ]);
            }
        }

        $data = compact('conteoCombinado', 'nombreMesSeleccionado', 'anioSeleccionado');
        $pdf = PDF::loadview('one.reporte_form2_pdf', $data);
        return $pdf->stream();
//////////////////////////////////////////////////////////////////////////////////////////////
        // Obtener el mes y año seleccionados del formulario
        // $fechaSeleccionada = $request->fecha;
        // $mesSeleccionado = date('m', strtotime($fechaSeleccionada));
        // $anioSeleccionado = date('Y', strtotime($fechaSeleccionada));

        // // Consulta para obtener el conteo por patología
        // $conteoPorPatologia = FormularioEnfermedadesNotificacionInmediata::select(
        //     'p.nombre as patologia',
        //     DB::raw('COUNT(*) as total_casos')
        // )
        // ->join('epidemiologia.patologia as p', 'p.cod_patologia', '=', 'formulario_enfermedades_notificacion_inmediata.cod_pato')
        // // Corregir el nombre de la tabla en la cláusula FROM
        // ->whereMonth('fecha', $mesSeleccionado)
        // ->whereYear('fecha', $anioSeleccionado)
        // ->groupBy('p.nombre')
        // ->get();

        // $data = compact('conteoPorPatologia', 'fechaSeleccionada');
        // $pdf = PDF::loadview('one.reporte_form2_pdf', $data);
        // return $pdf->stream();.

///////////////////////////////////////////////////////////////////////////////////////////////////
    }


    public function mostrarGrafica()
    {
        // Obtener el año actual
        $year = Carbon::now()->year;

        // La cantidad de casos registrados por patología en cada mes del año actual
        $datosGrafica = DB::table('epidemiologia.seleccion_patologia')
            ->join('epidemiologia.patologia', 'seleccion_patologia.cod_pato', '=', 'patologia.cod_patologia')
            ->join('epidemiologia.formulario_enfermedades_notificacion_inmediata', 'seleccion_patologia.cod_form_n_i', '=', 'formulario_enfermedades_notificacion_inmediata.id_f_notificacion_inmediata')
            ->select(DB::raw('extract(month from formulario_enfermedades_notificacion_inmediata.fecha) as mes, patologia.nombre as patologia, count(*) as total_casos'))
            ->whereYear('formulario_enfermedades_notificacion_inmediata.fecha', $year)
            ->groupBy('mes', 'patologia')
            ->get();

        // Organizar los datos para la gráfica
        $labels = [
            "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"
        ];
        $datasets = [];
        $colorPalette = [
            'Meningitis' => '#1f77b4', // Azul
            'Viruela Simica' => '#ff7f0e', // Naranja
            'Leptospirosis' => '#2ca02c', // Verde
            'Tosferna' => '#d62728', // Rojo
            'Virus rábico' => '#9467bd', // Púrpura
            'Sarampión - Rubeola' => '#8c564b', // Marrón
            'Dipteria' => '#e377c2', // Rosa
            'VIH' => '#17becf', // Turquesa
        ];

        foreach ($datosGrafica as $index => $dato) {
            $mes = (int) $dato->mes;
            $patologia = $dato->patologia;
            $totalCasos = $dato->total_casos;

            // Si la patología no tiene un color asignado, se le asignará un color gris
            $color = isset($colorPalette[$patologia]) ? $colorPalette[$patologia] : '#7f7f7f';

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

        $datasets = array_values($datasets); // Convierte el array asociativo a un array indexado

        return view('principal', compact('labels', 'datasets'));
    }


}
