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
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

    <div class="container-fluid">
        <h2>Formulario IAAS</h2>
        <div class="form-elements-wrapper">
            <form method="POST" action="{{ route('guardar_datos_form_IAAS') }}" target="_blank">
                @csrf
                {{-- DATOS GENERALES --}}
                <div class="card-style mb-30">
                    <h6 class="mb-25">Datos Generales</h6>
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Nro Historial -->
                            <div class="form-group input-style-1">
                                <label for="h_clinico">N° Historial:</label>
                                <input type="text" class="form-control" id="h_clinico" name="h_clinico" value="{{ $id }}">
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
                                <input type="date" class="form-control" id="fecha_llenado" name="fecha_llenado" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para fecha_ingreso -->
                            <div class="form-group input-style-1">
                                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para servicio_inicio_sintomas -->
                            <div class="form-group select-style-1">
                                <label for="servicio_inicio_sintomas">Servicio de inicio de síntomas:</label>
                                <div class="select-position">
                                    <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas">
                                        <option value="">Seleccionar</option>
                                        @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->cod_servicio }}">{{ $servicio->nombre }}</option>
                                        @endforeach
                                    </select>
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
                                    <select class="form-control" id="servicio_notificador" name="servicio_notificador">
                                        <option value="">Seleccionar</option>
                                        @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->cod_servicio }}">{{ $servicio->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para diagnostico_ingreso -->
                            <div class="form-group input-style-1">
                                <label for="diagnostico_ingreso">Diagnóstico de ingreso:</label>
                                <textarea class="form-control" id="diagnostico_ingreso" name="diagnostico_ingreso" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para diagnostico_sala -->
                            <div class="form-group input-style-1">
                                <label for="diagnostico_sala">Diagnóstico de sala:</label>
                                <textarea class="form-control" id="diagnostico_sala" name="diagnostico_sala" required></textarea>
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
                                    <select class="form-control" id="uso_antimicrobanos" name="uso_antimicrobanos" >
                                        <option value="">Seleccionar</option>
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para tipo_muestra_cultivo -->
                            <div class="form-group select-style-1">
                                <label for="tipo_muestra_cultivo">Tipo de muestra para cultivo:</label>
                                <div class="select-position">
                                    <select class="form-control" id="tipo_muestra_cultivo" name="tipo_muestra_cultivo" >
                                        <option value="">Seleccionar</option>
                                        @foreach ($tiposMuestra as $tipoMuestra)
                                            <option value="{{ $tipoMuestra->cod_tipo_muestra }}">{{ $tipoMuestra->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <!-- Campo para procedimiento_invasivo -->
                            <div class="form-group select-style-1">
                                <label for="procedimiento_invasivo">Procedimiento invasivo:</label>
                                <div class="select-position">
                                    <select class="form-control" id="procedimiento_invasivo" name="procedimiento_invasivo" >
                                        <option value="">Seleccionar</option>
                                        @foreach ($procedimientosInmasivos as $procedimientoInvasivo)
                                            <option value="{{ $procedimientoInvasivo->cod_procedimiento_invasivo }}">{{ $procedimientoInvasivo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-3">
                            <!-- Campo para agente_causal -->
                            <div class="form-group select-style-1">
                                <label for="agente_causal">Agente causal:</label>
                                <div class="select-position">
                                    <select class="form-control" id="agente_causal" name="agente_causal">
                                        <option value="">Seleccionar</option>
                                        @foreach ($agentes as $agente)
                                            <option value="{{ $agente->id }}">{{ $agente->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                    </div>
                    {{-- TABLA DE TIPO INFECCION --}}
                    <div id="tablaDatosSeleccionados"></div>
                    {{-- INPUT INVISIBLE QUE ALMACENA LOS TIPOS DE INFECCION --}}
                    <input type="hidden" id="infecciones_seleccionadas" name="infecciones_seleccionadas">

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
                        <div>
                            <p id="conteoMedicamentos">Cantidad de medicamentos para esta bacteria: 0</p>
                        </div>
                        <div class="col-lg-4">
                            <!-- Desplegable para seleccionar medicamentos -->
                            <div class="form-group">
                                <label for="medicamento">Medicamento:</label>
                                <select id="medicamento" name="medicamento">
                                    <option value="">Seleccione una bacteria primero</option>
                                </select>
                            </div>
                        </div>
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
                                <textarea class="form-control" id="medidas_tomar" name="medidas_tomar" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para aislamiento -->
                            <div class="form-group select-style-1">
                                <label for="aislamiento">Aislamiento:</label>
                                <div class="select-position">
                                    <select class="form-control" id="aislamiento" name="aislamiento" >
                                        <option value="">Seleccionar</option>
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para seguimiento -->
                            <div class="form-group input-style-1">
                                <label for="seguimiento">Seguimiento:</label>
                                <textarea class="form-control" id="seguimiento" name="seguimiento" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Campo para observacion -->
                            <div class="form-group input-style-1">
                                <label for="observacion">Observación:</label>
                                <textarea class="form-control" id="observacion" name="observacion" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.1.0/luxon.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
var medicamentosSeleccionadosGlobal = [];
var medicamentosSeleccionados = {};
var informacionBacterias = {};
var medicamentosSeleccionadosPK = {};

// function cargarMedicamentos() {
//   var bacteriaSelect = document.getElementById('bacteria');
//   var bacteriaId = document.getElementById('bacteria').value;
//   var medicamentoSelect = document.getElementById('medicamento');
//   var conteoMedicamentos = document.getElementById('conteoMedicamentos');
//   //var tablaMedicamentos = document.getElementById('tablaMedicamentos');
//   var nombreBacteriaModal = document.getElementById('nombreBacteriaModal'); // Elemento para mostrar el nombre de la bacteria
//   // Limpiar opciones anteriores

//   medicamentoSelect.innerHTML = '<option value="">Cargando medicamentos...</option>';

//     $.ajax({
//         url:"{{url('obtener-medicamentos')}}/"+bacteriaId,
//         type:'GET',
//         data:bacteriaId,
//         success:function(data){
//             //console.log(data.medicamentos);
//             medicamentoSelect.innerHTML = '<option value="">Seleccione un medicamento</option>';
//             data.medicamentos.forEach(function(medicamento) {
//             var option = document.createElement('option');
//             option.value = medicamento.cod_medicamento;
//             option.textContent = medicamento.nombre;
//             medicamentoSelect.appendChild(option);
//        });
//         // Mostrar el conteo de medicamentos
//         conteoMedicamentos.textContent = 'Cantidad de medicamentos para esta bacteria: ' + data.medicamentos.length;
//         //nombreBacteriaModal.textContent = 'Nombre de la bacteria seleccionada: ' + data.nombreBacteria; // Mostrar el nombre de la bacteria
//         // Almacenar los medicamentos en la variable global
//         medicamentosSeleccionadosGlobal = data.medicamentos;
//         // Limpiar el objeto de medicamentos seleccionados
//         //medicamentosSeleccionados = {};
//         // Generar la tabla con las columnas dinámicas
//         //console.log(medicamentosSeleccionadosGlobal);
//         var tablaHTML = generarTablaMedicamentos(data.medicamentos);
//         $('#tablaMedicamentosModal').html(tablaHTML); // Asignar la tabla al div dentro del modal
//          // Generar la tabla con las columnas dinámicas
//         //tablaMedicamentos.innerHTML = generarTablaMedicamentos(data.medicamentos);
//         bacteriaSelect.value = '';
//         //---------------------------------------------------------------------------
//         // var medicamentosPK = {};
//         // data.medicamentos.forEach(function (medicamento) {
//         //     medicamentosPK[medicamento.nombre] = medicamento.cod_medicamento;
//         // });

//         // informacionBacteriasPK[bacteriaSeleccionada] = medicamentosPK;
//         // console.log(informacionBacteriasPK);
//         //---------------------------------------------------------------------------
//         }
//       });
// }
var bacteriaMedicamentoRelacionado = {}; // Variable global para almacenar la relación entre bacteria y medicamentos
//var bacteriasSeleccionadasPK = {};


var medicamentosSeleccionadosGlobal = [];
var bacteriasSeleccionadasGlobal = []; // aquí almacenarás las bacterias
var bacteriaSeleccionadaPK;
var nombresBacterias = {};
var nombresMedicamentos = {};
function cargarMedicamentos() {
    var bacteriaSelect = document.getElementById('bacteria');
    var bacteriaId = document.getElementById('bacteria').value;
    var medicamentoSelect = document.getElementById('medicamento');
    var conteoMedicamentos = document.getElementById('conteoMedicamentos');
    var nombreBacteriaModal = document.getElementById('nombreBacteriaModal');
    medicamentoSelect.innerHTML = '<option value="">Cargando medicamentos...</option>';
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{url('obtener-medicamentos')}}/" + bacteriaId,
        type: 'POST',
        data: {
                bacteriaId,
                _token: csrfToken // Agregar el token CSRF
        },
        success: function(data) {
            medicamentoSelect.innerHTML = '<option value="">Seleccione un medicamento</option>';

           // console.log(data.medicamentos);
            data.medicamentos.forEach(function(medicamento) {
                var option = document.createElement('option');
                option.value = medicamento.cod_medicamento;
                option.textContent = medicamento.nombre;
                medicamentoSelect.appendChild(option);

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
            conteoMedicamentos.textContent = 'Cantidad de medicamentos para esta bacteria: ' + data.medicamentos.length;
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






{{-- SCRIPT PARA LA FECHA ACTUAL EN EL INPUT --}}
<script>
  // Función para obtener la fecha actual en la zona horaria de Bolivia (GMT-4)
  function getCurrentDateInBolivia() {
    return luxon.DateTime.local().setZone('America/La_Paz').toISODate();
  }

  // Obtener el elemento input de fecha por su ID
  const fechaInput = document.getElementById('fecha_llenado');

  // Establecer la fecha actual en la zona horaria de Bolivia como valor predeterminado del campo de fecha
  fechaInput.value = getCurrentDateInBolivia();

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
var tiposInfeccionMap = {}; // Objeto para mapear códigos de infección a nombres

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
@endsection

