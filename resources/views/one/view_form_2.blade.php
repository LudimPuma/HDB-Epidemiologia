@extends('layout')
@section('content')
<div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#h_paciente">
            Agregar Formulario
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalBusqueda">
             Imprimir Formulario
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalreporte">
            Generar Reporte
        </button>
    </div>
</div>

<!-- Modal GENERAR FORMULARIO-->
<div class="modal fade" id="h_paciente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div>


<!-- Modal IMPRIMIR FORMULARIO-->
<div class="modal fade" id="modalBusqueda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buscar formulario por historial clínico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buscar-form_2') }}" method="GET">
                    <div class="mb-3">
                        <label for="hClinico" class="form-label">Número de historial clínico:</label>
                        <input type="number" class="form-control" id="hClinico" name="hClinico" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal reporte -->
<div class="modal fade" id="modalreporte" tabindex="-1" role="dialog" aria-labelledby="modalreporte" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalreporte">Seleccionar Mes para el Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('formulario.generar') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="fecha">Año:</label>
                        <input type="month" id="fecha" name="fecha" value="{{date("Y-m")}}" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function enableGenerateButton(enabled) {
    var generarFormularioBtn = document.getElementById('generarFormularioBtn');
    generarFormularioBtn.disabled = !enabled;
}
function searchPatient() {
    var patientId = document.getElementById('n_historial').value;
    // Realiza una solicitud Ajax al servidor
    $.ajax({
        url: '{{ route("buscar-paciente_form_2") }}',
        type: 'GET',
        data: { patientId: patientId },
        success: function(response) {
            // La solicitud se completó correctamente
            if (response.found) {
                // El paciente fue encontrado, mostrar los datos del paciente en el modal
                var patientData = response.patientData;

                document.getElementById('nombre').value = patientData.nombre_paciente;
                document.getElementById('ap_paterno').value = patientData.ap_paterno;
                document.getElementById('ap_materno').value = patientData.ap_materno;
                document.getElementById('edad').value = patientData.edad;
                document.getElementById('sexo').value = patientData.sexo;
                // Reiniciar el contenido del elemento 'patientData' si existe
                var patientDataElement = document.getElementById('patientData');
                if (patientDataElement) {
                    patientDataElement.innerHTML = '';
                }
                enableGenerateButton(true); // Habilita el botón "Generar formulario"
            } else {
                // El paciente no fue encontrado, mostrar una alerta
                var patientDataElement = document.getElementById('patientData');
                if (patientDataElement) {
                    patientDataElement.innerHTML = '';
                }
                alert('Paciente no encontrado');
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

    // limpiar los campos del modal a su estado inicial
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
    // redireccionar al formulario
    function redirectToForm() {
        var patientId = document.getElementById('n_historial').value;
        var nombreCompleto = document.getElementById('nombre').value + ' ' + document.getElementById('ap_paterno').value + ' ' + document.getElementById('ap_materno').value;

        var url = "{{ route('formulario_Enf_Not_Inmediata') }}?patientId=" + encodeURIComponent(patientId) + "&nombreCompleto=" + encodeURIComponent(nombreCompleto);
        window.location.href = url;
}

    // Función para obtener el año actual
    function getAnioActual() {
        var now = new Date();
        return now.getFullYear();
    }
    // asigna el año actual al campo del input
    $('#modalreporte').on('show.bs.modal', function (event) {
        var anioActual = getAnioActual();
        $('#anio').val(anioActual);
    });

</script>

@endsection
