<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        return view('Form_E_N_I.view_form_2');
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
        return view('Form_E_N_I.Form_Enf_Not_Inm', compact('id','nombre', 'idFormulario', 'servicios', 'patologias','fechaActual'));
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
        $formulario->h_clinico = $request->input('h_clinico');
        $formulario->fecha = $request->input('fecha');
        $formulario->cod_servi = $request->input('servicio_inicio_sintomas');
        $formulario->notificador = $request->input('notificador');
        $formulario->acciones = $request->input('acciones');
        $formulario->observaciones = $request->input('observaciones');
        $formulario->estado = 'alta';
        $formulario->pk_usuario = Auth::id();

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

        // Obtener la fecha y hora actual en horario de Bolivia
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
        $fechaActual = Carbon::now('America/La_Paz')->format('d/m/Y ');


        $data = [
            'formulario' => $formulario,
            'paciente' => $paciente,
            'servicio' => $servicio,
            'patologias' => $patologias,
            'fechaHoraActual' => $fechaHoraActual,
            'fechaActual' => $fechaActual,
        ];
        // Generar el contenido del PDF a partir de la vista del formulario
        $pdf = PDF::loadView('Form_E_N_I.PDF.form_2_pdf', $data);
        return $pdf->stream();
    }

    // prueba
    public function generar(Request $request)
    {
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
        ->where('f.estado', 'alta')
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

        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');

        $imagePath = public_path('assets/images/profile/profile.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $encabezado =public_path('img/encabezado.png');
        $encabezadoData = base64_encode(file_get_contents($encabezado));
        $encabezadoSrc = 'data:image/png;base64,' . $encabezadoData;

        $paginacion = public_path('img/paginacion.png');
        $paginacionData = base64_encode(file_get_contents($paginacion));
        $paginacionSrc = 'data:image/png;base64,' . $paginacionData;

        $data = compact('fechaHoraActual','conteoCombinado', 'nombreMesSeleccionado', 'anioSeleccionado', 'imageSrc','encabezadoSrc','paginacionSrc');

        // Renderiza la vista sin generar el PDF aún
        $html = View::make('Form_E_N_I.PDF.reporte_form2_pdf', $data)->render();

        // Crea el PDF con DomPDF
        $pdf = PDF::loadHTML($html);

        // Envía el PDF con la marca de agua como respuesta HTTP
        return $pdf->stream();
    }

    // public function generar(Request $request)
    // {
    //     $fechaSeleccionada = $request->fecha;
    //     $mesSeleccionado = Carbon::parse($fechaSeleccionada)->month;
    //     $nombreMesSeleccionado = Carbon::parse($fechaSeleccionada)->locale('es')->monthName;
    //     $anioSeleccionado = Carbon::parse($fechaSeleccionada)->year;
    //     // Obtener todas las patologías disponibles
    //     $todasLasPatologias = Patologia::select('nombre')->get();

    //     // Consulta para obtener el conteo por patología
    //     $conteoPorPatologia = SeleccionPatologia::select(
    //         'p.nombre as patologia',
    //         DB::raw('COUNT(*) as total_casos')
    //     )
    //     ->rightJoin('epidemiologia.patologia as p', 'p.cod_patologia', '=', 'seleccion_patologia.cod_pato')
    //     ->rightJoin('epidemiologia.formulario_enfermedades_notificacion_inmediata as f', 'f.id_f_notificacion_inmediata', '=', 'seleccion_patologia.cod_form_n_i')
    //     ->whereMonth('f.fecha', $mesSeleccionado)
    //     ->whereYear('f.fecha', $anioSeleccionado)
    //     ->where('f.estado', 'alta')
    //     ->groupBy('p.nombre')
    //     ->get();
    //     // Combinar el conteo con todas las patologías para mostrar las que tienen 0 casos
    //     $conteoCombinado = collect([]);
    //     foreach ($todasLasPatologias as $patologia) {
    //         $conteo = $conteoPorPatologia->firstWhere('patologia', $patologia->nombre);
    //         if ($conteo) {
    //             $conteoCombinado->push($conteo);
    //         } else {
    //             $conteoCombinado->push([
    //                 'patologia' => $patologia->nombre,
    //                 'total_casos' => 0,
    //             ]);
    //         }
    //     }

    //     $data = compact('conteoCombinado', 'nombreMesSeleccionado', 'anioSeleccionado');
    //     $pdf = PDF::loadview('Form_E_N_I.PDF.reporte_form2_pdf', $data);
    //     return $pdf->stream();
    // }


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

    public function tabla()
    {
        $formularios = FormularioEnfermedadesNotificacionInmediata::with('datopaciente')
        ->orderBy('id_f_notificacion_inmediata', 'desc')
        ->get();
        return view('Form_E_N_I.VistaTabla', compact('formularios'));
    }

    public function eliminarFormulario($codigoFormulario)
    {
        // Buscar el formulario por el código
        $formulario = FormularioEnfermedadesNotificacionInmediata::find($codigoFormulario);

        if (!$formulario) {
            return redirect()->back()->with('error', 'No se encontró el formulario solicitado.');
        }

        // Eliminar registros relacionados en ANTIBIOGRAMA
        SeleccionPatologia::where('cod_form_n_i', $codigoFormulario)->delete();

        // Eliminar el formulario y sus registros relacionados en FORMULARIO_NOTIFICACION_PACIENTE
        $formulario->delete();

        return redirect()->back()->with('success', 'Formulario y registros relacionados eliminados exitosamente.');
    }


    public function repAnual(Request $request)
    {
        $fechaSeleccionada = $request->a;
        // Obtener datos para las patologías de interés
        $informePatologias = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata as f')
            ->join('epidemiologia.seleccion_patologia as sp', 'f.id_f_notificacion_inmediata', '=', 'sp.cod_form_n_i')
            ->join('epidemiologia.patologia as p', 'sp.cod_pato', '=', 'p.cod_patologia')
            ->join('epidemiologia.servicio as s', 'f.cod_servi', '=', 's.cod_servicio')
            ->whereYear('f.fecha', $fechaSeleccionada)
            ->where('f.estado', 'alta')
            ->select(
                's.nombre as servicio',
                'p.nombre as patologia',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('s.nombre', 'p.nombre')
            ->havingRaw('COUNT(*) > 0')
            ->orderBy('s.nombre', 'asc')
            ->orderBy('p.nombre', 'asc')
            ->get();

        // Sumar la cantidad total de casos por patología
        $totalCasosPorPatologia = $informePatologias->groupBy('patologia')->map(function ($item) {
            return $item->sum('cantidad');
        });

        // Sumar la cantidad total de casos por servicio
        $totalCasosPorServicio = $informePatologias->groupBy('servicio')->map(function ($item) {
            return $item->sum('cantidad');
        });


        // Obtener la lista de servicios disponibles
        $servicios = Servicio::all();

        // Combinar todos los datos necesarios en un arreglo
        $data = [
            'fecha_select' => $fechaSeleccionada,
            'informePatologias' => $informePatologias,
            'totalCasosPorPatologia' => $totalCasosPorPatologia,
            'servicios' => $servicios,
        ];

        // Generar el PDF y configurar la respuesta
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_anual', $data);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);
        $pdf->getDomPDF()->set_paper('A4', 'portrait');
        $nombreArchivo = 'Informe_ANUAL_' . $fechaSeleccionada . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }
    // REPORTE ANUAL POR MESES
    public function reporteAnual(Request $request)
    {
        $fechaSeleccionada = $request->a;

        // Obtén el mes actual y año actual
        $fechaActual = Carbon::now('America/La_Paz');
        $mesActual = $fechaActual->month;
        $añoActual = $fechaActual->year;

        // Asegúrate de que la fecha seleccionada sea válida (no futura)
        if ($fechaSeleccionada > $fechaActual) {
            $fechaSeleccionada = $fechaActual;
        }

        $informeMensual = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata as f')
            ->join('epidemiologia.seleccion_patologia as sp', 'f.id_f_notificacion_inmediata', '=', 'sp.cod_form_n_i')
            ->join('epidemiologia.patologia as p', 'sp.cod_pato', '=', 'p.cod_patologia')
            ->whereYear('f.fecha', $fechaSeleccionada)
            ->whereRaw('EXTRACT(MONTH FROM f.fecha) <= ?', [$mesActual]) // Modificamos esta línea
            ->where('f.estado', 'alta')
            ->select(
                DB::raw('EXTRACT(MONTH FROM f.fecha) as mes'), // Modificamos esta línea
                'p.nombre as patologia',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy(DB::raw('EXTRACT(MONTH FROM f.fecha)'), 'p.nombre') // Modificamos esta línea
            ->havingRaw('COUNT(*) > 0')
            ->orderBy(DB::raw('EXTRACT(MONTH FROM f.fecha)'), 'asc') // Modificamos esta línea
            ->orderBy('p.nombre', 'asc')
            ->get();


        // Obtener la lista de meses disponibles
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $totalCasosPorMes = [];
        foreach ($meses as $mesNumero => $nombreMes) {
            $totalCasosPorMes[$mesNumero] = $informeMensual
                ->where('mes', $mesNumero)
                ->sum('cantidad');
        }
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
        // Combinar todos los datos necesarios en un arreglo
        $data = [
            'fecha_select' => $fechaSeleccionada,
            'informeMensual' => $informeMensual,
            'meses' => $meses,
            'mesActual' => $mesActual, // Puedes pasar el mes actual a la vista
            'añoActual' => $añoActual, // Puedes pasar el año actual a la vista
            'totalCasosPorMes' => $totalCasosPorMes, // Agregar esto
            'fechaHoraActual' => $fechaHoraActual,
        ];

        // Generar el PDF y configurar la respuesta
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_anual_por_mes', $data);
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);
        $pdf->getDomPDF()->set_paper('A4', 'portrait');
        $nombreArchivo = 'Informe_MENSUAL_' . $fechaSeleccionada . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }
    //REPORTE POR RANGO DE FECHAS
    public function reporteRango(Request $request)
    {
        // Obtener las fechas de entrada y salida proporcionadas por el usuario
        $fechaEntrada = $request->input('fecha_e');
        $fechaSalida = $request->input('fecha_s');

        // Desglose de la fecha de entrada
        $yearEntrada = date('Y', strtotime($fechaEntrada));
        $monthEntrada = date('m', strtotime($fechaEntrada));
        $dayEntrada = date('d', strtotime($fechaEntrada));

        // Desglose de la fecha de salida
        $yearSalida = date('Y', strtotime($fechaSalida));
        $monthSalida = date('m', strtotime($fechaSalida));
        $daySalida = date('d', strtotime($fechaSalida));

        $añoSeleccionado = date('Y', strtotime($fechaEntrada)); // Obtener el año del rango de fechas
        $fechaActual = now();
        $mesActual = $fechaActual->month;

        $informe = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata as f')
            ->join('epidemiologia.seleccion_patologia as sp', 'f.id_f_notificacion_inmediata', '=', 'sp.cod_form_n_i')
            ->join('epidemiologia.patologia as p', 'sp.cod_pato', '=', 'p.cod_patologia')
            ->whereDate('f.fecha', '>=', $fechaEntrada)
            ->whereDate('f.fecha', '<=', $fechaSalida)
            ->where('f.estado', 'alta')
            ->select(
                'p.nombre as patologia',
                DB::raw('COUNT(*) as cantidad')
            )
            ->groupBy('p.nombre')
            ->havingRaw('COUNT(*) > 0')
            ->orderBy('p.nombre', 'asc')
            ->get();

        $totalCasos = $informe->sum('cantidad');
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');


        $imagePath = public_path('img/logo_HDB.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $encabezado =public_path('img/encabezado.png');
        $encabezadoData = base64_encode(file_get_contents($encabezado));
        $encabezadoSrc = 'data:image/png;base64,' . $encabezadoData;

        $paginacion = public_path('img/paginacion.png');
        $paginacionData = base64_encode(file_get_contents($paginacion));
        $paginacionSrc = 'data:image/png;base64,' . $paginacionData;

        $data = [

            'fechaHoraActual' => $fechaHoraActual,
            'informe' => $informe,
            'imageSrc'=> $imageSrc,
            'encabezadoSrc' => $encabezadoSrc,
            'paginacionSrc' => $paginacionSrc,
            'totalCasos' => $totalCasos,
            'fechaEntrada' => $fechaEntrada,
            'fechaSalida' => $fechaSalida,
        ];
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_rango_E_N_I', $data);

        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);

        // Establecer tamaño y orientación de página
        $pdf->getDomPDF()->set_paper('A4', 'portrait');

        // nombre personalizado para descargar con un nombre predeterminado
        $nombreArchivo = 'Reporte_ANUAL_por_meses_E_N_I_año:' . $añoSeleccionado . '.pdf';
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }

}
