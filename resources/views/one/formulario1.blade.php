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

</style>
    <div class="container-fluid">
        <div class="form-elements-wrapper">
            <form method="POST" action="{{ route('guardar_datos_form_IAAS') }}">
                @csrf
                <div class="card-style mb-30">
                    <h6 class="mb-25">Datos Generales</h6>
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Nro Historial -->
                            <div class="form-group input-style-1">
                                <label for="nro_historial">N° Historial:</label>
                                <input type="text" class="form-control" id="nro_historial" name="nro_historial" value="{{ $id }}" disabled>
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
                                        @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
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
                                        @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
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

                <div class="card-style mb-30">
                    <h6 class="mb-25">Datos de Laboratorio</h6>
                    <div class="row">
                        <div class="col-lg-3">
                            <!-- Campo para tipo_infeccion -->
                            <div class="form-group select-style-1">
                                <label for="tipo_infeccion">Tipo de infección Hopsitalaria:</label>
                                <div class="select-position">
                                    <select class="form-control" id="tipo_infeccion" name="tipo_infeccion" >
                                        @foreach ($tiposInfeccion as $tipoInfeccion)
                                            <option value="{{ $tipoInfeccion->id }}">{{ $tipoInfeccion->nombre }}</option>
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
                                        <option value="si">Sí</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <!-- Campo para agente_causal -->
                            <div class="form-group select-style-1">
                                <label for="agente_causal">Agente causal:</label>
                                <div class="select-position">
                                    <select class="form-control" id="agente_causal" name="agente_causal" >
                                        @foreach ($agentes as $agente)
                                            <option value="{{ $agente->id }}">{{ $agente->nombre }}</option>
                                        @endforeach
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
                                        @foreach ($tiposMuestra as $tipoMuestra)
                                            <option value="{{ $tipoMuestra->id }}">{{ $tipoMuestra->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <!-- Desplegable para seleccionar bacterias -->
                            <div class="form-group">
                                <label for="bacteria">Bacteria:</label>
                                <select id="bacteria" name="bacteria" onchange="cargarMedicamentos()">
                                    <option value="">Seleccione una bacteria</option>
                                    @foreach ($bacterias as $bacteria)
                                        <option value="{{ $bacteria->cod_bacterias }}">{{ $bacteria->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="tablaMedicamentos"></div>

                        <div class="col-lg-4">
                            <!-- Desplegable para seleccionar medicamentos -->
                            <div class="form-group">
                                <label for="medicamento">Medicamento:</label>
                                <select id="medicamento" name="medicamento">
                                    <option value="">Seleccione una bacteria primero</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- Campo para procedimiento_invasivo -->
                            <div class="form-group select-style-1">
                                <label for="procedimiento_invasivo">Procedimiento invasivo:</label>
                                <div class="select-position">
                                    <select class="form-control" id="procedimiento_invasivo" name="procedimiento_invasivo" >
                                        @foreach ($procedimientosInmasivos as $procedimientoInvasivo)
                                            <option value="{{ $procedimientoInvasivo->id }}">{{ $procedimientoInvasivo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function cargarMedicamentos() {
  var bacteriaId = document.getElementById('bacteria').value;
  var medicamentoSelect = document.getElementById('medicamento');

  // Limpiar opciones anteriores
  medicamentoSelect.innerHTML = '<option value="">Cargando medicamentos...</option>';

    $.ajax({
        url:"{{url('obtener-medicamentos')}}/"+bacteriaId,
        type:'GET',
        data:bacteriaId,
        success:function(data){
            console.log(data.medicamentos);
            medicamentoSelect.innerHTML = '<option value="">Seleccione un medicamento</option>';
            data.medicamentos.forEach(function(medicamento) {
            var option = document.createElement('option');
            option.value = medicamento.cod_medicamento;
            option.textContent = medicamento.nombre;
            medicamentoSelect.appendChild(option);
       });
        }
      });


// function cargarMedicamentos() {
//   var bacteriaId = document.getElementById('bacteria').value;

//   $.ajax({
//     url: "{{url('obtener-medicamentos')}}/" + bacteriaId,
//     type: 'GET',
//     data: bacteriaId,
//     success: function(data) {
//       var medicamentos = data.medicamentos;
//       var tablaMedicamentos = document.getElementById('tablaMedicamentos');
//       tablaMedicamentos.innerHTML = ''; // Limpiar contenido anterior

//       // Crear la tabla
//       var table = document.createElement('table');
//       table.classList.add('table'); // Agrega la clase 'table' de Bootstrap para el estilo

//       // Crea la fila de encabezado con los nombres de los medicamentos
//       var thead = document.createElement('thead');
//       var encabezadoRow = document.createElement('tr');
//       medicamentos.forEach(function(medicamento) {
//         var th = document.createElement('th');
//         th.textContent = medicamento.nombre;
//         encabezadoRow.appendChild(th);
//       });
//       thead.appendChild(encabezadoRow);
//       table.appendChild(thead);

//       // Crea las filas para resistente, intermedio y sensible
//       var tbody = document.createElement('tbody');
//       ['Resistente', 'Intermedio', 'Sensible'].forEach(function(categoria) {
//         var fila = document.createElement('tr');
//         medicamentos.forEach(function(medicamento) {
//           var td = document.createElement('td');
//           // Aquí puedes agregar la lógica para obtener los valores correspondientes a cada medicamento y categoría
//           td.textContent = obtenerValor(medicamento.cod_medicamento, categoria);
//           fila.appendChild(td);
//         });
//         tbody.appendChild(fila);
//       });
//       table.appendChild(tbody);

//       // Agrega la tabla al contenedor
//       tablaMedicamentos.appendChild(table);
//     }
//   });
// }





//   // Realizar solicitud AJAX para obtener los medicamentos
//   fetch('/obtener-medicamentos?bacteriaId=' + bacteriaId)
//     .then(function(response) {
//       return response.json();
//     })
//     .then(function(data) {
//         console.log(data);
//       // Limpiar opciones anteriores y agregar las nuevas opciones de medicamentos
//       medicamentoSelect.innerHTML = '<option value="">Seleccione un medicamento</option>';
//       data.medicamentos.forEach(function(medicamento) {
//         var option = document.createElement('option');
//         option.value = medicamento.id;
//         option.textContent = medicamento.nombre;
//         medicamentoSelect.appendChild(option);
//       });
//     })
//     .catch(function(error) {
//       console.error('Error al obtener los medicamentos:', error);
//     });
}


</script>

@endsection

