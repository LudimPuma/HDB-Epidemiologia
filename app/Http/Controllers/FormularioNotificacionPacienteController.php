<?php

namespace App\Http\Controllers;
use SnappyPDF;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Dompdf\Options;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Antibiograma;
use App\SeleccionTipoInfeccion;
use App\DatoPaciente;
use App\Servicio;
use App\TipoInfeccion;
use App\ProcedimientoInmasivo;
use App\Hongo;
use App\User;
use App\SeleccionHongos;
use App\TipoMuestra;
use App\Bacteria;
use App\Medicamento;
use App\FormularioNotificacionPaciente;
use Intervention\Image\ImageManagerStatic as Image;
class FormularioNotificacionPacienteController extends Controller
{
    public function __construct(){
        $this->middleware('can:create-form-iaas')->only('showViewForm');
        $this->middleware('can:create-form-iaas')->only('searchHistorial');
        $this->middleware('can:create-form-iaas')->only('mostrarFormulario');
        $this->middleware('can:create-form-iaas')->only('guardarDatos');
        $this->middleware('can:button-form-iaas-table')->only('tabla');
        $this->middleware('can:button-form-pdf-iaas')->only('generarPDF');
        $this->middleware('can:button-form-reports-iaas')->only('generarReporte');
        $this->middleware('can:button-form-reports-iaas')->only('reporteAnual');
        $this->middleware('can:button-form-reports-iaas')->only('reporteIAASTrimestralSemestralServicio');
        $this->middleware('can:button-form-reports-iaas')->only('reporteAnualPorMes');
        $this->middleware('can:button-form-reports-iaas')->only('reporteRango');
        $this->middleware('can:edit-form-iaas')->only('update');
        $this->middleware('can:button-form-informe-iaas')->only('informeAnual');
        $this->middleware('can:button-form-informe-iaas')->only('informeTrimestralSemestralIAASEspecifico');
    }
    private function Servidor()
    {
        $serverName = "DESKTOP-NP5BU8U";
        // $serverName = "193.168.0.7\\SIAF";
        $connectionInfo = array("Database" => "BDEstadistica", "UID" => "sa", "PWD" => "S1af");

        $conn = sqlsrv_connect($serverName, $connectionInfo);

        if (!$conn) {
            throw new \Exception("Error de conexión: " . print_r(sqlsrv_errors(), true));
        }

        return $conn;
    }
    public function showViewForm()
    {
        return view('Form_IAAS.view_form_1')->with('success', session('success'));
    }
    public function searchHistorial(Request $request)
    {
        try {
            $patientId = $request->input('patientId');
            $conn = $this->Servidor();

            $sql = "SELECT
                    HCL_APPAT,
                    HCL_APMAT,
                    HCL_NOMBRE,
                    HCL_SEXO,
                    HCL_FECNAC,
                    YEAR(HCL_FECNAC) as yearOfBirth,
                    MONTH(HCL_FECNAC) as monthOfBirth,
                    DAY(HCL_FECNAC) as dayOfBirth,
                    DATEDIFF(YEAR, HCL_FECNAC, GETDATE()) as age
                FROM
                    SE_HC
                WHERE
                    HCL_CODIGO= $patientId";

            $res = sqlsrv_query($conn, $sql);

            if ($res === false) {
                throw new \Exception("Error de consulta: " . print_r(sqlsrv_errors(), true));
            }

            $patients = [];

            while ($row = sqlsrv_fetch_array($res)) {
                $sexo = ($row['HCL_SEXO'] == 1) ? 'Masculino' : 'Femenino';
                $fechaNacimiento = $row['HCL_FECNAC'];
                $patient = [
                    'nombre' => $row['HCL_NOMBRE'],
                    'ap_paterno' => $row['HCL_APPAT'],
                    'ap_materno' => $row['HCL_APMAT'],
                    'edad' => $row['age'],
                    'sexo' => ($row['HCL_SEXO'] == 1) ? 'Masculino' : 'Femenino',
                ];
                $patients[] = $patient;
            }

            sqlsrv_close($conn);

            return response()->json([
                'found' => !empty($patients),
                'patientData' => $patients,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function mostrarFormulario(Request $request)
    {
        $id = $request->query('patientId');
        $nombre = $request->query('nombreCompleto');
        $datosPacientes = DatoPaciente::all();
        $servicios = Servicio::where('estado', true)->orderBy('nombre', 'asc')->get();
        $tiposInfeccion = TipoInfeccion::where('estado', true)->orderBy('nombre', 'asc')->get();
        $hongos = Hongo::where('estado', true)->orderBy('nombre', 'asc')->get();
        $procedimientosInmasivos = ProcedimientoInmasivo::where('estado', true)->orderBy('nombre', 'asc')->get();
        $tiposMuestra = TipoMuestra::where('estado', true)->orderBy('nombre', 'asc')->get();
        $bacterias = Bacteria::where('estado',true)->orderBy('nombre', 'asc')->get();
        $fechaActual = Carbon::now('America/La_Paz')->format('Y-m-d');
        return view('Form_IAAS.formulario_IAAS', compact('id','nombre', 'datosPacientes', 'bacterias','servicios', 'tiposInfeccion', 'hongos','procedimientosInmasivos', 'tiposMuestra','fechaActual'));
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
        try{
            $request->validate([
                'h_clinico' => 'required|only_numbers',
                'fecha_llenado' => 'required|numbers_with_dash',
                'fecha_ingreso' => 'required|numbers_with_dash',
                'fecha_egreso' => 'required|numbers_with_dash',
                'dias_internacion' => ['required','only_numbers','min:1'],
                'diagnostico_egreso' => 'required|letters_dash_spaces_dot',
                'servicio_inicio_sintomas' => 'required|only_numbers',
                'servicio_notificador' => 'required|only_numbers',
                'diagnostico_ingreso' => 'required|letters_dash_spaces_dot',
                'diagnostico_sala' => 'required|letters_dash_spaces_dot',
                'uso_antimicrobanos' => 'required|in:si,no',
                'tipo_muestra_cultivo' => 'required|only_numbers',
                'procedimiento_invasivo' => 'required|only_numbers',
                'medidas_tomar' => 'required|letters_dash_spaces_dot',
                'aislamiento' => 'required|in:si,no',
                'seguimiento' => 'required|letters_dash_spaces_dot',
                // 'observacion' => 'required|letters_dash_spaces_dot',
                'informacion_bacterias_input' => 'required',
                'infecciones_seleccionadas'=> 'required',
            ],
            [
                'h_clinico.required'=> 'El Nro. Clinico no puede estar vacio',
                'h_clinico.only_numbers'=> 'El Nro. Clinico solo incluye numeros',
                'fecha_llenado.required'=> 'La fecha de llenado no puede estar vacio',
                'fecha_llenado.numbers_with_dash'=> 'No es un formato de fecha',
                'fecha_ingreso.required'=> 'La fecha de ingreso del paciente no puede estar vacio',
                'fecha_ingreso.numbers_with_dash'=> 'No es un formato de fecha',
                'fecha_egreso.required'=> 'La fecha de egreso del paciente no puede estar vacio',
                'fecha_egreso.numbers_with_dash'=> 'No es un formato de fecha',
                'dias_internacion.required' => 'El campo es obligatorio',
                'dias_internacion.only_numbers' => 'Solo es permitido números.',
                'dias_internacion.min' => 'El valor mínimo permitido es 1.',
                'diagnostico_egreso.required' => 'El campo es obligatorio',
                'diagnostico_egreso.letters_dash_spaces_dot' => 'El diagnostico de egreso solo puede incluir letras, números, espacios, - y .',
                'servicio_inicio_sintomas.required'=> 'El servicio de inicio de sintomas no puede estar vacio',
                'servicio_inicio_sintomas.only_numbers'=> 'No se permiten esos caracteres',
                'servicio_notificador.required'=> 'El servicio notificador no puede estar vacio',
                'servicio_notificador.only_numbers'=> 'No se permiten esos caracteres',
                'diagnostico_ingreso.required' => 'El diagnostico de ingreso no puede estar vacio',
                'diagnostico_ingreso.letters_dash_spaces_dot' => 'El diagnostico de ingreso solo puede incluir letras, números, espacios, - y .',
                'diagnostico_sala.required' => 'El diagnostico de sala no puede estar vacio',
                'diagnostico_sala.letters_dash_spaces_dot' => 'El diagnostico de sala solo puede incluir letras, números, espacios, - y .',
                'uso_antimicrobanos.required'=> 'Este campo no puede estar vacio',
                'uso_antimicrobanos.in' => 'El valor debe ser "si" o "no".',
                'tipo_muestra_cultivo.required'=> 'Tipo de muestra cultivo no puede estar vacio',
                'tipo_muestra_cultivo.only_numbers'=> 'Caracteres no permitidos',
                'procedimiento_invasivo.required'=> 'Procedimiento invasivo no puede estar vacio',
                'procedimiento_invasivo.only_numbers'=> 'Caracteres no permitidos',
                'medidas_tomar.required'=> 'Medidas a tomar no puede estar vacio',
                'medidas_tomar.letters_dash_spaces_dot'=> 'Medidas a tomar solo puede incluir letras, números, espacios, - y .',
                'aislamiento.required'=> 'No puede estar vacio',
                'aislamiento.in' => 'El valor debe ser "si" o "no".',
                'seguimiento.required' => 'No puede estar vacio',
                'seguimiento.letters_dash_spaces_dot' => 'El seguimineto solo puede incluir letras, números, espacios, - y .',
                // 'observacion.required'=> 'La observacion no puede estar vacio',
                // 'observacion.letters_dash_spaces_dot'=> 'La observacion solo puede incluir letras, números, espacios, - y .',
            ]
            );
            // Crear una nueva instancia del modelo FormularioNotificacionPaciente
            $formulario = new FormularioNotificacionPaciente();
            // Asignar los valores de los campos del formulario al modelo
            $formulario->h_clinico = $request->input('h_clinico');
            $formulario->fecha_llenado = $request->input('fecha_llenado');
            $formulario->fecha_ingreso = $request->input('fecha_ingreso');
            $formulario->fecha_egreso = $request->input('fecha_egreso');
            $formulario->dias_internacion = $request->input('dias_internacion');
            $formulario->muerte = $request->input('muerte');
            $formulario->servicio_inicio_sintomas = $request->input('servicio_inicio_sintomas');
            $formulario->servicio_notificador = $request->input('servicio_notificador');
            $formulario->diagnostico_ingreso = $request->input('diagnostico_ingreso');
            $formulario->diagnostico_sala = $request->input('diagnostico_sala');
            $formulario->diagnostico_egreso = $request->input('diagnostico_egreso');
            $formulario->uso_antimicrobanos = $request->input('uso_antimicrobanos');
            $formulario->tipo_muestra_cultivo = $request->input('tipo_muestra_cultivo');
            $formulario->procedimiento_invasivo = $request->input('procedimiento_invasivo');
            $formulario->medidas_tomar = $request->input('medidas_tomar');
            $formulario->aislamiento = $request->input('aislamiento');
            $formulario->seguimiento = $request->input('seguimiento');
            // $formulario->observacion = $request->input('observacion');
            $formulario->estado = 'alta';
            $formulario->pk_usuario = Auth::id();

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

            //TABLA TIPO HONGO
            // Obtener las infecciones seleccionadas del campo oculto
            $hongosSeleccionados = $request->input('hongos_seleccionados');

            // Decodificar el JSON y procesar las infecciones seleccionadas
            $hongosSeleccionados = json_decode($hongosSeleccionados);

            // Crear una instancia de seleccionHongo para cada infección seleccionada
            foreach ($hongosSeleccionados as $idH) {
                $seleccionHongo = new SeleccionHongos();
                $seleccionHongo->cod_formulario = $codigoFormulario;
                $seleccionHongo->h_cli = $request->input('h_clinico');
                $seleccionHongo->id_hongos = $idH;
                $seleccionHongo->save();
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

            return view('Form_IAAS.view_form_1')->with('success', 'Los datos han sido guardados exitosamente.');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error al insertar usuario. Detalles: ' . $e->getMessage()]);
        }

    }
     //MODIFICAR ESTADO
    // public function update(Request $request, FormularioNotificacionPaciente $formulario)
    // {
    //     $request->validate([
    //         'estado' => 'in:alta,baja',
    //         'observacion' => 'letters_dash_spaces_dot',
    //     ]);

    //     $data = [
    //         'estado' => $request->estado,
    //         'observacion' => $request->observacion
    //     ];

    //     if ($request->estado === 'baja') {
    //         $request->validate([
    //             'motivos_baja' => 'required|letters_dash_spaces_dot',
    //         ],
    //         [
    //             'motivos_baja.required'=> 'Debe dar un motivo de baja',
    //         ]);
    //         $data['motivos_baja'] = $request->motivos_baja;
    //     } else {
    //         $data['motivos_baja'] = null;
    //     }
    //     $formulario->update($data);
    //     if ($formulario->update($data)) {
    //         $request->session()->flash('success', 'Estado actualizado exitosamente');
    //     }
    //     try {
    //         $hClinicos = FormularioNotificacionPaciente::pluck('h_clinico')->toArray();
    //         $conn = $this->Servidor();

    //         $hClinicosCondition = implode(',', $hClinicos);
    //         $sql = "SELECT
    //             HCL_CODIGO,
    //             HCL_NOMBRE,
    //             HCL_APPAT,
    //             HCL_APMAT
    //         FROM
    //             SE_HC
    //         WHERE
    //             HCL_CODIGO IN ($hClinicosCondition)";

    //         $res = sqlsrv_query($conn, $sql);

    //         if ($res === false) {
    //             throw new \Exception("Error de consulta: " . print_r(sqlsrv_errors(), true));
    //         }
    //         $patients = [];

    //         while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
    //             $formularios = FormularioNotificacionPaciente::where('h_clinico', $row['HCL_CODIGO'])
    //                 ->orderBy('cod_form_notificacion_p', 'desc')
    //                 ->get();
    //             foreach ($formularios as $formulario) {
    //                 $patient = [
    //                     'h_clinico' => $row['HCL_CODIGO'],
    //                     'nombre' => $row['HCL_NOMBRE'],
    //                     'ap_paterno' => $row['HCL_APPAT'],
    //                     'ap_materno' => $row['HCL_APMAT'],
    //                     'cod_form_notificacion_p' => null,
    //                     'fecha' => null,
    //                     'estado' => null,
    //                     'motivos_baja' => null,
    //                     'observacion' => null,
    //                 ];

    //                 $patient['cod_form_notificacion_p'] = $formulario->cod_form_notificacion_p;
    //                 $patient['fecha'] = $formulario->fecha_llenado;
    //                 $patient['estado'] = $formulario->estado;
    //                 $patient['motivos_baja'] = $formulario->motivos_baja;
    //                 $patient['observacion'] = $formulario->observacion;
    //                 $patients[] = $patient;
    //             }

    //         }
    //         array_multisort(array_column($patients, 'cod_form_notificacion_p'), SORT_DESC, $patients);
    //         sqlsrv_close($conn);

    //         return view('Form_IAAS.VistaTabla', compact('patients'));
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'error' => true,
    //             'message' => $e->getMessage(),
    //         ]);
    //     }
    // }
    public function update(Request $request, FormularioNotificacionPaciente $formulario)
    {
        $data = [
            'observacion' => $formulario->observacion,
            'estado' => $formulario->estado,
            'motivos_baja' => $formulario->motivos_baja,
        ];

        if (auth()->user()->can('edit-form-iaas-observaciones')) {
            $request->validate([
                'observacion' => 'letters_dash_spaces_dot',
            ]);

            $data['observacion'] = $request->observacion;
        }

        if (auth()->user()->can('edit-form-iaas-estado')) {
            $request->validate([
                'estado' => 'in:alta,baja',
            ]);

            if ($request->estado === 'baja') {
                $request->validate([
                    'motivos_baja' => 'required|letters_dash_spaces_dot',
                ],
                [
                    'motivos_baja.required' => 'Debe dar un motivo de baja',
                ]);

                $data['estado'] = $request->estado;
                $data['motivos_baja'] = $request->motivos_baja;
            } elseif ($request->estado === 'alta') {
                $data['estado'] = $request->estado;
                $data['motivos_baja'] = null; // o $data['motivos_baja'] = '';
            }
        }

        $formulario->update($data);
        if ($formulario->update($data)) {
            $request->session()->flash('success', 'Actualizado exitosamente');
        }
        try {
            $hClinicos = FormularioNotificacionPaciente::pluck('h_clinico')->toArray();
            $conn = $this->Servidor();

            $hClinicosCondition = implode(',', $hClinicos);
            $sql = "SELECT
                HCL_CODIGO,
                HCL_NOMBRE,
                HCL_APPAT,
                HCL_APMAT
            FROM
                SE_HC
            WHERE
                HCL_CODIGO IN ($hClinicosCondition)";

            $res = sqlsrv_query($conn, $sql);

            if ($res === false) {
                throw new \Exception("Error de consulta: " . print_r(sqlsrv_errors(), true));
            }
            $patients = [];

            while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
                $formularios = FormularioNotificacionPaciente::where('h_clinico', $row['HCL_CODIGO'])
                    ->orderBy('cod_form_notificacion_p', 'desc')
                    ->get();
                foreach ($formularios as $otherFormulario) { // Cambiado el nombre de la variable
                    $patient = [
                        'h_clinico' => $row['HCL_CODIGO'],
                        'nombre' => $row['HCL_NOMBRE'],
                        'ap_paterno' => $row['HCL_APPAT'],
                        'ap_materno' => $row['HCL_APMAT'],
                        'cod_form_notificacion_p' => null,
                        'fecha' => null,
                        'estado' => null,
                        'motivos_baja' => null,
                        'observacion' => null,
                    ];

                    $patient['cod_form_notificacion_p'] = $otherFormulario->cod_form_notificacion_p;
                    $patient['fecha'] = $otherFormulario->fecha_llenado;
                    $patient['estado'] = $otherFormulario->estado;
                    $patient['motivos_baja'] = $otherFormulario->motivos_baja;
                    $patient['observacion'] = $otherFormulario->observacion;
                    $patients[] = $patient;
                }
            }
            array_multisort(array_column($patients, 'cod_form_notificacion_p'), SORT_DESC, $patients);
            sqlsrv_close($conn);

            return view('Form_IAAS.VistaTabla', compact('patients'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function tabla()
    {
        try {
            $hClinicos = FormularioNotificacionPaciente::pluck('h_clinico')->toArray();
            if (empty($hClinicos)) {
                return view('Form_IAAS.VistaTabla', ['patients' => []]);
            }
            $conn = $this->Servidor();

            $hClinicosCondition = implode(',', $hClinicos);
            $sql = "SELECT
                HCL_CODIGO,
                HCL_NOMBRE,
                HCL_APPAT,
                HCL_APMAT
            FROM
                SE_HC
            WHERE
                HCL_CODIGO IN ($hClinicosCondition)";

            $res = sqlsrv_query($conn, $sql);

            if ($res === false) {
                // throw new \Exception("Error de consulta: " . print_r(sqlsrv_errors(), true));
                $errors = sqlsrv_errors();
                $errorMessage = "Error de consulta: ";
                foreach ($errors as $error) {
                    $errorMessage .= "SQLSTATE: " . $error['SQLSTATE'] . ", Código: " . $error['code'] . ", Mensaje: " . $error['message'] . "\n";
                }
                throw new \Exception($errorMessage);
            }
            $patients = [];

            while ($row = sqlsrv_fetch_array($res, SQLSRV_FETCH_ASSOC)) {
                $formularios = FormularioNotificacionPaciente::where('h_clinico', $row['HCL_CODIGO'])
                    ->orderBy('cod_form_notificacion_p', 'desc')
                    ->get();
                foreach ($formularios as $formulario) {
                    $patient = [
                        'h_clinico' => $row['HCL_CODIGO'],
                        'nombre' => $row['HCL_NOMBRE'],
                        'ap_paterno' => $row['HCL_APPAT'],
                        'ap_materno' => $row['HCL_APMAT'],
                        'cod_form_notificacion_p' => null,
                        'fecha' => null,
                        'estado' => null,
                        'motivos_baja' => null,
                        'observacion' => null,
                    ];

                    $patient['cod_form_notificacion_p'] = $formulario->cod_form_notificacion_p;
                    $patient['fecha'] = $formulario->fecha_llenado;
                    $patient['estado'] = $formulario->estado;
                    $patient['motivos_baja'] = $formulario->motivos_baja;
                    $patient['observacion'] = $formulario->observacion;

                    $patients[] = $patient;
                }

            }
            array_multisort(array_column($patients, 'cod_form_notificacion_p'), SORT_DESC, $patients);

            sqlsrv_close($conn);

            return view('Form_IAAS.VistaTabla', compact('patients'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
    // PDF FORMULARIO
    public function generarPDF($codigoFormulario)
    {
        $formulario = FormularioNotificacionPaciente::find($codigoFormulario);
        if (!$formulario) {
            // El formulario no existe
            return redirect()->back()->with('error', 'No se encontró el formulario solicitado.');
        }
        $cod_formulario = $formulario->cod_form_notificacion_p;
        // ---------------TIPO INFECCION---------------------------------
        $codigosTiposInfeccion = SeleccionTipoInfeccion::where('cod_formulario', $cod_formulario)
            ->pluck('cod_tipo_inf')
            ->toArray();
        $nombresTiposInfeccion = [];
        foreach ($codigosTiposInfeccion as $codTipoInf) {
            $tipoInfeccion = TipoInfeccion::find($codTipoInf);
            if ($tipoInfeccion) {
                $nombresTiposInfeccion[] = $tipoInfeccion->nombre;
            }
        }
        // -----------------------------------------------------------------------

        // ---------------TIPO HONGO---------------------------------
        $codigosTipoHongo = SeleccionHongos::where('cod_formulario', $cod_formulario)
            ->pluck('id_hongos')
            ->toArray();
        $nombresTipoHongos = [];
        foreach ($codigosTipoHongo as $idH) {
            $hongos = Hongo::find($idH);
            if ($hongos) {
                $nombresTipoHongos[] = $hongos->nombre;
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

        try {
            $conn = $this->Servidor();
            $sql = "SELECT
                    HCL_CODIGO,
                    HCL_APPAT,
                    HCL_APMAT,
                    HCL_NOMBRE,
                    HCL_SEXO,
                    HCL_FECNAC,
                    YEAR(HCL_FECNAC) as yearOfBirth,
                    MONTH(HCL_FECNAC) as monthOfBirth,
                    DAY(HCL_FECNAC) as dayOfBirth,
                    DATEDIFF(YEAR, HCL_FECNAC, GETDATE()) as age
                FROM
                    SE_HC
                WHERE
                    HCL_CODIGO IN ($formulario->h_clinico)";

            $res = sqlsrv_query($conn, $sql);

            if ($res === false) {
                throw new \Exception("Error de consulta: " . print_r(sqlsrv_errors(), true));
            }
            $patients = [];
            while ($row = sqlsrv_fetch_array($res)) {
                $sexo = ($row['HCL_SEXO'] == 1) ? 'Masculino' : 'Femenino';
                $fechaNacimiento = $row['HCL_FECNAC'];
                $patient = [
                    'hcl_codigo' => $row['HCL_CODIGO'],
                    'nombre' => $row['HCL_NOMBRE'],
                    'ap_paterno' => $row['HCL_APPAT'],
                    'ap_materno' => $row['HCL_APMAT'],
                    'edad' => $row['age'],
                    'sexo' => ($row['HCL_SEXO'] == 1) ? 'Masculino' : 'Femenino',
                ];
                $patients[] = $patient;
                // dd($patients);
                // return false;
            }

            sqlsrv_close($conn);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
        $nombreP = $patients;

        // *****************************************************************
        $h_clinico = $formulario->h_clinico;
        $fecha_llenado = $formulario->fecha_llenado;
        $fecha_ingreso = $formulario->fecha_ingreso;
        $fecha_egreso = $formulario->fecha_egreso;
        $dias_internacion = $formulario->dias_internacion;
        $muerte = $formulario->muerte;
        $servicio_inicio_sintomas = $formulario->servicio_inicio_sintomas;
        $servicio_notificador = $formulario->servicio_notificador;
        $diagnostico_ingreso = $formulario->diagnostico_ingreso;
        $diagnostico_sala = $formulario->diagnostico_sala;
        $diagnostico_egreso = $formulario->diagnostico_egreso;
        $uso_antimicrobanos = $formulario->uso_antimicrobanos;
        $tipo_muestra_cultivo = $formulario->tipo_muestra_cultivo;
        $procedimiento_invasivo = $formulario->procedimiento_invasivo;
        $medidas_tomar = $formulario->medidas_tomar;
        $aislamiento = $formulario->aislamiento;
        $seguimiento = $formulario->seguimiento;
        $observacion = $formulario->observacion;
        $usuarioCreador = $formulario->usuarioCreador();
        $nombreUsuarioCreador = $usuarioCreador->persona->nombres . ' ' . $usuarioCreador->persona->apellidos;

        $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
        $fechaActual = Carbon::now('America/La_Paz')->format('d/m/Y ');
        $data = [
            'h_clinico' => $h_clinico,
            'nombreP' => $nombreP,
            'fecha_llenado' => $fecha_llenado,
            'fecha_ingreso' => $fecha_ingreso,
            'fecha_egreso' => $fecha_egreso,
            'dias_internacion' => $dias_internacion,
            'muerte' => $muerte,
            'servicio_inicio_sintomas' => Servicio::where('cod_servicio',$servicio_inicio_sintomas)->first(),
            'servicio_notificador' => Servicio::where('cod_servicio',$servicio_notificador)->first(),
            'diagnostico_ingreso' => $diagnostico_ingreso,
            'diagnostico_sala' => $diagnostico_sala,
            'diagnostico_egreso' => $diagnostico_egreso,
            'nombresTiposInfeccion' => $nombresTiposInfeccion,
            'uso_antimicrobanos' => $uso_antimicrobanos,
            'tipo_muestra_cultivo' => TipoMuestra::where('cod_tipo_muestra',$tipo_muestra_cultivo)->first(),
            'procedimiento_invasivo' => ProcedimientoInmasivo::where('cod_procedimiento_invasivo',$procedimiento_invasivo)->first(),
            'nombresTipoHongos' => $nombresTipoHongos,
            'datosAntibiograma' => $datosAntibiograma,
            'medidas_tomar' => $medidas_tomar,
            'aislamiento' => $aislamiento,
            'seguimiento' => $seguimiento,
            'observacion' => $observacion,
            'fechaHoraActual'  => $fechaHoraActual,
            'NombreFormSave' => $nombreUsuarioCreador,
            'cargo' => User::where('id',$formulario->pk_usuario)->first(),
        ];
        $pdf = PDF::loadView('Form_IAAS.PDF.form_IAAS', $data);
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

        $nombreArchivo = 'Formulario_IAAS_' . $fechaActual . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
        ]);
    }
    //REPORTE MES
    public function generarReporte(Request $request)
    {
        try{
            $request->validate([
                'fecha' => ['required','numbers_with_dash'],
            ],
            [
                'fecha.required' =>'La fecha no puede estar vacio',
                'fecha.numbers_with_dash' => 'No corresponde a una fecha',
            ]
            );
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
                ->where('f.estado', 'alta')
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
            foreach ($estadisticas as &$bacteria) {
                foreach ($bacteria as &$medicamento) {
                    $total = array_sum($medicamento);
                    if ($total > 0) {
                        $medicamento['Resistente'] = number_format(($medicamento['Resistente'] / $total) * 100, 1);
                        $medicamento['Intermedio'] = number_format(($medicamento['Intermedio'] / $total) * 100, 1);
                        $medicamento['Sensible'] = number_format(($medicamento['Sensible'] / $total) * 100, 1);
                    }
                }
            }
            $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');

            $data = compact('estadisticas', 'nombreMesSeleccionado', 'anioSeleccionado','fechaHoraActual');
            $pdf = SnappyPDF::loadView('Form_IAAS.PDF.reporte', $data);
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

            $nombreArchivo = 'Reporte_Mensual_IAAS_' . $nombreMesSeleccionado . '_' . $anioSeleccionado . '.pdf';
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }
    }
    //REPORTE ANUAL POR SERVICIO
    public function reporteAnual(Request $request)
    {
        try{
            $request->validate([
                'a' => ['required','only_numbers']
            ],
            [
                'a.required' =>'El año no puede estar vacio',
                'a.only_numbers' => 'Solo se ingresan numeros',
            ]
            );
            $fechaSeleccionada = $request->a;
            $nombre = "Anual";
            $servicios = DB::table('epidemiologia.servicio')->get();
            $informePorServicio = [];
            foreach ($servicios as $servicio) {
                $informeServicio = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                    ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                    ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                        $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                        $join->on('a.cod_medi', '=', 'bm.cod_medi');
                    })
                    ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                    ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                    ->whereYear('f.fecha_llenado', $fechaSeleccionada)
                    ->where('f.servicio_inicio_sintomas', $servicio->cod_servicio)
                    ->where('f.estado', 'alta')
                    ->select(
                        'b.nombre as bacteria',
                        'm.nombre as medicamento',
                        DB::raw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) as casos_resistentes')
                    )
                    ->groupBy('b.nombre', 'm.nombre')
                    ->havingRaw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) > 0')
                    ->orderBy('b.nombre', 'desc')
                    ->get();

                $totalCasosResistentesPorBacteria = [];
                $currentBacteria = null;
                $currentTotalCasosResistentes = 0;

                foreach ($informeServicio as $informe) {
                    if ($informe->casos_resistentes > 0) {
                        if ($currentBacteria !== $informe->bacteria) {

                            if ($currentBacteria !== null) {
                                $totalCasosResistentesPorBacteria[$currentBacteria] = $currentTotalCasosResistentes;
                            }
                            $currentBacteria = $informe->bacteria;
                            $currentTotalCasosResistentes = 0;
                        }
                        $currentTotalCasosResistentes += $informe->casos_resistentes;
                    }
                }

                if ($currentBacteria !== null) {
                    $totalCasosResistentesPorBacteria[$currentBacteria] = $currentTotalCasosResistentes;
                }

                $informePorServicio[] = [
                    'nombre_servicio' => $servicio->nombre,
                    'informe_servicio' => $informeServicio,
                    'total_casos_resistentes_bacteria' => $totalCasosResistentesPorBacteria,
                ];
            }
            $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
            $data = [
                'fecha_select' => $fechaSeleccionada,
                'nombre' => $nombre,
                'fechaHoraActual' => $fechaHoraActual,
                'informePorServicio' => $informePorServicio,
            ];
            $pdf = PDF::loadView('Form_IAAS.PDF.reporte_anual', $data);

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
            $nombreArchivo = 'Reporte_Anual_PorServicios__IAAS_' . $fechaSeleccionada . '.pdf';
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }

    }
    //REPORTE TRIMESTRAL - SEMESTRALPOR SERVICIO
    public function reporteIAASTrimestralSemestralServicio(Request $request)
    {
        try{
            $request->validate([
                'a' => ['required','only_numbers'],
                'rango' => ['required', 'in:primer_trimestre,segundo_trimestre,tercer_trimestre,cuarto_trimestre,primer_semestre,segundo_semestre'],
            ],
            [
                'a.required' =>'El año no puede estar vacio',
                'a.only_numbers' => 'Solo se ingresan numeros',

                'rango.required' => 'El rango no puede estar vacio',
                'rango.in' => 'No es un rango permitido'
            ]
            );
            $fechaSeleccionada = $request->input('a');
            $rangoSeleccionado = $request->input('rango');
            $nombre = null;
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
            }
            else {
                return redirect()->back()->with('error', 'Trimestre no válido');
            }
            $servicios = DB::table('epidemiologia.servicio')->get();
            $informePorServicio = [];
            foreach ($servicios as $servicio) {
                $informeServicio = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                    ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                    ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                        $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                        $join->on('a.cod_medi', '=', 'bm.cod_medi');
                    })
                    ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                    ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                    ->whereBetween('f.fecha_llenado', [$inicioRango, $finRango])
                    ->where('f.estado', 'alta')
                    ->where('f.servicio_inicio_sintomas', $servicio->cod_servicio) //prueba
                    ->select(
                        'b.nombre as bacteria',
                        'm.nombre as medicamento',
                        DB::raw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) as casos_resistentes')
                    )
                    ->groupBy('b.nombre', 'm.nombre')
                    ->havingRaw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) > 0')
                    ->orderBy('b.nombre', 'desc')
                    ->get();

                $totalCasosResistentesPorBacteria = [];
                $currentBacteria = null;
                $currentTotalCasosResistentes = 0;

                foreach ($informeServicio as $informe) {
                    if ($informe->casos_resistentes > 0) {
                        if ($currentBacteria !== $informe->bacteria) {
                            if ($currentBacteria !== null) {
                                $totalCasosResistentesPorBacteria[$currentBacteria] = $currentTotalCasosResistentes;
                            }
                            $currentBacteria = $informe->bacteria;
                            $currentTotalCasosResistentes = 0;
                        }
                        $currentTotalCasosResistentes += $informe->casos_resistentes;
                    }
                }
                if ($currentBacteria !== null) {
                    $totalCasosResistentesPorBacteria[$currentBacteria] = $currentTotalCasosResistentes;
                }
                $informePorServicio[] = [
                    'nombre_servicio' => $servicio->nombre,
                    'informe_servicio' => $informeServicio,
                    'total_casos_resistentes_bacteria' => $totalCasosResistentesPorBacteria,
                ];
            }
            $data = [
                'fecha_select' => $fechaSeleccionada,
                'nombre' =>$nombre,
                'informePorServicio' => $informePorServicio,
            ];

            $pdf = PDF::loadView('Form_IAAS.PDF.reporte_anual', $data);

            $footerPath = base_path('resources/views/pdf/footer.html');
            $headerPath = base_path('resources/views/pdf/header.html');

            $pdf->setOptions([
                'orientation' => 'portrait',
                'footer-spacing' => 10,
                'margin-top' => 30,
                'header-spacing' => 10,
                'margin-bottom' => 20,
                'footer-font-size' => 12,
                'footer-html' => $footerPath,
                'header-html' => $headerPath,
            ]);

            $nombreArchivo = 'Reporte_PorServicios_'. $rangoSeleccionado .'_IAAS_' . $fechaSeleccionada .'.pdf';
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"',
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }

    }
    //REPORTE ANUAL POR MESES
    public function reporteAnualPorMes(Request $request)
    {
        try{
            $request->validate([
                'a' => ['required','only_numbers'],
            ],
            [
                'a.required' =>'El año no puede estar vacio',
                'a.only_numbers' => 'Solo se ingresan numeros',
            ]
            );
            $añoSeleccionado = $request->a;
            $fechaActual = now();
            $mesActual = $fechaActual->month;
            $informePorMes = [];
            $totalCasosPorMes = [];

            $meses = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];

            $totalCasosResistentesPorBacteria = [];

            foreach ($meses as $mesNumero => $nombreMes) {
                if ($añoSeleccionado < $fechaActual->year || ($añoSeleccionado == $fechaActual->year && $mesNumero + 1 <= $mesActual)) {
                    $informeMes = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                        ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                        ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                            $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                            $join->on('a.cod_medi', '=', 'bm.cod_medi');
                        })
                        ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                        ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                        ->whereYear('f.fecha_llenado', $añoSeleccionado)
                        ->whereMonth('f.fecha_llenado', $mesNumero + 1)
                        ->where('f.estado', 'alta')
                        ->select(
                            'b.nombre as bacteria',
                            'm.nombre as medicamento',
                            DB::raw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) as casos_resistentes')
                        )
                        ->groupBy('b.nombre', 'm.nombre')
                        ->havingRaw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) > 0')
                        ->orderBy('b.nombre', 'desc')
                        ->get();

                    $informePorMes[$nombreMes] = $informeMes;

                    $totalCasosPorMes[$nombreMes] = $informeMes->sum('casos_resistentes');

                    $totalCasosResistentesPorBacteria[$nombreMes] = [];


                    foreach ($informeMes as $informe) {
                        if (!isset($totalCasosResistentesPorBacteria[$nombreMes][$informe->bacteria])) {
                            $totalCasosResistentesPorBacteria[$nombreMes][$informe->bacteria] = 0;
                        }
                        $totalCasosResistentesPorBacteria[$nombreMes][$informe->bacteria] += $informe->casos_resistentes;
                    }
                }
            }
            $data = [
                'añoSeleccionado' => $añoSeleccionado,
                'informeMes' => $informeMes,
                'totalCasosPorMes' => $totalCasosPorMes,
                'meses' => $meses,
                'informePorMes' => $informePorMes,
            ];

            $pdf = PDF::loadView('Form_IAAS.PDF.reporte_anual_por_mes', $data);
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
                'enable-javascript' => true,
                'javascript-delay' => 1000,
                'no-stop-slow-scripts' => true,
                'enable-smart-shrinking' => true,
            ]);
            $nombreArchivo = 'Reporte_PorGestion_IAAS_(meses)_' . $añoSeleccionado . '.pdf';
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }

    }
    //REPORTE POR RANGO DE FECHAS
    public function reporteRango(Request $request)
    {
        try{
            $request->validate([
                'fecha_e' => ['required','numbers_with_dash'],
                'fecha_s' => ['required','numbers_with_dash','after_or_equal:fecha_e'],
            ],
            [
                'fecha_e.required' =>'El fecha de entrada no puede estar vacio',
                'fecha_e.numbers_with_dash' => 'No es un formato de fecha',
                'fecha_s.required' =>'El fecha de salida no puede estar vacio',
                'fecha_s.numbers_with_dash' => 'No es un formato de fecha',
                'fecha_s.after_or_equal' => 'La fecha de salida debe ser posterior o igual a la fecha de entrada',
            ]
            );

            $fechaEntrada = $request->input('fecha_e');
            $fechaSalida = $request->input('fecha_s');


            $yearEntrada = date('Y', strtotime($fechaEntrada));
            $monthEntrada = date('m', strtotime($fechaEntrada));
            $dayEntrada = date('d', strtotime($fechaEntrada));


            $yearSalida = date('Y', strtotime($fechaSalida));
            $monthSalida = date('m', strtotime($fechaSalida));
            $daySalida = date('d', strtotime($fechaSalida));

            $añoSeleccionado = date('Y', strtotime($fechaEntrada));
            $fechaActual = now();
            $mesActual = $fechaActual->month;


            $informe = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereDate('f.fecha_llenado', '>=', $fechaEntrada)
                ->whereDate('f.fecha_llenado', '<=', $fechaSalida)
                ->where('f.estado', 'alta')
                ->select(
                    'b.nombre as bacteria',
                    'm.nombre as medicamento',
                    DB::raw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) as casos_resistentes')
                )
                ->groupBy('b.nombre', 'm.nombre')
                ->havingRaw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) > 0') // Filtrar casos resistentes
                ->orderBy('b.nombre', 'desc')
                ->get();

                $totalCasosResistentes = $informe->sum('casos_resistentes');
                $totalCasosPorBacteria = $informe->groupBy('bacteria')->map(function ($item) {
                    return $item->sum('casos_resistentes');
            });

            $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
            $data = [

                'fechaHoraActual' => $fechaHoraActual,
                'informe' => $informe,
                'fechaEntrada' => $fechaEntrada,
                'fechaSalida' => $fechaSalida,
                'totalCasosResistentes' =>$totalCasosResistentes,
                'totalCasosPorBacteria' => $totalCasosPorBacteria,
            ];

            $pdf = PDF::loadView('Form_IAAS.PDF.reporte_rango_IAAS', $data);
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
            $nombreArchivo = 'Reporte_Rango:'. $fechaEntrada.'_a_' . $fechaSalida .'.pdf';
            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }

    }
    //INFORME ANUAL ESPECIFICO
    public function informeAnual(Request $request)
    {
        try{
            $request->validate([
                'a' => ['required','only_numbers'],
            ],
            [
                'a.required' =>'El año no puede estar vacio',
                'a.only_numbers' => 'Solo se ingresan numeros',
            ]
            );
            $fechaSeleccionada = $request->a;
            $nombre = "Anual";

            $bacteriasDeInteres = ['Enterococcus s.p.', 'Pseudomonas Aeruginosa' , 'Staphilococcus Aureus', 'Staphilococcus Coagulasa Neagtivo', 'Klebsiella Pneumoniae', 'Acinetobacter s.p.'];


            $informeBacterias = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereYear('f.fecha_llenado', $fechaSeleccionada)
                ->whereIn('b.nombre', $bacteriasDeInteres)
                ->where('f.estado', 'alta')
                ->select(
                    'b.nombre as bacteria',
                    'm.nombre as medicamento',
                    DB::raw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) as casos_resistentes')
                )
                ->groupBy('b.nombre', 'm.nombre')
                ->havingRaw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) > 0')
                ->orderBy('b.nombre', 'desc')
                ->get();

            $totalCasosResistentesPorBacteria = [];

            foreach ($informeBacterias as $informe) {
                if (!isset($totalCasosResistentesPorBacteria[$informe->bacteria])) {
                    $totalCasosResistentesPorBacteria[$informe->bacteria] = [
                        'total_resistentes' => 0,
                        'medicamentos' => [],
                    ];
                }

                $totalCasosResistentesPorBacteria[$informe->bacteria]['total_resistentes'] += $informe->casos_resistentes;
                $totalCasosResistentesPorBacteria[$informe->bacteria]['medicamentos'][] = $informe->medicamento;
            }

            $bacteriasEspecificas = ['Staphilococcus Coagulasa Neagtivo', 'Staphilococcus Aureus', 'Enterococcus s.p.'];

            $informeEspecifico = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereYear('f.fecha_llenado', $fechaSeleccionada)
                ->whereIn('b.nombre', $bacteriasEspecificas)
                ->whereIn('m.nombre', ['OXA', 'FOX'])
                ->where('a.nivel', 'Resistente')
                ->select(
                    'b.nombre as bacteria',
                    DB::raw('COUNT(*) as casos_resistentes')
                )
                ->groupBy('b.nombre')
                ->orderBy('b.nombre', 'desc')
                ->get();

            $bacteriasEspecificas2 = ['Escherichia coli', 'Pseudomonas aeruginosa', 'Acinetobacter s.p.'];
            $medicamentosEspecificos = ['IMP', 'MER'];

            $informeEspecifico2 = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereYear('f.fecha_llenado', $fechaSeleccionada)
                ->whereIn('b.nombre', $bacteriasEspecificas2)
                ->whereIn('m.nombre', $medicamentosEspecificos)
                ->where('a.nivel', 'Resistente')
                ->select(
                    'b.nombre as bacteria',
                    'm.nombre as medicamento',
                    DB::raw('COUNT(*) as casos_resistentes')
                )
                ->groupBy('b.nombre', 'm.nombre')
                ->orderBy('b.nombre', 'desc')
                ->get();

            $conteoCasosPorMedicamento = [];

            foreach ($medicamentosEspecificos as $medicamento) {
                foreach ($bacteriasEspecificas2 as $bacteria) {
                    $conteoCasosPorMedicamento[$bacteria][$medicamento] = $informeEspecifico2
                        ->where('bacteria', $bacteria)
                        ->where('medicamento', $medicamento)
                        ->sum('casos_resistentes');
                }
            }

            $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
            $data = [
                'fecha_select' => $fechaSeleccionada,
                'fechaHoraActual' => $fechaHoraActual,
                'total_casos_resistentes_por_bacteria' => $totalCasosResistentesPorBacteria,
                'bacteriasDeInteres' => $bacteriasDeInteres,
                'informeEspecifico' => $informeEspecifico,
                'bacteriasEspecificas' => $bacteriasEspecificas,
                'informeEspecifico2' => $informeEspecifico2,
                'bacteriasEspecificas2' => $bacteriasEspecificas2,
                'conteoCasosPorMedicamento' => $conteoCasosPorMedicamento,
                'nombre' =>$nombre,
            ];

            $pdf = PDF::loadView('Form_IAAS.PDF.informeAnual', $data);

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
            $nombreArchivo = 'Resistencia_Bacteriana_IAAS_' . $fechaSeleccionada . '.pdf';

            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }
    }
    //INFORME TRIMESTRAL-SEMESTRAL ESPECIFICO
    public function informeTrimestralSemestralIAASEspecifico(Request $request)
    {
        try{
            $request->validate([
                'a' => ['required','only_numbers'],
                'rango' => ['required', 'in:primer_trimestre,segundo_trimestre,tercer_trimestre,cuarto_trimestre,primer_semestre,segundo_semestre'],
            ],
            [
                'a.required' =>'El año no puede estar vacio',
                'a.only_numbers' => 'Solo se ingresan numeros',

                'rango.required' => 'El rango no puede estar vacio',
                'rango.in' => 'No es un rango permitido'
            ]
            );
            $fechaSeleccionada = $request->a;
            $rangoSeleccionado = $request->input('rango');
            $nombre = null;
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
            }
            else {
                return redirect()->back()->with('error', 'Trimestre no válido');
            }
            // Nombres de las bacterias
            $bacteriasDeInteres = ['Enterococcus s.p.', 'Pseudomonas Aeruginosa' , 'Staphilococcus Aureus', 'Staphilococcus Coagulasa Neagtivo', 'Klebsiella Pneumoniae', 'Acinetobacter s.p.'];

            // Obtener datos para las bacterias
            $informeBacterias = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereBetween('f.fecha_llenado', [$inicioRango, $finRango])
                ->whereIn('b.nombre', $bacteriasDeInteres)
                ->where('f.estado', 'alta')
                ->select(
                    'b.nombre as bacteria',
                    'm.nombre as medicamento',
                    DB::raw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) as casos_resistentes')
                )
                ->groupBy('b.nombre', 'm.nombre')
                ->havingRaw('SUM(CASE WHEN a.nivel = \'Resistente\' THEN 1 ELSE 0 END) > 0')
                ->orderBy('b.nombre', 'desc')
                ->get();
            // dd($informeBacterias);
            // return false;
            $totalCasosResistentesPorBacteria = [];

            foreach ($informeBacterias as $informe) {
                if (!isset($totalCasosResistentesPorBacteria[$informe->bacteria])) {
                    $totalCasosResistentesPorBacteria[$informe->bacteria] = [
                        'total_resistentes' => 0,
                        'medicamentos' => [],
                    ];
                }

                $totalCasosResistentesPorBacteria[$informe->bacteria]['total_resistentes'] += $informe->casos_resistentes;
                $totalCasosResistentesPorBacteria[$informe->bacteria]['medicamentos'][] = $informe->medicamento;
            }

            // Consulta adicional para bacterias específicas y medicamento OXA
            $bacteriasEspecificas = ['Staphilococcus Coagulasa Neagtivo', 'Staphilococcus Aureus', 'Enterococcus s.p.'];

            $informeEspecifico = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereBetween('f.fecha_llenado', [$inicioRango, $finRango])
                ->whereIn('b.nombre', $bacteriasEspecificas)
                ->whereIn('m.nombre', ['OXA', 'FOX'])
                ->where('a.nivel', 'Resistente')
                ->select(
                    'b.nombre as bacteria',
                    DB::raw('COUNT(*) as casos_resistentes')
                )
                ->groupBy('b.nombre')
                ->orderBy('b.nombre', 'desc')
                ->get();

            // Bacterias y medicamentos
            $bacteriasEspecificas2 = ['Escherichia coli', 'Pseudomonas aeruginosa', 'Acinetobacter s.p.'];
            $medicamentosEspecificos = ['IMP', 'MER'];

            $informeEspecifico2 = DB::table('epidemiologia.formulario_notificacion_paciente as f')
                ->join('epidemiologia.antibiograma as a', 'f.cod_form_notificacion_p', '=', 'a.cod_formulario')
                ->join('epidemiologia.bacterias_medicamentos as bm', function ($join) {
                    $join->on('a.cod_bacte', '=', 'bm.cod_bacte');
                    $join->on('a.cod_medi', '=', 'bm.cod_medi');
                })
                ->join('epidemiologia.bacterias as b', 'bm.cod_bacte', '=', 'b.cod_bacterias')
                ->join('epidemiologia.medicamentos as m', 'bm.cod_medi', '=', 'm.cod_medicamento')
                ->whereBetween('f.fecha_llenado', [$inicioRango, $finRango])
                ->whereIn('b.nombre', $bacteriasEspecificas2)
                ->whereIn('m.nombre', $medicamentosEspecificos)
                ->where('a.nivel', 'Resistente')
                ->select(
                    'b.nombre as bacteria',
                    'm.nombre as medicamento',
                    DB::raw('COUNT(*) as casos_resistentes')
                )
                ->groupBy('b.nombre', 'm.nombre')
                ->orderBy('b.nombre', 'desc')
                ->get();

            $conteoCasosPorMedicamento = [];

            foreach ($medicamentosEspecificos as $medicamento) {
                foreach ($bacteriasEspecificas2 as $bacteria) {
                    $conteoCasosPorMedicamento[$bacteria][$medicamento] = $informeEspecifico2
                        ->where('bacteria', $bacteria)
                        ->where('medicamento', $medicamento)
                        ->sum('casos_resistentes');
                }
            }

            $fechaHoraActual = Carbon::now('America/La_Paz')->format('d/m/Y H:i:s');
            $data = [
                'fecha_select' => $fechaSeleccionada,
                'fechaHoraActual' => $fechaHoraActual,
                'total_casos_resistentes_por_bacteria' => $totalCasosResistentesPorBacteria,
                'bacteriasDeInteres' => $bacteriasDeInteres,
                'informeEspecifico' => $informeEspecifico,
                'bacteriasEspecificas' => $bacteriasEspecificas,
                'informeEspecifico2' => $informeEspecifico2,
                'bacteriasEspecificas2' => $bacteriasEspecificas2,
                'conteoCasosPorMedicamento' => $conteoCasosPorMedicamento,
                'nombre' =>$nombre,
            ];

            $pdf = PDF::loadView('Form_IAAS.PDF.informeAnual', $data);

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
            $nombreArchivo = 'Resistencia_Bacteriana_' . $fechaSeleccionada . '_'. $rangoSeleccionado .'.pdf';

            return response($pdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $nombreArchivo . '"'
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['Error. Detalles: ' . $e->getMessage()]);
        }
    }
}
