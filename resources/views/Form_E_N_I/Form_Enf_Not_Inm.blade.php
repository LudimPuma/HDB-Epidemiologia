@extends('layout')
@section('title', 'Enf. Notificación Inmediata')
@section('guide', 'Formularios / Enf. de Notificación Inmediata')
@section('content')

<section class="tab-components">
    <div class="container-fluid">
        <div class="form-elements-wrapper">
            <div class="row">
                <h1 class="text-center">Enfermedades de Notificación Inmediata</h1>
                <br>
                <form method="POST" action="{{ route('guardar_datos_form_Enf_Not_Inmediata') }}">
                    @csrf
                    {{-- datos paciente --}}
                    <div class="card-style mb-30">
                        <h6 class="mb-25">Datos Generales</h6>
                        <div class="row">
                            <div class="col-lg-3">
                                <!-- Nro Historial -->
                                <div class="form-group input-style-1">
                                    <label for="h_clinico">N° Historial:</label>
                                    <input type="text" class="form-control" id="h_clinico" name="h_clinico" value="{{ $id }}" pattern="[0-9]+" title="Solo numeros."  required>
                                    {{-- <input type="text" class="form-control" id="h_clinico" name="h_clinico" value="{{ $HCL_CODIGO }}" required> --}}
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
                                <!-- fecha-->
                                {{-- <div class="form-group input-style-1">
                                    <label for="fecha">Fecha</label> --}}
                                    <input type="hidden" name="fecha" id="fecha" class="form-control" value="{{ $fechaActual }}" pattern="[0-9\-]+" title="Solo fechas." required>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                    {{-- llenado del formulario --}}
                    <div class="card-style mb-30">
                        <h6 class="mb-25">Enfermedades de Notificacion Inmediata</h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- Campo para servicio -->
                                <div class="form-group select-style-1">
                                    <label for="servicio_inicio_sintomas">Servicio:</label>
                                    <div class="select-position">
                                        <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas"  required>
                                            <option value="">Seleccionar</option>
                                            @foreach ($servicios as $servicio)
                                                <option value="{{ $servicio->cod_servicio }}">{{ $servicio->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!-- Campo para patologia -->
                                <div class="form-group select-style-1">
                                    <label for="patologia">Patología:</label>
                                    <div class="select-position">
                                        <select class="form-control" id="patologia" name="patologia"  required>
                                            <option value="">Seleccionar</option>
                                            @foreach ($patologias as $patologia)
                                                <option value="{{ $patologia->cod_patologia }}">{{ $patologia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!-- Campo para Notificador -->
                                <div class="form-group input-style-1">
                                    <label for="notificador">Notificador:</label>
                                    <input type="text" class="form-control" id="notificador" name="notificador" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s.\-()\d]+"  required>
                                </div>
                            </div>
                        </div>

                        {{-- TABLA DE SELECCION PATOLOGIA --}}
                        <div id="tablaDatosSeleccionados"></div>
                        {{-- INPUT INVISIBLE QUE ALMACENA LOS TIPOS DE INFECCION --}}
                        <input type="hidden" id="patologias_seleccionadas" name="patologias_seleccionadas">

                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Campo para acciones -->
                                <div class="form-group input-style-1">
                                    <label for="acciones">Acciones:</label>
                                    <textarea class="form-control" id="acciones" name="acciones" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s.\-()\d]+" required ></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- Campo para observaciones -->
                                <div class="form-group input-style-1">
                                    <label for="observaciones">Observaciones:</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" required ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</section>
@if(isset($success) && $success)
    <script>
        Swal.fire('Éxito', '{{ $success }}', 'success');
    </script>
@endif



<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert2/dist/sweetalert2.min.js')}}"></script>
{{-- TABLA SELECCION PATOLOGIA --}}
<script>
    $('#patologia').on('change', function () {
        var patologiaSeleccionada = $(this).val();
        if (patologiaSeleccionada) {
            agregarpatologiaTabla(patologiaSeleccionada);
        }
    });

    var patologiasSeleccionadas = [];
    var tiposPatologiaMap = {};

    @foreach ($patologias as $patologia)
    tiposPatologiaMap["{{ $patologia->cod_patologia }}"] = "{{ $patologia->nombre }}";
    @endforeach

    function agregarpatologiaTabla(patologia) {
        if (!patologiasSeleccionadas.includes(patologia)) {
            patologiasSeleccionadas.push(patologia);
            actualizarTabla();

            $('#patologias_seleccionadas').val(JSON.stringify(patologiasSeleccionadas));
        }
    }

    function actualizarTabla() {
        var tablaHTML = '<table class="table table-bordered my-custom-table" style="text-align: center; border-collapse: collapse;">';
        tablaHTML += '<thead class="table-primary"><tr><th>Patologia</th><th>Opciones</th></tr></thead>';
        tablaHTML += '<tbody>';

            patologiasSeleccionadas.forEach(function (patologia) {
            var nombrePatologia = tiposPatologiaMap[patologia];
            tablaHTML += '<tr>';
            tablaHTML += '<td>' + nombrePatologia + '</td>';
            tablaHTML += '<td><button class="btn btn-danger btn-sm" onclick="eliminarInfeccion(\'' + patologia + '\')"><i class="lni lni-trash-can"></i></button></td>';
            tablaHTML += '</tr>';
        });

        tablaHTML += '</tbody>';
        tablaHTML += '</table>';

        $('#tablaDatosSeleccionados').html(tablaHTML);
        console.log(patologiasSeleccionadas);
    }
    function eliminarInfeccion(patologia) {
        var index = patologiasSeleccionadas.indexOf(patologia);
        if (index !== -1) {
            patologiasSeleccionadas.splice(index, 1);
            actualizarTabla();
        }
    }
</script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var successMessage = '{{ Session::get('success') }}';
        if (successMessage) {
            console.log('Mensaje de éxito:', successMessage);
            Swal.fire('Éxito', successMessage, 'success');
        }
    });

</script> --}}

@endsection
