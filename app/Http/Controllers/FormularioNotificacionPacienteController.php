<?php

namespace App\Http\Controllers;
use PDF;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Antibiograma;
use App\SeleccionTipoInfeccion;
use App\DatoPaciente;
use App\Servicio;
use App\TipoInfeccion;
use App\ProcedimientoInmasivo;
//use App\Agente;
use App\TipoMuestra;
use App\Bacteria;
use App\Medicamento;
use App\FormularioNotificacionPaciente;
class FormularioNotificacionPacienteController extends Controller
{

    public function showViewForm()
    {
        return view('Form_IAAS.view_form_1');
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
        //$antibiogramas = Antibiograma::all();
        $datosPacientes = DatoPaciente::all();
        $servicios = Servicio::all();
        $tiposInfeccion = TipoInfeccion::all();
        $procedimientosInmasivos = ProcedimientoInmasivo::all();
        //$agentes = Agente::all();
        $tiposMuestra = TipoMuestra::all();
        $bacterias = Bacteria::all();
        $fechaActual = Carbon::now('America/La_Paz')->format('Y-m-d');
        //$nivelesAntibiograma = NivelAntibiograma::with('medicamento')->get();

        // Pasa los datos a la vista del formulario
        return view('Form_IAAS.formulario_IAAS', compact('id','nombre', 'datosPacientes', 'bacterias','servicios', 'tiposInfeccion', 'procedimientosInmasivos', 'tiposMuestra','fechaActual'));
    }
    public function obtenerMedicamentos($id)
    {
        $bacteriaId = $id;

        // Obtener los medicamentos asociados a la bacteria
        $medicamentos = DB::table('epidemiologia.bacterias_medicamentos')
            ->join('epidemiologia.medicamentos', 'epidemiologia.bacterias_medicamentos.cod_medi', '=', 'epidemiologia.medicamentos.cod_medicamento')
            ->where('epidemiologia.bacterias_medicamentos.cod_bacte', $bacteriaId)
            ->select('epidemiologia.medicamentos.*')
            ->get();

        $bacterias = DB::table('epidemiologia.bacterias')
            ->where('cod_bacterias', $bacteriaId)
            ->get();

        $conteoMedicamentos = count($medicamentos);

        // Devuelve los medicamentos y bacterias en formato JSON
        return response()->json(['medicamentos' => $medicamentos, 'bacterias' => $bacterias, 'conteoMedicamentos' => $conteoMedicamentos]);
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
        //'infecciones_seleccionadas' => 'required',
        'uso_antimicrobanos' => 'required',
        //'agente_causal' => 'required',
        'tipo_muestra_cultivo' => 'required',
        'procedimiento_invasivo' => 'required',
        'medidas_tomar' => 'required',
        'aislamiento' => 'required',
        'seguimiento' => 'required',
        'observacion' => 'required',
        'informacion_bacterias_input' => 'required',
        'infecciones_seleccionadas'=> 'required',
    ],
    [
        'h_clinico.required'=> 'El Nro. Clinico no puede estar vacio',
        'fecha_llenado.required'=> 'La fecha de llenado no puede estar vacio',
        'fecha_ingreso.required'=> 'La fecha de ingreso del paciente no puede estar vacio',
        'servicio_inicio_sintomas.required'=> 'El servicio de inicio de sintomas no puede estar vacio',
        'servicio_notificador.required'=> 'El servicio notificador no puede estar vacio',
        'diagnostico_ingreso.required' => 'El diagnostico de ingreso no puede estar vacio',
        'diagnostico_sala.required' => 'El diagnostico de sala no puede estar vacio',
        'uso_antimicrobanos.required'=> 'Este campo no puede estar vacio',
        'tipo_muestra_cultivo.required'=> 'Tipo de muestra cultivo no puede estar vacio',
        'procedimiento_invasivo.required'=> 'Procedimiento invasivo no puede estar vacio',
        'medidas_tomar.required'=> 'Medidas a tomar no puede estar vacio',
        'aislamiento.required'=> 'No puede estar vacio',
        'seguimiento.required'=> 'El seguimiento no puede estar vacio',
        'observacion.required'=> 'La observacion no puede estar vacio',
        // 'informacion_bacterias_input.required'=> ' no puede estar vacio',
        // 'infecciones_seleccionadas.required'=> ' no puede estar vacio',
    ]
    );

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
    //$formulario->tipo_infeccion = $request->input('tipo_infeccion');
    $formulario->uso_antimicrobanos = $request->input('uso_antimicrobanos');
    //$formulario->agente_causal = $request->input('agente_causal');
    $formulario->tipo_muestra_cultivo = $request->input('tipo_muestra_cultivo');
    $formulario->procedimiento_invasivo = $request->input('procedimiento_invasivo');
    $formulario->medidas_tomar = $request->input('medidas_tomar');
    $formulario->aislamiento = $request->input('aislamiento');
    $formulario->seguimiento = $request->input('seguimiento');
    $formulario->observacion = $request->input('observacion');

    // Guardar el formulario en la base de datos
    $formulario->save();

    // Obtener el código del formulario recién guardado
    $codigoFormulario = $formulario->cod_form_notificacion_p ;

    //TABLA TIPO INFECCION
    // Obtener las infecciones seleccionadas del campo oculto
    $infeccionesSeleccionadas = $request->input('infecciones_seleccionadas');

    // Decodificar el JSON y procesar las infecciones seleccionadas
    $infeccionesSeleccionadas = json_decode($infeccionesSeleccionadas);

    // Crear una instancia de SeleccionTipoInfeccion para cada infección seleccionada
    foreach ($infeccionesSeleccionadas as $codTipoInf) {
        $seleccionTipoInfeccion = new SeleccionTipoInfeccion();
        $seleccionTipoInfeccion->cod_formulario = $codigoFormulario;
        $seleccionTipoInfeccion->h_cli = $request->input('h_clinico');
        $seleccionTipoInfeccion->cod_tipo_inf = $codTipoInf;
        $seleccionTipoInfeccion->save();
    }


