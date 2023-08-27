@extends('layout')
@section('content')

<section class="tab-components">
<style>
#tablaMedicamentos table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
  border-collapse: collapse;
}

#tablaMedicamentos th,
#tablaMedicamentos td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;

}

#tablaMedicamentos th {
  font-weight: bold;
  background-color: #f8f9fa;
}

@media (max-width: 767.98px) {
  /* Estilos específicos para pantallas pequeñas */
  #tablaMedicamentos table {
    display: block;
    overflow-x: auto;
  }
}

.my-custom-table tbody td,
.my-custom-table tbody th {
    padding-top: 5px; /* Ajusta el valor según tu preferencia */
    padding-bottom: 5px; /* Ajusta el valor según tu preferencia */
}
.my-custom-table tbody tr {
    padding-top: 5px; /* Ajusta el valor según tu preferencia */
    padding-bottom: 5px; /* Ajusta el valor según tu preferencia */
}
</style>

{{-- ESTILOS ALERTAS --}}
<style>
    .error-field {
        border-color: red;
    }
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
    }
    </style>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
{{-- {{$errors}} --}}
    <div class="container-fluid">
        <h2>Formulario IAAS</h2>
        <div class="form-elements-wrapper">
            <form method="POST" action="{{ route('guardar_datos_form_IAAS') }}" novalidate >
                @csrf
                {{-- DATOS GENERALES --}}
                <div class="card-style mb-30">
                    <h6 class="mb-25">Datos Generales</h6>
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Nro Historial -->
                            <div class="form-group input-style-1">
                                <label for="h_clinico">N° Historial:</label>
                                <input type="text" class="form-control @error('h_clinico') is-invalid @enderror" id="h_clinico" name="h_clinico" value="{{ $id }}">
                                @error('h_clinico')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <!-- Datos paciente -->
                            <div class="form-group input-style-1">
                                <label for="dato_paciente">Nombre completo:</label>
                                <input type="text" class="form-control" id="dato_paciente" name="dato_paciente" value="{{ $nombre }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Campo para fecha_llenado -->
                            <div class="form-group input-style-1">
                                <label for="fecha_llenado">Fecha de Llenado:</label>
                                <input type="date" class="form-control @error('fecha_llenado') is-invalid @enderror" id="fecha_llenado" name="fecha_llenado" value="{{ $fechaActual }}" >
                                @error('fecha_llenado')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para fecha_ingreso -->
                            <div class="form-group input-style-1">
                                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                                <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror" id="fecha_ingreso" name="fecha_ingreso" value="{{old('fecha_ingreso')}}">
                                @error('fecha_ingreso')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <!-- Campo para servicio_inicio_sintomas -->
                            <div class="form-group select-style-1">
                                <label for="servicio_inicio_sintomas">Servicio de inicio de síntomas:</label>
                                <div class="select-position">
                                    <select class="form-control @error('servicio_inicio_sintomas') is-invalid @enderror" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas" required>
                                        <option value="">Seleccionar</option>
                                        @foreach ($servicios as $servicio)
                                            {{-- <option value="{{ $servicio->cod_servicio }}">{{ $servicio->nombre }}</option> --}}
                                            <option value="{{ $servicio->cod_servicio }}" @if(old('servicio_inicio_sintomas') == $servicio->cod_servicio) selected @endif>{{ $servicio->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('servicio_inicio_sintomas')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Campo para servicio_notificador -->
                            <div class="form-group select-style-1">
                                <label for="servicio_notificador">Servicio notificador:</label>
                                <div class="select-position">
                                    <select class="form-control @error('servicio_notificador') is-invalid @enderror" id="servicio_notificador" name="servicio_notificador">
                                        <option value="">Seleccionar</option>
                                        @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->cod_servicio }}" @if(old('servicio_notificador') == $servicio->cod_servicio) selected @endif>{{ $servicio->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('servicio_notificador')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para diagnostico_ingreso -->
                            {{-- <div class="form-group input-style-1">
                                <label for="diagnostico_ingreso">Diagnóstico de ingreso:</label>
                                <textarea class="form-control" id="diagnostico_ingreso" name="diagnostico_ingreso" ></textarea>
                            </div> --}}

                            <div class="form-group input-style-1">
                                <label for="diagnostico_ingreso">Diagnóstico de ingreso:</label>
                                <textarea class="form-control @error('diagnostico_ingreso') is-invalid @enderror " id="diagnostico_ingreso" name="diagnostico_ingreso" >{{old('diagnostico_ingreso')}}</textarea>
                                @error('diagnostico_ingreso')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para diagnostico_sala -->
                            {{-- <div class="form-group input-style-1">
                                <label for="diagnostico_sala">Diagnóstico de sala:</label>
                                <textarea class="form-control" id="diagnostico_sala" name="diagnostico_sala" ></textarea>
                            </div> --}}

                            <div class="form-group input-style-1">
                                <label for="diagnostico_sala">Diagnóstico de sala:</label>
                                <textarea class="form-control @error('diagnostico_sala') is-invalid @enderror " id="diagnostico_sala" name="diagnostico_sala">{{old('diagnostico_sala')}}</textarea>
                                @error('diagnostico_sala')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- DATOS DE LABORATORIO --}}
                <div class="card-style mb-30">
                    <h6 class="mb-25">Datos de Laboratorio</h6>
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Campo para tipo_infeccion -->
                            <div class="form-group select-style-1">
                                <label for="tipo_infeccion">Tipo de infección Hopsitalaria:</label>
                                <div class="select-position">
                                    <select class="form-control" id="tipo_infeccion" name="tipo_infeccion">
                                        <option value="">Seleccionar</option>
                                        @foreach ($tiposInfeccion as $tipoInfeccion)
                                            <option value="{{ $tipoInfeccion->cod_tipo_infeccion }}">{{ $tipoInfeccion->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <!-- Campo para uso_antimicrobanos -->
                            <div class="form-group select-style-1">
                                <label for="uso_antimicrobanos">Uso de antimicrobianos:</label>
                                <div class="select-position">
                                    <select class="form-control @error('uso_antimicrobanos') is-invalid @enderror" id="uso_antimicrobanos" name="uso_antimicrobanos" >
                                        <option value="">Seleccionar</option>
                                        <option value="si" @if(old('uso_antimicrobanos') == 'si') selected @endif>Sí</option>
                                        <option value="no" @if(old('uso_antimicrobanos') == 'no') selected @endif>No</option>
                                    </select>
                                    @error('uso_antimicrobanos')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para tipo_muestra_cultivo -->
                            <div class="form-group select-style-1">
                                <label for="tipo_muestra_cultivo">Tipo de muestra para cultivo:</label>
                                <div class="select-position">
                                    <select class="form-control @error('tipo_muestra_cultivo') is-invalid @enderror" id="tipo_muestra_cultivo" name="tipo_muestra_cultivo" >
                                        <option value="">Seleccionar</option>
                                        @foreach ($tiposMuestra as $tipoMuestra)
                                            <option value="{{ $tipoMuestra->cod_tipo_muestra }}" @if(old('tipo_muestra_cultivo') == $tipoMuestra->cod_tipo_muestra) selected @endif>{{ $tipoMuestra->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('tipo_muestra_cultivo')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <!-- Campo para procedimiento_invasivo -->
                            <div class="form-group select-style-1">
                                <label for="procedimiento_invasivo">Procedimiento invasivo:</label>
                                <div class="select-position">
                                    <select class="form-control @error('procedimiento_invasivo') is-invalid @enderror" id="procedimiento_invasivo" name="procedimiento_invasivo" >
                                        <option value="">Seleccionar</option>
                                        @foreach ($procedimientosInmasivos as $procedimientoInvasivo)
                                            <option value="{{ $procedimientoInvasivo->cod_procedimiento_invasivo }}" @if(old('procedimiento_invasivo') == $procedimientoInvasivo->cod_procedimiento_invasivo) selected @endif>{{ $procedimientoInvasivo->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('procedimiento_invasivo')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- TABLA DE TIPO INFECCION --}}
                    <div id="tablaDatosSeleccionados"></div>
                    {{-- INPUT INVISIBLE QUE ALMACENA LOS TIPOS DE INFECCION --}}
                    <input type="hidden" id="infecciones_seleccionadas" name="infecciones_seleccionadas" >

                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Desplegable para seleccionar bacterias -->
                            <div class="form-group select-style-1">
                                <label for="bacteria">Bacteria:</label>
                                <div class="select-position">
                                    <select class="form-control" id="bacteria" name="bacteria" onchange="cargarMedicamentos()">
                                        <option value="">Seleccione una bacteria</option>
                                        @foreach ($bacterias as $bacteria)
                                            <option value="{{ $bacteria->cod_bacterias }}">{{ $bacteria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- INPUT OCULTO QUE ALMACENA LA INFORMACION DEL ANTIBIOGRAMA --}}
                        <input type="hidden" id="informacion_bacterias_input" name="informacion_bacterias_input">
                        {{-- <div>
                            <p id="conteoMedicamentos">Cantidad de medicamentos para esta bacteria: 0</p>
                        </div>
                        <div class="col-lg-4">
                            <!-- Desplegable para seleccionar medicamentos -->
                            <div class="form-group">
                                <label for="medicamento">Medicamento:</label>
                                <select id="medicamento" name="medicamento " >
                                    <option value="">Seleccione una bacteria primero</option>
                                </select>
                            </div>
                        </div> --}}
                        <div id="tablaDatosGuardados"></div>

                    </div>
                </div>
                {{-- DATOS EPIDEMIOLOGICOS --}}
                <div class="card-style mb-30">
                    <h6 class="mb-25">Datos Epidemiologico</h6>
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Campo para medidas_tomar -->
                            <div class="form-group input-style-1">
                                <label for="medidas_tomar">Medidas a tomar:</label>
                                <textarea class="form-control @error('medidas_tomar') is-invalid @enderror" id="medidas_tomar" name="medidas_tomar" >{{old('diagnostico_sala')}}</textarea>
                                @error('medidas_tomar')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para aislamiento -->
                            <div class="form-group select-style-1">
                                <label for="aislamiento">Aislamiento:</label>
                                <div class="select-position">
                                    <select class="form-control  @error('aislamiento') is-invalid @enderror" id="aislamiento" name="aislamiento" >
                                        <option value="">Seleccionar</option>
                                        <option value="si" @if(old('aislamiento') == 'si') selected @endif>Sí</option>
                                        <option value="no" @if(old('aislamiento') == 'no') selected @endif>No</option>
                                    </select>
                                    @error('aislamiento')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para seguimiento -->
                            <div class="form-group input-style-1">
                                <label for="seguimiento">Seguimiento:</label>
                                <textarea class="form-control @error('seguimiento') is-invalid @enderror" id="seguimiento" name="seguimiento" >{{old('seguimiento')}}</textarea>
                                @error('seguimiento')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Campo para observacion -->
                            <div class="form-group input-style-1">
                                <label for="observacion">Observación:</label>
                                <textarea class="form-control @error('observacion') is-invalid @enderror" id="observacion" name="observacion" >{{old('observacion')}}</textarea>
                                @error('observacion')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Guardar" class="btn btn-primary">
                {{-- <button type="submit" class="btn btn-primary">Guardar</button> --}}
            </form>
        </div>
    </div>


<!-- Modal para mostrar el nombre de la bacteria y la tabla de medicamentos -->
<div class="modal fade" id="bacteriaModal" tabindex="-1" role="dialog" aria-labelledby="bacteriaModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bacteriaModalLabel"></h5> <!-- Cambiado el título aquí -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="tablaMedicamentosModal"></div> <!-- Nuevo div para la tabla -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnGuardar" data-bs-dismiss="modal">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
{{-- SCRIPT PRUEBA --}}
<script>
    $(document).ready(function () {
        $('form').submit(function (event) {
            // Verificar si los campos ocultos están vacíos
            if ($('#informacion_bacterias_input').val() === '' && $('#infecciones_seleccionadas').val() === '') {
                event.preventDefault(); // Evitar el envío del formulario
                // Mostrar una alerta de Bootstrap
                Swal.fire({
                    icon: 'error',
                    title: 'Campos vacíos',
                    text: 'Los campos: "Tipo Infeccion Hospitalaria" y "Bacteria" no pueden ser guardados vacíos.',
                });
            }
        });
    });
</script>


{{-- SCRIPT MODAL --}}
<script>
    var bacteriaSeleccionada;
    // Cuando el documento está listo
    $(document).ready(function() {
        // Obtener el select de las bacterias
        var selectBacterias = $('#bacteria');

        // Cuando se cambia la opción seleccionada en el select
        selectBacterias.on('change', function() {
            // Obtener el nombre de la bacteria seleccionada
            bacteriaSeleccionada = selectBacterias.find('option:selected').text();

            // Cambiar el título del modal
            $('#bacteriaModalLabel').text('Antibiograma: ' + bacteriaSeleccionada);

            // Abrir el modal
            $('#bacteriaModal').modal('show');

            // Cargar los medicamentos para la bacteria seleccionada
            cargarMedicamentos();
        });
    });
</script>

{{-- SCRIPT COMPLETO PARA ABRIR EL MODAL CON LOS MEDICAMENTOS DE CADA BACTERIA, CREAR LA TABLA DINAMICA Y ELIMINAR SI ES NECESARIO DE LA TABLA DINAMICA--}}
<script>

    var medicamentosSeleccionados = {};
    var informacionBacterias = {};
    var medicamentosSeleccionadosPK = {};
    var bacteriaMedicamentoRelacionado = {}; // Variable global para almacenar la relación entre bacteria y medicamentos

    var medicamentosSeleccionadosGlobal = [];
    var bacteriasSeleccionadasGlobal = [];
    var bacteriaSeleccionadaPK;
    var nombresBacterias = {};
    var nombresMedicamentos = {};
    function cargarMedicamentos() {
        var bacteriaSelect = document.getElementById('bacteria');
        var bacteriaId = document.getElementById('bacteria').value;
        // var medicamentoSelect = document.getElementById('medicamento');
        // var conteoMedicamentos = document.getElementById('conteoMedicamentos');
        var nombreBacteriaModal = document.getElementById('nombreBacteriaModal');
        //medicamentoSelect.innerHTML = '<option value="">Cargando medicamentos...</option>';
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "{{url('obtener-medicamentos')}}/" + bacteriaId,
            type: 'POST',
            data: {
                    bacteriaId,
                    _token: csrfToken // Agrega el token CSRF
            },
            success: function(data) {
                //medicamentoSelect.innerHTML = '<option value="">Seleccione un medicamento</option>';

            // console.log(data.medicamentos);
                data.medicamentos.forEach(function(medicamento) {
                    var option = document.createElement('option');
                    option.value = medicamento.cod_medicamento;
                    option.textContent = medicamento.nombre;
                    //medicamentoSelect.appendChild(option);

                    });

                    // Almacenar la PK de la bacteria seleccionada
                    bacteriaSeleccionadaPK = bacteriaId;
                    // Crear objetos de mapeo para medicamentos y bacterias

                    data.medicamentos.forEach(function (medicamento) {
                        nombresMedicamentos[medicamento.cod_medicamento] = medicamento.nombre;
                    });


                    data.bacterias.forEach(function (bacteria) {
                        nombresBacterias[bacteria.cod_bacterias] = bacteria.nombre;
                    });

                // });

                // Mostrar el conteo de medicamentos
                //conteoMedicamentos.textContent = 'Cantidad de medicamentos para esta bacteria: ' + data.medicamentos.length;
                medicamentosSeleccionadosGlobal = data.medicamentos;
                bacteriasSeleccionadasGlobal = data.bacterias;

                var tablaHTML = generarTablaMedicamentos(data.medicamentos);
                $('#tablaMedicamentosModal').html(tablaHTML); // Asignar la tabla al div dentro del modal
                bacteriaSelect.value = '';

         }
          });
    }

    function generarTablaMedicamentos(medicamentos) {
    var tablaHTML = '<table class="table table-bordered my-custom-table" style="text-align: center; border-collapse: collapse;">';
    tablaHTML += '<thead class="table-primary"><tr><th>Medicamento</th><th>Nivel de Resistencia</th></tr></thead>';
    tablaHTML += '<tbody>';

    // Agregar filas para cada medicamento
    medicamentos.forEach(function(medicamento, indexMedicamento) {
        tablaHTML += '<tr>';
        tablaHTML += '<td>' + medicamento.nombre + '</td>';
        tablaHTML += '<td>';
        tablaHTML += '<select class="nivel-select-small" id="nivel-' + medicamento.cod_medicamento + '">';
        // tablaHTML += '<select class="nivel-select-small ">';
        tablaHTML += '<option value="" >Seleccione un nivel</option>';
        tablaHTML += '<option value="Resistente">Resistente</option>';
        tablaHTML += '<option value="Intermedio">Intermedio</option>';
        tablaHTML += '<option value="Sensible">Sensible</option>';
        tablaHTML += '</select>';
        tablaHTML += '</td>';
        tablaHTML += '</tr>';
    });

    tablaHTML += '</tbody>';
    tablaHTML += '</table>';

    return tablaHTML;
    }




    $('#btnGuardar').click(function () {
        var medicamentosSeleccionados = {};

        var rows = document.getElementById('tablaMedicamentosModal').getElementsByTagName('tr');
    for (var i = 1; i < rows.length; i++) {
            var medicamento = medicamentosSeleccionadosGlobal[i - 1];
            var nivelSelect = rows[i].querySelector('.nivel-select-small');
            var nivelSeleccionado = nivelSelect.value;

            if (nivelSeleccionado !== "") {
                // Guardar directamente la PK del medicamento en lugar del nombre
                medicamentosSeleccionados[medicamento.cod_medicamento] = nivelSeleccionado;
            }
        }

        // Almacena los medicamentos seleccionados para la bacteria actual
        informacionBacterias[bacteriaSeleccionadaPK] = medicamentosSeleccionados;

        // Actualiza bacteriaMedicamentoRelacionado solo con los medicamentos seleccionados
        if (!bacteriaMedicamentoRelacionado[bacteriaSeleccionadaPK]) {
            bacteriaMedicamentoRelacionado[bacteriaSeleccionadaPK] = {};
        }

        Object.keys(medicamentosSeleccionados).forEach(function (codMedicamento) {
            var nivel = medicamentosSeleccionados[codMedicamento];

            bacteriaMedicamentoRelacionado[bacteriaSeleccionadaPK][codMedicamento] = {
                nivel: nivel
            };
        });

        // Llamar a generarTablaBacterias después de actualizar la variable
        var tablaHTML = generarTablaBacterias(informacionBacterias);
        $('#tablaDatosGuardados').html(tablaHTML);
        actualizarInputOculto();
    });

    // Función para generar la tabla de bacterias
    function generarTablaBacterias(informacionBacterias) {
        var tablaHTML = '<table class="table table-bordered my-custom-table" style="text-align: center; border-collapse: collapse;">';
        tablaHTML += '<thead class="table-primary"><tr><th>Bacterias</th><th>Medicamento</th><th>Nivel de Resistencia</th><th>Opciones</th></tr></thead>';
        tablaHTML += '<tbody>';

        Object.keys(informacionBacterias).forEach(function (bacteriaPK) {
            var medicamentosSeleccionados = informacionBacterias[bacteriaPK];
            var bacteriaRows = countBacteriaRows(medicamentosSeleccionados);

            tablaHTML += '<tr>';
            tablaHTML += '<td rowspan="' + bacteriaRows + '">' + convertirPKANombre(bacteriaPK, 'bacteria') + '</td>';

            var primeraFila = true;

            Object.keys(medicamentosSeleccionados).forEach(function (medicamentoPK) {
                if (!primeraFila) {
                    tablaHTML += '<tr>';
                }

                tablaHTML += '<td>' + convertirPKANombre(medicamentoPK, 'medicamento') + '</td>';
                tablaHTML += '<td>' + medicamentosSeleccionados[medicamentoPK] + '</td>';

                if (primeraFila) {
                    tablaHTML += '<td rowspan="' + bacteriaRows + '"><button class="btn btn-danger btn-sm" onclick="eliminarBacteria(\'' + bacteriaPK + '\')"><i class="lni lni-trash-can"></i></button></td>';
                    primeraFila = false;
                }

                tablaHTML += '</tr>';
            });
        });

        tablaHTML += '</tbody>';
        tablaHTML += '</table>';
        console.log(informacionBacterias);
        return tablaHTML;
    }
    function countBacteriaRows(medicamentosSeleccionados) {
        return Object.keys(medicamentosSeleccionados).length;
    }

    $('#tablaDatosGuardados').on('click', '.lni-trash-can', function () {
        var bacteriaAEliminar = $(this).data('bacteria');
        eliminarBacteria(bacteriaAEliminar);
    });

    function eliminarBacteria(bacteria) {
        delete informacionBacterias[bacteria];
        // console.log(informacionBacterias);
        var tablaHTML = generarTablaBacterias(informacionBacterias);
        $('#tablaDatosGuardados').html(tablaHTML);
        actualizarInputOculto();
    }

    // Función para convertir PK a nombres
    function convertirPKANombre(pk, tipo) {
        var nombres = tipo === 'bacteria' ? nombresBacterias : nombresMedicamentos;
        return nombres[pk] || 'Nombre no encontrado';
    }
    // Función para actualizar el input oculto con la información actualizada
    function actualizarInputOculto() {
        var informacionAntibiogramaArray = [];

        Object.keys(informacionBacterias).forEach(function (bacteriaPK) {
            var medicamentosSeleccionados = informacionBacterias[bacteriaPK];

            Object.keys(medicamentosSeleccionados).forEach(function (medicamentoPK) {
                var nivel = medicamentosSeleccionados[medicamentoPK];
                informacionAntibiogramaArray.push([bacteriaPK, medicamentoPK, nivel]);
            });
        });

        // Construir la cadena de datos actualizada
        var informacionAntibiogramaString = informacionAntibiogramaArray.map(function(registro) {
            return registro.join(",");
        }).join("\n");

        // Actualizar el valor del input oculto
        $('#informacion_bacterias_input').val(informacionAntibiogramaString);
    }

</script>



{{-- TABLA TIPO INFECCION --}}
<script>
    $('#tipo_infeccion').on('change', function () {
        var infeccionSeleccionada = $(this).val();
        if (infeccionSeleccionada) {
            agregarInfeccionTabla(infeccionSeleccionada);
        }
    });

    var infeccionesSeleccionadas = [];
    var tiposInfeccionMap = {};

    @foreach ($tiposInfeccion as $tipoInfeccion)
        tiposInfeccionMap["{{ $tipoInfeccion->cod_tipo_infeccion }}"] = "{{ $tipoInfeccion->nombre }}";
    @endforeach

    function agregarInfeccionTabla(infeccion) {
        if (!infeccionesSeleccionadas.includes(infeccion)) {
            infeccionesSeleccionadas.push(infeccion);
            actualizarTabla();
            // Actualizar el campo oculto con las infecciones seleccionadas
            $('#infecciones_seleccionadas').val(JSON.stringify(infeccionesSeleccionadas));
        }
    }

    function actualizarTabla() {
        var tablaHTML = '<table class="table table-bordered my-custom-table" style="text-align: center; border-collapse: collapse;">';
        tablaHTML += '<thead class="table-primary"><tr><th>Tipo de Infección</th><th>Opciones</th></tr></thead>';
        tablaHTML += '<tbody>';

        infeccionesSeleccionadas.forEach(function (infeccion) {
            var nombreInfeccion = tiposInfeccionMap[infeccion];
            tablaHTML += '<tr>';
            tablaHTML += '<td>' + nombreInfeccion + '</td>';
            tablaHTML += '<td><button class="btn btn-danger btn-sm" onclick="eliminarInfeccion(\'' + infeccion + '\')"><i class="lni lni-trash-can"></i></button></td>';
            tablaHTML += '</tr>';
        });

        tablaHTML += '</tbody>';
        tablaHTML += '</table>';

        $('#tablaDatosSeleccionados').html(tablaHTML);
        $('#infecciones_seleccionadas').val(JSON.stringify(infeccionesSeleccionadas));
        console.log(infeccionesSeleccionadas);
    }

    function eliminarInfeccion(infeccion) {
        var index = infeccionesSeleccionadas.indexOf(infeccion);
        if (index !== -1) {
            infeccionesSeleccionadas.splice(index, 1);
            actualizarTabla();
        }
    }
</script>




{{-- <script>
    $(document).ready(function() {
        $("#boton_guardar").on("click", function() {
            // Realiza tu validación aquí, similar al script proporcionado

            // Si todas las validaciones son exitosas, realiza la acción de guardar
            var formData = new FormData(document.getElementById("frm_guardar_datos"));
            $.ajax({
                url: "{{ route('guardar_datos_form_IAAS') }}",
                type: "POST",
                dataType: "html",
                cache: false,
                contentType: false,
                processData: false,
                data: formData
            }).done(function(resp) {
                // Maneja la respuesta del servidor si es necesario
                // Por ejemplo, puedes mostrar un mensaje de éxito con Toastr
                toastr.success("Datos guardados exitosamente", "Éxito");
            }).fail(function() {
                // Maneja los errores si es necesario
                toastr.error("Hubo un error al guardar los datos", "Error");
            });
        });
    });
</script> --}}
@endsection

