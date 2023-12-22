@extends('layout')
@section('title', 'Formularios | IAAS')
@section('guide', 'Formularios / IAAS')
@section('content')

<section class="tab-components">
<style>
        .list-group-item-danger.active {
            background-color: #dc3545; /* Color danger cuando está activo */
            color: #fff; /* Cambia el color del texto cuando está activo */
            border-color: #dc3545; /* Cambia el color del borde cuando está activo */
        }

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

<div class="row">
    <div class="container-fluid">
        <div class="container bg-light rounded p-4 shadow-lg">
            <h2 class="text-center">IAAS</h2>
            <br>
            <div class="form-elements-wrapper">
                <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8" >
                    <form method="POST" action="{{ route('guardar_datos_form_IAAS') }}"  >
                        @csrf
                        <div class="row">
                            <div class="list-group" id="list-tab" role="tablist">

                                <div class="row">
                                    <div class="col-4">
                                        <a class="list-group-item list-group-item-action list-group-item-danger text-center active shadow-lg" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home">Datos Generales</a>
                                    </div>
                                    <div class="col-4">
                                        <a class="list-group-item list-group-item-action list-group-item-danger text-center shadow-lg" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Datos Laboratorio</a>
                                    </div>
                                    <div class="col-4">
                                        <a class="list-group-item list-group-item-action list-group-item-danger text-center shadow-lg" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages">Datos Epidemiologicos</a>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">
                                <br>
                                {{-- DATOS GENERALES --}}
                                <div class="tab-pane fade show active shadow-lg" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Datos Generales</h6>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <!-- Nro Historial -->
                                                <div class="form-group input-style-1">
                                                    <label for="h_clinico">N° Historial:</label>
                                                    <input type="text" class="form-control" id="h_clinico" name="h_clinico" value="{{ $id }}" value="{{old('h_clinico')}}" required>
                                                    @error('h_clinico')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <!-- Datos paciente -->
                                                <div class="form-group input-style-1">
                                                    <label for="dato_paciente">Nombre completo:</label>
                                                    <input type="text" class="form-control" id="dato_paciente" name="dato_paciente" value="{{ $nombre }}" disabled>
                                                </div>
                                            </div>
                                            <!-- Campo para fecha_llenado -->
                                            <input type="hidden" class="form-control" id="fecha_llenado" name="fecha_llenado" value="{{ $fechaActual }}" required>
                                                @error('fecha_llenado')
                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            var errorMessage = @json($message);
                                                            if (errorMessage) {
                                                                Swal.fire('Error', errorMessage, 'error');
                                                            }
                                                        });
                                                    </script>
                                                @enderror
                                            <div class="col-lg-4">
                                                <!-- Campo para fecha_ingreso -->
                                                <div class="form-group input-style-1">
                                                    <label for="fecha_ingreso">Fecha de Ingreso:</label>
                                                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="{{old('fecha_ingreso')}}" required>
                                                    @error('fecha_ingreso')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <!-- Campo para fecha egreso -->
                                                <div class="form-group select-style-1">
                                                    <label for="fecha_egreso">Fecha de Egreso:</label>
                                                    <div class="form-group input-style-1">
                                                        <input type="date" class="form-control" id="fecha_egreso" name="fecha_egreso" value="{{old('fecha_egreso')}}" required>
                                                        @error('fecha_egreso')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-lg-4">
                                                <!-- Campo para dias internacion -->
                                                <div class="form-group input-style-1">
                                                    <label for="dias_internacion">Días de Internacion:</label>
                                                    <input type="number" class="form-control" id="dias_internacion" name="dias_internacion" value="{{old('dias_internacion', 1)}}" required>
                                                    @error('dias_internacion')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- Campo para servicio_inicio_sintomas -->
                                                <div class="form-group select-style-1">
                                                    <label for="servicio_inicio_sintomas">Servicio de inicio de síntomas:</label>
                                                    <div class="select-position">
                                                        <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas" required>
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($servicios as $servicio)
                                                                <option value="{{ $servicio->cod_servicio }}" @if(old('servicio_inicio_sintomas') == $servicio->cod_servicio) selected @endif>{{ $servicio->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('servicio_inicio_sintomas')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
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
                                                        <select class="form-control" id="servicio_notificador" name="servicio_notificador" required>
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($servicios as $servicio)
                                                            <option value="{{ $servicio->cod_servicio }}" @if(old('servicio_notificador') == $servicio->cod_servicio) selected @endif>{{ $servicio->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('servicio_notificador')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group input-style-1">
                                                    <label for="diagnostico_ingreso">Diagnóstico de ingreso:</label>
                                                    <textarea class="form-control" id="diagnostico_ingreso" name="diagnostico_ingreso" required>{{old('diagnostico_ingreso')}}</textarea>
                                                    @error('diagnostico_ingreso')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group input-style-1">
                                                    <label for="diagnostico_sala">Diagnóstico de sala:</label>
                                                    <textarea class="form-control" id="diagnostico_sala" name="diagnostico_sala" required>{{old('diagnostico_sala')}}</textarea>
                                                    @error('diagnostico_sala')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group input-style-1">
                                                    <label for="diagnostico_egreso">Diagnóstico de egreso:</label>
                                                    <textarea class="form-control" id="diagnostico_egreso" name="diagnostico_egreso" required>{{old('diagnostico_egreso')}}</textarea>
                                                    @error('diagnostico_egreso')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- DATOS DE LABORATORIO --}}
                                <div class="tab-pane fade shadow-lg" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Datos de Laboratorio</h6>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <!-- Campo para tipo_infeccion -->
                                                <div class="form-group select-style-1">
                                                    <label for="tipo_infeccion">Tipo de infección Hospitalaria:</label>
                                                    <div class="select-position">
                                                        <select class="form-control" id="tipo_infeccion" name="tipo_infeccion" required>
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($tiposInfeccion as $tipoInfeccion)
                                                                <option value="{{ $tipoInfeccion->cod_tipo_infeccion }}">{{ $tipoInfeccion->nombre }}</option>
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
                                                        <select class="form-control" id="tipo_muestra_cultivo" name="tipo_muestra_cultivo" required>
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($tiposMuestra as $tipoMuestra)
                                                                <option value="{{ $tipoMuestra->cod_tipo_muestra }}" @if(old('tipo_muestra_cultivo') == $tipoMuestra->cod_tipo_muestra) selected @endif>{{ $tipoMuestra->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('tipo_muestra_cultivo')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- Campo para procedimiento_invasivo -->
                                                <div class="form-group select-style-1">
                                                    <label for="procedimiento_invasivo">Procedimiento invasivo:</label>
                                                    <div class="select-position">
                                                        <select class="form-control" id="procedimiento_invasivo" name="procedimiento_invasivo" required>
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($procedimientosInmasivos as $procedimientoInvasivo)
                                                                <option value="{{ $procedimientoInvasivo->cod_procedimiento_invasivo }}" @if(old('procedimiento_invasivo') == $procedimientoInvasivo->cod_procedimiento_invasivo) selected @endif>{{ $procedimientoInvasivo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('procedimiento_invasivo')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
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
                                            <div class="col-lg-3">
                                                <!-- Campo para uso_antimicrobanos -->
                                                <div class="form-group select-style-1">
                                                    <label for="uso_antimicrobanos">Uso de antimicrobianos:</label>
                                                    <div class="select-position">
                                                        <select class="form-control" id="uso_antimicrobanos" name="uso_antimicrobanos" required>
                                                            <option value="">Seleccionar</option>
                                                            <option value="si" @if(old('uso_antimicrobanos') == 'si') selected @endif>Sí</option>
                                                            <option value="no" @if(old('uso_antimicrobanos') == 'no') selected @endif>No</option>
                                                        </select>
                                                        @error('uso_antimicrobanos')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <!-- Campo para Hongos -->
                                                <div class="form-group select-style-1">
                                                    <label for="hongo">Hongos:</label>
                                                    <div class="select-position">
                                                        <select class="form-control" id="hongo" name="hongo" required>
                                                            <option value="">Seleccionar</option>
                                                            @foreach ($hongos as $hongo)
                                                                <option value="{{ $hongo->id }}">{{ $hongo->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- TABLA tipo Hongo --}}
                                            <div id="tablaHongos"></div>
                                            {{-- INPUT INVISIBLE QUE ALMACENA LOS TIPOS DE Hongos --}}
                                            <input type="hidden" id="hongos_seleccionados" name="hongos_seleccionados" >
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

                                            <div id="tablaDatosGuardados"></div>

                                        </div>
                                    </div>
                                </div>
                                {{-- DATOS EPIDEMIOLOGICOS --}}
                                <div class="tab-pane fade shadow-lg" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
                                    <div class="card-style mb-30">
                                        <h6 class="mb-25">Datos Epidemiologico</h6>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <!-- Campo para medidas_tomar -->
                                                <div class="form-group input-style-1">
                                                    <label for="medidas_tomar">Medidas a tomar:</label>
                                                    <textarea class="form-control" id="medidas_tomar" name="medidas_tomar" required>{{old('diagnostico_sala')}}</textarea>
                                                    @error('medidas_tomar')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- Campo para aislamiento -->
                                                <div class="form-group select-style-1">
                                                    <label for="aislamiento">Aislamiento:</label>
                                                    <div class="select-position">
                                                        <select class="form-control" id="aislamiento" name="aislamiento" required>
                                                            <option value="">Seleccionar</option>
                                                            <option value="si" @if(old('aislamiento') == 'si') selected @endif>Sí</option>
                                                            <option value="no" @if(old('aislamiento') == 'no') selected @endif>No</option>
                                                        </select>
                                                        @error('aislamiento')
                                                            <script>
                                                                document.addEventListener("DOMContentLoaded", function() {
                                                                    var errorMessage = @json($message);
                                                                    if (errorMessage) {
                                                                        Swal.fire('Error', errorMessage, 'error');
                                                                    }
                                                                });
                                                            </script>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <!-- Campo para seguimiento -->
                                                <div class="form-group input-style-1">
                                                    <label for="seguimiento">Seguimiento:</label>
                                                    <textarea class="form-control" id="seguimiento" name="seguimiento" required>{{old('seguimiento')}}</textarea>
                                                    @error('seguimiento')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            {{-- <div class="col-lg-4">
                                                <!-- Campo para observacion -->
                                                <div class="form-group input-style-1">
                                                    <label for="observacion">Observación:</label>
                                                    <textarea class="form-control" id="observacion" name="observacion" required>{{old('observacion')}}</textarea>
                                                    @error('observacion')
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                var errorMessage = @json($message);
                                                                if (errorMessage) {
                                                                    Swal.fire('Error', errorMessage, 'error');
                                                                }
                                                            });
                                                        </script>
                                                    @enderror
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2 d-grid gap-2 col-6 mx-auto">
                            {{-- <input type="submit" value="Guardar" class="btn btn-primary text-center"> --}}
                            <input type="submit" value="Guardar" class="btn btn-danger text-center" id="guardar-btn" disabled>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let successMessage = '{{ session('success') }}';

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: successMessage,
            });
        }
    });
</script>


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
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert2/dist/sweetalert2.min.js')}}"></script>
{{-- PRUEBA --}}
<script>
    // Función para comprobar si todos los campos requeridos están llenos
    function checkFormValidity() {
        const requiredFields = document.querySelectorAll('form [required]');
        for (const field of requiredFields) {
            if (field.value.trim() === '') {
                return false; // Al menos un campo requerido está vacío
            }
        }
        return true; // Todos los campos requeridos están llenos

    }

    // Escucha el evento 'input' en todos los campos del formulario
    document.querySelectorAll('form [required]').forEach(field => {
        field.addEventListener('input', function() {
            const isValid = checkFormValidity();
            const guardarBtn = document.getElementById('guardar-btn');
            guardarBtn.disabled = !isValid;
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
    tablaHTML += '<thead class="table-primary"><tr><th>Antibiotico</th><th>Nivel de Resistencia</th></tr></thead>';
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


{{-- TABLA HONGO --}}
<script>
    $('#hongo').on('change', function () {
        var hongoSeleccionado = $(this).val();
        if (hongoSeleccionado) {
            agregarHongoTabla(hongoSeleccionado);
        }
    });

    var hongosSeleccionados = [];
    var tiposHongoMap = {};

    @foreach ($hongos as $hongo)
        tiposHongoMap["{{ $hongo->id }}"] = "{{ $hongo->nombre }}";
    @endforeach

    function agregarHongoTabla(hongo) {
        if (!hongosSeleccionados.includes(hongo)) {
            hongosSeleccionados.push(hongo);
            actualizarTablaHongo();
            // Actualizar el campo oculto con los hongos seleccionados
            $('#hongos_seleccionados').val(JSON.stringify(hongosSeleccionados));
        }
    }

    function actualizarTablaHongo() {
        var tablaHTML = '<table class="table table-bordered my-custom-table" style="text-align: center; border-collapse: collapse;">';
        tablaHTML += '<thead class="table-primary"><tr><th>Hongos</th><th>Opciones</th></tr></thead>';
        tablaHTML += '<tbody>';

        hongosSeleccionados.forEach(function (hongo) {
            var nombreHongo = tiposHongoMap[hongo];
            tablaHTML += '<tr>';
            tablaHTML += '<td>' + nombreHongo + '</td>';
            tablaHTML += '<td><button class="btn btn-danger btn-sm" onclick="eliminarHongo(\'' + hongo + '\')"><i class="lni lni-trash-can"></i></button></td>';
            tablaHTML += '</tr>';
        });

        tablaHTML += '</tbody>';
        tablaHTML += '</table>';

        $('#tablaHongos').html(tablaHTML);
        $('#hongos_seleccionados').val(JSON.stringify(hongosSeleccionados));
        console.log(hongosSeleccionados);
    }

    function eliminarHongo(hongo) {
        var index = hongosSeleccionados.indexOf(hongo);
        if (index !== -1) {
            hongosSeleccionados.splice(index, 1);
            actualizarTablaHongo();
        }
    }
</script>

{{-- DIAS DE INTERNACION --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var fechaIngreso = document.getElementById("fecha_ingreso");
        var fechaEgreso = document.getElementById("fecha_egreso");
        var diasInternacion = document.getElementById("dias_internacion");

        function calcularDiasInternacion() {
            var fechaIngresoValue = new Date(fechaIngreso.value);
            var fechaEgresoValue = new Date(fechaEgreso.value);

            // Validación: Si la fecha de ingreso es posterior a la fecha de egreso, establece días en 0
            if (fechaIngresoValue > fechaEgresoValue) {
                diasInternacion.value = 0;
            } else {
                // Calcula la diferencia en milisegundos
                var diferencia = fechaEgresoValue - fechaIngresoValue;

                // Convierte la diferencia a días
                var dias = Math.max(Math.ceil(diferencia / (1000 * 60 * 60 * 24)), 1);

                // Actualiza el valor del campo días de internación
                diasInternacion.value = dias;
            }
        }

        // Asocia la función al evento change de las fechas
        fechaIngreso.addEventListener("change", calcularDiasInternacion);
        fechaEgreso.addEventListener("change", calcularDiasInternacion);
    });
</script>


@endsection