// TABLA ANTOIBIOGRAMA
    // Obtener la información de antibiograma desde el input oculto
    $informacionAntibiograma = $request->input('informacion_bacterias_input');
    //dd($informacionAntibiograma); // Agregar esta línea
    // Convertir la cadena en un array de líneas
    $lineasAntibiograma = explode("\n", $informacionAntibiograma);
    //dd($lineasAntibiograma);

    //PRUEBA
    // Arreglos para almacenar los nombres de bacterias y medicamentos
    $nombresBacterias = [];
    $nombresMedicamentos = [];
    $datosAntibiograma = [];

    // Recorrer las líneas y almacenar los datos en la base de datos
    foreach ($lineasAntibiograma as $linea) {
        $lineaLimpia = str_replace("\r", "", $linea);
        // Si la línea está vacía, continuar con la siguiente iteración
        if (empty($lineaLimpia)) {
            continue;
        }

        //dd($linea);
        // Separar los datos limpios
        $datos = explode(",", $lineaLimpia);
        $codBacte = $datos[0];
        $codMedi = $datos[1];
        $nivel = $datos[2];

//*---------------------------------prueba pdf------------------------------------------------
        // // Consultar nombres de bacterias y medicamentos
        // $bacteria = Bacteria::where('cod_bacterias', $codBacte)->first();
        // if ($bacteria) {
        //     $nombresBacterias[] = $bacteria->nombre;
        // }

        // $medicamento = Medicamento::where('cod_medicamento', $codMedi)->first();
        // if ($medicamento) {
        //     $nombresMedicamentos[] = $medicamento->nombre;
        // }
        // Consultar nombres de bacterias y medicamentos
        $bacteria = Bacteria::where('cod_bacterias', $codBacte)->first();
        $medicamento = Medicamento::where('cod_medicamento', $codMedi)->first();
        if ($bacteria && $medicamento) {
            $datosAntibiograma[] = [
                'bacteria' => $bacteria->nombre,
                'medicamento' => $medicamento->nombre,
                'resistencia' => $nivel,
            ];
        }
//*---------------------------------prueba pdf------------------------------------------------

        // Crear y guardar una nueva entrada de antibiograma
        $antibiograma = new Antibiograma();
        $antibiograma->cod_formulario = $codigoFormulario;
        $antibiograma->h_cli = $request->input('h_clinico');
        $antibiograma->cod_bacte = $codBacte;
        $antibiograma->cod_medi = $codMedi;
        $antibiograma->nivel = $nivel;
        // dd($antibiograma);
        $antibiograma->save();
    }

    // //pdf
    // // Consultar los nombres de los tipos de infección usando los códigos
    // $nombresTiposInfeccion = [];
    // foreach ($infeccionesSeleccionadas as $codTipoInf) {
    //     $tipoInfeccion = TipoInfeccion::where('cod_tipo_infeccion', $codTipoInf)->first();
    //     if ($tipoInfeccion) {
    //         $nombresTiposInfeccion[] = $tipoInfeccion->nombre;
    //     }
    // }
    // $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
    // $data = [
    //     'h_clinico' => $request->input('h_clinico'),
    //     'nombreP' => DatoPaciente::where('n_h_clinico',$request->input('h_clinico'))->first(),
    //     'fecha_llenado' => $request->input('fecha_llenado'),
    //     'fecha_ingreso' => $request->input('fecha_ingreso'),
    //     'servicio_inicio_sintomas' => Servicio::where('cod_servicio',$request->input('servicio_inicio_sintomas'))->first(),
    //     'servicio_notificador' => Servicio::where('cod_servicio',$request->input('servicio_notificador'))->first(),
    //     'diagnostico_ingreso' => $request->input('diagnostico_ingreso'),
    //     'diagnostico_sala' => $request->input('diagnostico_sala'),
    //     'nombresTiposInfeccion' => $nombresTiposInfeccion,
    //     'uso_antimicrobanos' => $request->input('uso_antimicrobanos'),
    //     'tipo_muestra_cultivo' => TipoMuestra::where('cod_tipo_muestra',$request->input('tipo_muestra_cultivo'))->first(),
    //     'procedimiento_invasivo' => ProcedimientoInmasivo::where('cod_procedimiento_invasivo',$request->input('procedimiento_invasivo'))->first(),
    //     'datosAntibiograma' => $datosAntibiograma,
    //     'medidas_tomar' => $request->input('medidas_tomar'),
    //     'aislamiento' => $request->input('aislamiento'),
    //     'seguimiento' => $request->input('seguimiento'),
    //     'observacion' => $request->input('observacion'),
    //     'fechaHoraActual'  => $fechaHoraActual,
    // ];
    // // Generar el contenido del PDF a partir de la vista del formulario
    // $pdf = PDF::loadView('Form_IAAS.PDF.form_IAAS', $data);

    // // Opcional: Establecer opciones de estilo para el PDF
    // $pdf->setOptions([
    //     'dpi' => 150,
    //     'defaultFont' => 'Arial',
    // ]);

    // // Generar el nombre del archivo PDF (puedes personalizarlo)
    // $pdfFileName = 'formulario_' . $request->input('h_clinico') . '.pdf';

    // $pdfPath = $pdfFileName;
    // $pdf->save($pdfPath);


    // // Llamar a la función generarPDF y pasar las variables necesarias
    // $pdfPath = $this->generarPDF(
    //     $codigoFormulario,
    //     $nombresTiposInfeccion,
    //     $nombresBacterias,
    //     $nombresMedicamentos
    // );
    //return $pdf->stream();
    return redirect()->route('principal')->with('success', 'Los datos han sido guardados exitosamente.');
    }

    public function tabla()
    {
        $formularios = FormularioNotificacionPaciente::with('datopaciente')
        ->orderBy('cod_form_notificacion_p', 'desc')
        ->get();
        return view('Form_IAAS.VistaTabla', compact('formularios'));
    }


    public function generarPDF($codigoFormulario)
    {
        $formulario = FormularioNotificacionPaciente::find($codigoFormulario);
        if (!$formulario) {
            // El formulario no existe, puedes mostrar un mensaje de error o redirigir a otra página
            return redirect()->back()->with('error', 'No se encontró el formulario solicitado.');
        }
        $cod_formulario = $formulario->cod_form_notificacion_p;
    // ---------------TIPO INFECCION---------------------------------
        $codigosTiposInfeccion = SeleccionTipoInfeccion::where('cod_formulario', $cod_formulario)
        ->pluck('cod_tipo_inf')
        ->toArray();
        // Consultar los nombres de los tipos de infección usando los códigos
        $nombresTiposInfeccion = [];
        foreach ($codigosTiposInfeccion as $codTipoInf) {
            $tipoInfeccion = TipoInfeccion::find($codTipoInf);
            if ($tipoInfeccion) {
                $nombresTiposInfeccion[] = $tipoInfeccion->nombre;
            }
        }
    // -----------------------------------------------------------------------

    // *******************ANTIBIOGRAMA************************************}
        $datosAntibiograma = [];
        $antibiogramas = Antibiograma::with(['bacteria', 'medicamento'])
            ->where('cod_formulario', $cod_formulario)
            ->get();

        $datosAntibiograma = [];
        foreach ($antibiogramas as $antibiograma) {
            $datosAntibiograma[] = [
                'bacteria' => $antibiograma->bacteria->nombre,
                'medicamento' => $antibiograma->medicamento->nombre,
                'resistencia' => $antibiograma->nivel,
            ];
        }
    // *****************************************************************
        $h_clinico = $formulario->h_clinico;
        $fecha_llenado = $formulario->fecha_llenado;
        $fecha_ingreso = $formulario->fecha_ingreso;
        $servicio_inicio_sintomas = $formulario->servicio_inicio_sintomas;
        $servicio_notificador = $formulario->servicio_notificador;
        $diagnostico_ingreso = $formulario->diagnostico_ingreso;
        $diagnostico_sala = $formulario->diagnostico_sala;
        $uso_antimicrobanos = $formulario->uso_antimicrobanos;
        $tipo_muestra_cultivo = $formulario->tipo_muestra_cultivo;
        $procedimiento_invasivo = $formulario->procedimiento_invasivo;
        $medidas_tomar = $formulario->medidas_tomar;
        $aislamiento = $formulario->aislamiento;
        $seguimiento = $formulario->seguimiento;
        $observacion = $formulario->observacion;

        // Obtener la fecha y hora actual en horario de Bolivia
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');

        $data = [
            'h_clinico' => $h_clinico,
            'nombreP' => DatoPaciente::where('n_h_clinico',$h_clinico)->first(),
            'fecha_llenado' => $fecha_llenado,
            'fecha_ingreso' => $fecha_ingreso,
            'servicio_inicio_sintomas' => Servicio::where('cod_servicio',$servicio_inicio_sintomas)->first(),
            'servicio_notificador' => Servicio::where('cod_servicio',$servicio_notificador)->first(),
            'diagnostico_ingreso' => $diagnostico_ingreso,
            'diagnostico_sala' => $diagnostico_sala,
            'nombresTiposInfeccion' => $nombresTiposInfeccion,
            'uso_antimicrobanos' => $uso_antimicrobanos,
            'tipo_muestra_cultivo' => TipoMuestra::where('cod_tipo_muestra',$tipo_muestra_cultivo)->first(),
            'procedimiento_invasivo' => ProcedimientoInmasivo::where('cod_procedimiento_invasivo',$procedimiento_invasivo)->first(),
            'datosAntibiograma' => $datosAntibiograma,
            'medidas_tomar' => $medidas_tomar,
            'aislamiento' => $aislamiento,
            'seguimiento' => $seguimiento,
            'observacion' => $observacion,
            'fechaHoraActual'  => $fechaHoraActual,
        ];

            // Generar el contenido del PDF a partir de la vista del formulario
            $pdf = PDF::loadView('Form_IAAS.PDF.form_IAAS', $data);
            return $pdf->stream();
    }

    public function eliminarFormulario($codigoFormulario)
    {
        // Buscar el formulario por el código
        $formulario = FormularioNotificacionPaciente::find($codigoFormulario);

        if (!$formulario) {
            return redirect()->back()->with('error', 'No se encontró el formulario solicitado.');
        }

        // Eliminar registros relacionados en ANTIBIOGRAMA
        Antibiograma::where('cod_formulario', $codigoFormulario)->delete();

        // Eliminar registros relacionados en SELECCION_TIPO_INFECCION
        SeleccionTipoInfeccion::where('cod_formulario', $codigoFormulario)->delete();

        // Eliminar el formulario y sus registros relacionados en FORMULARIO_NOTIFICACION_PACIENTE
        $formulario->delete();

        return redirect()->back()->with('success', 'Formulario y registros relacionados eliminados exitosamente.');
    }

    public function generarReporte(Request $request)
    {
        // Obtener el mes y año seleccionados del formulario
        $fechaSeleccionada = $request->fecha;
        $mesSeleccionado = Carbon::parse($fechaSeleccionada)->month;
        $nombreMesSeleccionado = Carbon::parse($fechaSeleccionada)->locale('es')->monthName;
        $anioSeleccionado = Carbon::parse($fechaSeleccionada)->year;

        // Calcular la fecha inicial y final del mes seleccionado
        $fechaInicial = Carbon::create($anioSeleccionado, $mesSeleccionado, 1)->startOfMonth();
        $fechaFinal = Carbon::create($anioSeleccionado, $mesSeleccionado, 1)->endOfMonth();

        // Consultar los registros para el mes seleccionado
        $registros = DB::table('epidemiologia.formulario_notificacion_paciente as f')
            ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
            ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                $join->on('a.cod_medi', '=', 'bm.cod_medi');
            })
            ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
            ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
            ->whereBetween('f.fecha_llenado', [$fechaInicial, $fechaFinal])
            ->select(
                'f.cod_form_notificacion_p',
                'b.nombre as bacteria',
                'm.nombre as medicamento',
                'a.nivel'
            )->orderBy('bacteria','desc')
            ->get();

        $estadisticas = [];

        foreach ($registros as $registro) {
            $bacteria = $registro->bacteria;
            $medicamento = $registro->medicamento;
            $nivel = $registro->nivel;

            if (!isset($estadisticas[$bacteria][$medicamento])) {
                $estadisticas[$bacteria][$medicamento] = [
                    'Resistente' => 0,
                    'Intermedio' => 0,
                    'Sensible' => 0,
                ];
            }

            $estadisticas[$bacteria][$medicamento][$nivel]++;
        }
        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');

        $data = compact('estadisticas', 'nombreMesSeleccionado', 'anioSeleccionado','fechaHoraActual');
        $pdf = PDF::loadview('Form_IAAS.PDF.reporte', $data);


        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true);
        $pdf->getDomPDF()->set_option('isPhpEnabled', true);

        // Establecer tamaño y orientación de página
        $pdf->getDomPDF()->set_paper('A4', 'portrait');


        // nombre personalizado para descargar con un nombre predeterminado
        $nombreArchivo = 'Reporte_IAAS_' . $nombreMesSeleccionado . '_' . $anioSeleccionado . '.pdf';
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }

}
