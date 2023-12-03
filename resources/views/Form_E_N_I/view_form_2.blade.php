@extends('layout')
@section('title', 'Formularios | Enf. de Notificación Inmediata')
@section('guide', 'Formularios / Enfermedades de de Notificación Inmediata')
@section('content')

<div class="row">
    @if ($success)
        <script src="{{ asset('assets/js/sweetalert2/dist/sweetalert2.min.js') }}"></script>
        <script>
            console.log('correcto');
            var successMessage = '{{ $success }}';
            Swal.fire('Éxito', successMessage, 'success');
        </script>
    @endif
    <div class="col-12">
        <div class="container bg-light bg-opacity-70 rounded p-5">
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
                                        <button onclick="searchPatient()" class="btn text-white" style="background-color: #a2231d">Buscar</button>
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
                            <div class="mb-2 d-grid gap-2 col-6 mx-auto">
                                <br>
                                <button type="submit" form="form-generar" id="generarFormularioBtn" class="btn btn-success" onclick="redirectToForm()" disabled>Generar formulario</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    var hClinicoValido = '';
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
                console.log(response);
                // return false;
                if (response.found) {
                    console.log('ok');
                    hClinicoValido = document.getElementById('n_historial').value;
                    // El paciente fue encontrado, mostrar los datos del paciente en el modal
                    var patientData = response.patientData;

                    // document.getElementById('nombre').value = patientData.nombre_paciente;
                    // document.getElementById('ap_paterno').value = patientData.ap_paterno;
                    // document.getElementById('ap_materno').value = patientData.ap_materno;
                    // document.getElementById('edad').value = patientData.edad;
                    // document.getElementById('sexo').value = patientData.sexo;
                    // console.log(response.patientData[0].nombre);
                    // document.getElementById('nombre').value = response.patientData.nombre;
                    //SQL SERVER
                    document.getElementById('nombre').value = `${patientData[0].nombre[0].toUpperCase()}${patientData[0].nombre.slice(1).toLowerCase()}`;
                    document.getElementById('ap_paterno').value = `${patientData[0].ap_paterno[0].toUpperCase()}${patientData[0].ap_paterno.slice(1).toLowerCase()}`;
                    document.getElementById('ap_materno').value =patientData[0].ap_materno[0] ? `${patientData[0].ap_materno[0].toUpperCase()}${patientData[0].ap_materno.slice(1).toLowerCase()}`:'';
                    // document.getElementById('nombre').value = patientData[0].nombre.toLowerCase();
                    // document.getElementById('ap_paterno').value = patientData[0].ap_paterno;
                    // document.getElementById('ap_materno').value = patientData[0].ap_materno;
                    document.getElementById('edad').value = patientData[0].edad;
                    document.getElementById('sexo').value = patientData[0].sexo;


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
            var patientId = hClinicoValido;
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
