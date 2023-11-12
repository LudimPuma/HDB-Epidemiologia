@extends('layout')
@section('title', 'H. Clinico | IAAS')
@section('content')
<div class="tables-wrapper">
    <div class="card-style mb-30">
        <h2 class="text-center">Historial Clínico</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="n_historial">Nro. Historial</label>
                    <div class="input-group">
                        <input type="number" id="n_historial" name="n_historial" class="form-control" required onkeydown="if (event.keyCode === 13) searchPatient();">
                        <div class="input-group-append">
                            <button onclick="searchPatient()" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="nombre">Nombre(s)</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ap_paterno">Apellido Paterno</label>
                    <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ap_materno">Apellido Materno</label>
                    <input type="text" id="ap_materno" name="ap_materno" class="form-control" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="edad">Edad</label>
                    <input type="number" id="edad" name="edad" class="form-control" disabled>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <input type="text" id="sexo" name="sexo" class="form-control" disabled>
                </div>
            </div>
        </div>
        <div class="row text-center">
            <div class="">
                <div class="form-group">
                    <br>
                    <button type="submit" form="form-generar" id="generarFormularioBtn" class="btn btn-primary" onclick="redirectToForm()" disabled>Generar formulario</button>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- <div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#h_paciente">
            Agregar Formulario
        </button>
    </div>
</div> --}}
{{-- <div class="modal-body">
    <div class="row">
        <div class="col-md-4 offset-md-3">
            <div class="form-group text-center">
                <label for="n_historial">Nro. Historial</label>
                <input type="number" id="n_historial" name="n_historial" class="form-control" required>
                <button onclick="searchPatient()" class="btn btn-primary">Buscar</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="nombre">Nombre(s)</label>
                <input type="text" id="nombre" name="nombre" class="form-control" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="ap_paterno">Apellido Paterno</label>
                <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="ap_materno">Apellido Materno</label>
                <input type="text" id="ap_materno" name="ap_materno" class="form-control" disabled>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="edad">Edad</label>
                <input type="number" id="edad" name="edad" class="form-control" disabled>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="sexo">Sexo</label>
                <input type="text" id="sexo" name="sexo" class="form-control" disabled>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="submit" form="form-generar" id="generarFormularioBtn" class="btn btn-primary" onclick="redirectToForm()" disabled>Generar formulario</button>
</div> --}}
<!-- Modal GENERAR FORMULARIO-->
{{-- <div class="modal fade" id="h_paciente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Historial Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-group">
                            <label for="n_historial">Nro. Historial</label>
                            <input type="number" id="n_historial" name="n_historial" class="form-control" required>
                            <button onclick="searchPatient()" class="btn btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre(s)</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ap_paterno">Apellido Paterno</label>
                            <input type="text" id="ap_paterno" name="ap_paterno" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ap_materno">Apellido Materno</label>
                            <input type="text" id="ap_materno" name="ap_materno" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" id="edad" name="edad" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <input type="text" id="sexo" name="sexo" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="form-generar" id="generarFormularioBtn" class="btn btn-primary" onclick="redirectToForm()" disabled>Generar formulario</button>
            </div>
        </div>
    </div>
</div> --}}

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
function enableGenerateButton(enabled) {
    var generarFormularioBtn = document.getElementById('generarFormularioBtn');
    generarFormularioBtn.disabled = !enabled;
}
function searchPatient() {
    var patientId = document.getElementById('n_historial').value;
    $.ajax({
        url: '{{ route("buscar-paciente_form_1") }}',
        type: 'GET',
        data: { patientId: patientId },
        success: function(response) {
            if (response.found) {
                var patientData = response.patientData;

                document.getElementById('nombre').value = patientData.nombre_paciente;
                document.getElementById('ap_paterno').value = patientData.ap_paterno;
                document.getElementById('ap_materno').value = patientData.ap_materno;
                document.getElementById('edad').value = patientData.edad;
                document.getElementById('sexo').value = patientData.sexo;
                //SQL SERVER
                // document.getElementById('nombre').value = patientData.HCL_NOMBRE;
                // document.getElementById('ap_paterno').value = patientData.HCL_APPAT;
                // document.getElementById('ap_materno').value = patientData.HCL_APMAT;
                // document.getElementById('edad').value = patientData.HCL_FECNAC;
                // document.getElementById('sexo').value = patientData.HCL_SEXO;


                // Reiniciar el contenido del elemento 'patientData' si existe
                var patientDataElement = document.getElementById('patientData');
                if (patientDataElement) {
                    patientDataElement.innerHTML = '';
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Paciente encontrado',
                    showConfirmButton: false,
                    timer: 1500
                });
                enableGenerateButton(true); // Habilita el botón "Generar formulario"
            } else {
                // El paciente no fue encontrado, mostrar una alerta
                var patientDataElement = document.getElementById('patientData');
                if (patientDataElement) {
                    patientDataElement.innerHTML = '';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Paciente no encontrado',
                    text: 'Por favor, verifique el número de historial.',
                    showConfirmButton: false,
                    timer: 1500
                });
                clearFields();
                enableGenerateButton(false); // Deshabilita el botón "Generar formulario"
            }
        },
        error: function() {
            // Ocurrió un error durante la solicitud
            alert('Error en la búsqueda del paciente');
            enableGenerateButton(false); // Deshabilita el botón "Generar formulario"
        }
    });

    // Restablecer los campos del modal a su estado inicial
    function clearFields() {
        document.getElementById('n_historial').value = '';
        document.getElementById('nombre').value = '';
        document.getElementById('ap_paterno').value = '';
        document.getElementById('ap_materno').value = '';
        document.getElementById('edad').value = '';
        document.getElementById('sexo').value = '';
    }
    // Cerrar el modal y limpiar los datos
    function closeModal() {
        clearFields();
        // Código adicional para cerrar el modal (usando Bootstrap)
        $('#h_paciente').modal('hide');
    }
    // Al cerrar el modal, limpiar los campos
    $('#h_paciente').on('hidden.bs.modal', function() {
        clearFields();
    });
}
    function redirectToForm() {
        var patientId = document.getElementById('n_historial').value;
        var nombreCompleto = document.getElementById('nombre').value + ' ' + document.getElementById('ap_paterno').value + ' ' + document.getElementById('ap_materno').value;

        var url = "{{ route('formularioIAAS') }}?patientId=" + encodeURIComponent(patientId) + "&nombreCompleto=" + encodeURIComponent(nombreCompleto);
        window.location.href = url;
}
</script>
@endsection
