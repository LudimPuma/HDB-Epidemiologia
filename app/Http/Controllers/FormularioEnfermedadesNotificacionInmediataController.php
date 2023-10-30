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
    public function __construct(){
        $this->middleware('can:create-form-eni')->only('showViewForm');
        $this->middleware('can:create-form-eni')->only('searchHistorial');
        $this->middleware('can:create-form-eni')->only('mostrarFormulario');
        $this->middleware('can:create-form-eni')->only('guardarDatos');
        $this->middleware('can:button-form-eni-table')->only('tabla');
        $this->middleware('can:button-form-pdf-eni')->only('vistaPreviaPDF');
        $this->middleware('can:edit-form-eni')->only('update');
        $this->middleware('can:button-form-informe-eni')->only('informeTuberculosis');
        $this->middleware('can:button-form-informe-eni')->only('informeTrimestralSemestralTuberculosis');
    }

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

    //GUARDAR_ENFER_NOTI
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
    //MODIFICAR ESTADO
    public function update(Request $request, FormularioEnfermedadesNotificacionInmediata $formulario)
    {
        $request->validate([
            'estado' => 'required|in:alta,baja',
        ]);

        $data = [
            'estado' => $request->estado,
        ];

        if ($request->estado === 'baja') {
            $request->validate([
                'motivos_baja' => 'required',
            ],
            [
                'motivos_baja.required'=> 'Debe dar un motivo de baja',
            ]
        );
            $data['motivos_baja'] = $request->motivos_baja;
        } else {
            $data['motivos_baja'] = null;
        }
        $formulario->update($data);
        if ($formulario->update($data)) {
            $request->session()->flash('success', 'Estado actualizado exitosamente');
        }
        $formularios = FormularioEnfermedadesNotificacionInmediata::with('datopaciente')
        ->orderBy('id_f_notificacion_inmediata', 'desc')
        ->get();

        return view('Form_E_N_I.VistaTabla', ['formularios' => $formularios]);
    }

    //PDF FORMULARIO
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
        $pdf = PDF::loadView('Form_E_N_I.PDF.form_2_pdf', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header_form.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 20,
            'header-spacing' => 0,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);

        $nombreArchivo = 'Formulario_E.N.I._' . $fechaActual . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
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



        $data = compact('fechaHoraActual','conteoCombinado', 'nombreMesSeleccionado', 'anioSeleccionado');
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_form2_pdf', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);
        // Renderiza la vista sin generar el PDF aún
        // $html = View::make('Form_E_N_I.PDF.reporte_form2_pdf', $data)->render();

        // Crea el PDF con DomPDF
        // $pdf = PDF::loadHTML($html);

        // Envía el PDF con la marca de agua como respuesta HTTP
        // return $pdf->stream();
        $nombreArchivo = 'Reporte_MENSUAL_' . $fechaSeleccionada . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
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
        //++++++++++++++++++++++++++++++++



        return view('principal', compact('labels', 'datasets'));
    }

    public function tabla()
    {
        $formularios = FormularioEnfermedadesNotificacionInmediata::with('datopaciente')
        ->orderBy('id_f_notificacion_inmediata', 'desc')
        ->get();
        return view('Form_E_N_I.VistaTabla', compact('formularios'));
    }

    //REPORTE ANUAL POR SERVICIOS
    public function repAnual(Request $request)
    {
        $fechaSeleccionada = $request->a;
        $nombre = "Anual";
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
            'nombre' => $nombre,
        ];

        // Generar el PDF y configurar la respuesta
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_anual', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);
        $nombreArchivo = 'Informe_anual_por_Servicios ' . $fechaSeleccionada . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }
    //REPORTE TRIMESTRAL - SEMESTRAL POR SERVICIOS
    public function reporteENITrimestralSemestralServicio(Request $request)
    {
        $fechaSeleccionada = $request->a;
        $rangoSeleccionado = $request->input('rango');
        $nombre = null;
        // Calcular las fechas de inicio y fin del trimestre seleccionado
        if ($rangoSeleccionado == 'primer_trimestre') {
            $inicioRango = $fechaSeleccionada . '-01-01';
            $finRango = $fechaSeleccionada . '-03-31';
            $nombre = "Primer Trimestre: Enero - Marzo";
        } elseif ($rangoSeleccionado == 'segundo_trimestre') {
            $inicioRango = $fechaSeleccionada . '-04-01';
            $finRango = $fechaSeleccionada . '-06-30';
            $nombre = "Segundo Trimestre: Abril - Junio";
        } elseif ($rangoSeleccionado == 'tercer_trimestre') {
            $inicioRango = $fechaSeleccionada . '-07-01';
            $finRango = $fechaSeleccionada . '-09-30';
            $nombre = "Tercer Trimestre: Julio - Septiembre";
        } elseif ($rangoSeleccionado == 'cuarto_trimestre') {
            $inicioRango = $fechaSeleccionada . '-10-01';
            $finRango = $fechaSeleccionada . '-12-31';
            $nombre = "Cuarto Trimestre: Octubre - Diciembre";
        } elseif ($rangoSeleccionado == 'primer_semestre') {
            $inicioRango = $fechaSeleccionada . '-01-01';
            $finRango = $fechaSeleccionada . '-06-30';
            $nombre = "Primer Semestre: Enero - Junio";
        } elseif ($rangoSeleccionado == 'segundo_semestre') {
            $inicioRango = $fechaSeleccionada . '-07-01';
            $finRango = $fechaSeleccionada . '-12-31';
            $nombre = "Segundo Semestre: Julio - Diciembre";
        } else {
            // Manejo de error si se selecciona un trimestre inválido
            return redirect()->back()->with('error', 'Trimestre no válido');
        }
        // Obtener datos para las patologías de interés
        $informePatologias = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata as f')
            ->join('epidemiologia.seleccion_patologia as sp', 'f.id_f_notificacion_inmediata', '=', 'sp.cod_form_n_i')
            ->join('epidemiologia.patologia as p', 'sp.cod_pato', '=', 'p.cod_patologia')
            ->join('epidemiologia.servicio as s', 'f.cod_servi', '=', 's.cod_servicio')
            ->whereBetween('f.fecha', [$inicioRango, $finRango])
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
            'nombre' => $nombre,
        ];

        // Generar el PDF y configurar la respuesta
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_anual', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);
        $nombreArchivo = 'Informe_anual_por_Servicios ' . $fechaSeleccionada . '.pdf';

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
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);
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

        $fechaSeleccionada = date('Y', strtotime($fechaEntrada)); // Obtener el año del rango de fechas
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

        // dd($informe);
        $totalCasos = $informe->sum('cantidad');
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');


        $data = [

            'fechaHoraActual' => $fechaHoraActual,
            'informe' => $informe,
            'totalCasos' => $totalCasos,
            'fechaEntrada' => $fechaEntrada,
            'fechaSalida' => $fechaSalida,
        ];
        $pdf = PDF::loadView('Form_E_N_I.PDF.reporte_rango_E_N_I', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);

        // nombre personalizado para descargar con un nombre predeterminado
        $nombreArchivo = 'Reporte_ANUAL_por_meses_E_N_I_año:' . $fechaSeleccionada . '.pdf';
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }

    //INFORME TUBERCULOSIS
    public function informeTuberculosis(Request $request)
    {
        $fechaSeleccionada = $request->input('a');
        $nombre = "Anual";
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];

        $informeMensual = [];
        $fechaActual = Carbon::now();
        $mesActual = $fechaActual->month;

        foreach ($meses as $mes) {
            // Obtén el número de mes correspondiente al mes actual
            $mesActualNumero = array_search($mes, $meses) + 1;
            if ($mesActualNumero <= $mesActual) {

                $fechaInicio = Carbon::create($fechaSeleccionada, $mesActualNumero, 1)->startOfMonth();
                $fechaFin = Carbon::create($fechaSeleccionada, $mesActualNumero, 1)->endOfMonth();

                // Realiza la consulta con el rango de fechas actual
                $informeTuberculosis = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata as f')
                ->join('epidemiologia.seleccion_patologia as sp', 'f.id_f_notificacion_inmediata', '=', 'sp.cod_form_n_i')
                ->join('epidemiologia.patologia as p', 'sp.cod_pato', '=', 'p.cod_patologia')
                ->join('epidemiologia.datos_paciente as dp', 'f.h_clinico', '=', 'dp.n_h_clinico')
                ->whereBetween('f.fecha', [$fechaInicio, $fechaFin])
                ->where('f.estado', 'alta')
                ->whereIn('p.nombre', ['Tuberculosis (Positivo)', 'Tuberculosis (Negativo)'])
                ->select(
                    'dp.sexo',
                    DB::raw('SUM(CASE WHEN p.nombre = \'Tuberculosis (Positivo)\' THEN 1 ELSE 0 END) as positivo'),
                    DB::raw('SUM(CASE WHEN p.nombre = \'Tuberculosis (Negativo)\' THEN 1 ELSE 0 END) as negativo')
                )
                ->groupBy('dp.sexo')
                ->get();

                // Calcular los totales
                $totalMasculinoPositivo = $informeTuberculosis->where('sexo', 'M')->sum('positivo');
                $totalMasculinoNegativo = $informeTuberculosis->where('sexo', 'M')->sum('negativo');
                $totalFemeninoPositivo = $informeTuberculosis->where('sexo', 'F')->sum('positivo');
                $totalFemeninoNegativo = $informeTuberculosis->where('sexo', 'F')->sum('negativo');
                $totalMasculino = $totalMasculinoPositivo + $totalMasculinoNegativo;
                $totalFemenino = $totalFemeninoPositivo + $totalFemeninoNegativo;
                $totalMes = $totalMasculino + $totalFemenino;

                // Agregar el informe del mes al informe mensual
                $informeMensual[] = [
                    'mes' => $mes,
                    'informeTuberculosis' => $informeTuberculosis,
                    'totalMasculinoPositivo' => $totalMasculinoPositivo,
                    'totalMasculinoNegativo' => $totalMasculinoNegativo,
                    'totalFemeninoPositivo' => $totalFemeninoPositivo,
                    'totalFemeninoNegativo' => $totalFemeninoNegativo,
                    'totalMasculino' => $totalMasculino,
                    'totalFemenino' => $totalFemenino,
                    'totalMes' => $totalMes,
                ];
            }
        }

        $data = [
            'fechaSeleccionada' => $fechaSeleccionada,
            'informeMensual' => $informeMensual,
            'nombre' => $nombre,
        ];

        // Generar el PDF y configurar la respuesta
        $pdf = PDF::loadView('Form_E_N_I.PDF.informe_tuberculosis', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);

        $nombreArchivo = 'Informe_Tuberculosis_' . $fechaSeleccionada . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }
    //INFORME TRIMESTRAL-SEMESTRAL TUBERCULOSIS
    public function informeTrimestralSemestralTuberculosis(Request $request)
    {
        $fechaSeleccionada = $request->input('a');
        $rangoSeleccionado = $request->input('rango');

        $nombre = null;
        $meses = [];

        switch ($rangoSeleccionado) {
            case 'primer_trimestre':
                $inicioRango = $fechaSeleccionada . '-01-01';
                $finRango = $fechaSeleccionada . '-03-31';
                $nombre = "Primer Trimestre: Enero - Marzo";
                $meses = ['Enero', 'Febrero', 'Marzo'];
                break;
            case 'segundo_trimestre':
                $inicioRango = $fechaSeleccionada . '-04-01';
                $finRango = $fechaSeleccionada . '-06-30';
                $nombre = "Segundo Trimestre: Abril - Junio";
                $meses = ['Abril', 'Mayo', 'Junio'];
                break;
            case 'tercer_trimestre':
                $inicioRango = $fechaSeleccionada . '-07-01';
                $finRango = $fechaSeleccionada . '-09-30';
                $nombre = "Tercer Trimestre: Julio - Septiembre";
                $meses = ['Julio', 'Agosto', 'Septiembre'];
                break;
            case 'cuarto_trimestre':
                $inicioRango = $fechaSeleccionada . '-10-01';
                $finRango = $fechaSeleccionada . '-12-31';
                $nombre = "Cuarto Trimestre: Octubre - Diciembre";
                $meses = ['Octubre', 'Noviembre', 'Diciembre'];
                break;
            case 'primer_semestre':
                $inicioRango = $fechaSeleccionada . '-01-01';
                $finRango = $fechaSeleccionada . '-06-30';
                $nombre = "Primer Semestre: Enero - Junio";
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'];
                break;
            case 'segundo_semestre':
                $inicioRango = $fechaSeleccionada . '-07-01';
                $finRango = $fechaSeleccionada . '-12-31';
                $nombre = "Segundo Semestre: Julio - Diciembre";
                $meses = ['Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                break;
            default:
                return redirect()->back()->with('error', 'Rango no válido');
        }


        $informeMensual = [];
        $informeTuberculosis = DB::table('epidemiologia.formulario_enfermedades_notificacion_inmediata as f')
            ->join('epidemiologia.seleccion_patologia as sp', 'f.id_f_notificacion_inmediata', '=', 'sp.cod_form_n_i')
            ->join('epidemiologia.patologia as p', 'sp.cod_pato', '=', 'p.cod_patologia')
            ->join('epidemiologia.datos_paciente as dp', 'f.h_clinico', '=', 'dp.n_h_clinico')
            ->whereBetween('f.fecha', [$inicioRango, $finRango])
            ->where('f.estado', 'alta')
            ->whereIn('p.nombre', ['Tuberculosis (Positivo)', 'Tuberculosis (Negativo)'])
            ->select(
                'dp.sexo',
                DB::raw("to_char(f.fecha, 'TMMonth')"),
                DB::raw('SUM(CASE WHEN p.nombre = \'Tuberculosis (Positivo)\' THEN 1 ELSE 0 END) as positivo'),
                DB::raw('SUM(CASE WHEN p.nombre = \'Tuberculosis (Negativo)\' THEN 1 ELSE 0 END) as negativo')
            )
            ->groupBy('dp.sexo','f.fecha')
            ->get();
        foreach ($meses as $mes) {

            $datosMesActual = $informeTuberculosis->where('to_char', $mes);
            $totalMasculinoPositivo = $datosMesActual->where('sexo', 'M')->sum('positivo');
            $totalMasculinoNegativo = $datosMesActual->where('sexo', 'M')->sum('negativo');
            $totalFemeninoPositivo = $datosMesActual->where('sexo', 'F')->sum('positivo');
            $totalFemeninoNegativo = $datosMesActual->where('sexo', 'F')->sum('negativo');

            $totalMasculino = $totalMasculinoPositivo + $totalMasculinoNegativo;
            $totalFemenino = $totalFemeninoPositivo + $totalFemeninoNegativo;
            $totalMes = $totalMasculino + $totalFemenino;

            $informeMensual[] = [
                'mes' => $mes,
                'totalMasculinoPositivo' => $totalMasculinoPositivo,
                'totalMasculinoNegativo' => $totalMasculinoNegativo,
                'totalFemeninoPositivo' => $totalFemeninoPositivo,
                'totalFemeninoNegativo' => $totalFemeninoNegativo,
                'totalMasculino' => $totalMasculino,
                'totalFemenino' => $totalFemenino,
                'totalMes' => $totalMes,
            ];
        }

        // dd($informeMensual);
        $data = [
            'fechaSeleccionada' => $fechaSeleccionada,
            'nombre' =>$nombre,
            'informeMensual' => $informeMensual,
        ];

        // Generar el PDF y configurar la respuesta
        $pdf = PDF::loadView('Form_E_N_I.PDF.informe_tuberculosis', $data);
        $footerPath = base_path('resources/views/pdf/footer.html');
        $headerPath = base_path('resources/views/pdf/header.html');

        $pdf->setOptions([
            'orientation' => 'portrait',
            'footer-spacing' => 10,
            'margin-top' => 30,
            'header-spacing' => 10,
            'margin-bottom' => 20,
            'footer-font-size'=> 12,
            'footer-html' => $footerPath,
            'header-html' => $headerPath,
        ]);

        $nombreArchivo = 'Informe_Tuberculosis_' . $fechaSeleccionada . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }
}
