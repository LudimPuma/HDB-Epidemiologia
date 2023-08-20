@extends('layout')
@section('content')

<section class="tab-components">
    <div class="container-fluid">
        <div class="form-elements-wrapper">
            <div class="row">
                <h1>Enfermedades de Notificacion Inmediata</h1>
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
                                    <input type="text" class="form-control" id="h_clinico" name="h_clinico" value="{{ $id }}" >
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
                                <div class="form-group input-style-1">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control">
                                </div>
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
                                        <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas">
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
                                        <select class="form-control" id="patologia" name="patologia">
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
                                    <input type="text" class="form-control" id="notificador" name="notificador" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Campo para acciones -->
                                <div class="form-group input-style-1">
                                    <label for="acciones">Acciones:</label>
                                    <textarea class="form-control" id="acciones" name="acciones" required></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- Campo para observaciones -->
                                <div class="form-group input-style-1">
                                    <label for="observaciones">Observaciones:</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <button type="button" class="btn btn-primary" onclick="generarPDF()">Guardar</button> --}}
                    <button type="button" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</section>
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('js/mis-scripts.js') }}"></script> --}}


<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/luxon/2.1.0/luxon.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Función para obtener la fecha actual en la zona horaria de Bolivia (GMT-4)
  function getCurrentDateInBolivia() {
    return luxon.DateTime.local().setZone('America/La_Paz').toISODate();
  }

  // Obtener el elemento input de fecha por su ID
  const fechaInput = document.getElementById('fecha');

  // Establecer la fecha actual en la zona horaria de Bolivia como valor predeterminado del campo de fecha
  fechaInput.value = getCurrentDateInBolivia();
</script>


<script>
    // Función para generar y abrir el PDF
    function generarPDF() {
        // Crear una instancia de jsPDF
        const doc = new jsPDF.default();

        // Recopilar los valores de los campos del formulario
        const numeroHistorial = document.getElementById('h_clinico').value;
        const nombreCompleto = document.getElementById('dato_paciente').value;
        const fecha = document.getElementById('fecha').value;
        const servicio = document.getElementById('servicio_inicio_sintomas').value;
        const patologia = document.getElementById('patologia').value;
        const notificador = document.getElementById('notificador').value;
        const acciones = document.getElementById('acciones').value;
        const observaciones = document.getElementById('observaciones').value;

        // Agregar los datos al PDF
        doc.text('Número de Historial: ' + numeroHistorial, 10, 10);
        doc.text('Nombre Completo: ' + nombreCompleto, 10, 20);
        doc.text('Fecha: ' + fecha, 10, 30);
        doc.text('Servicio: ' + servicio, 10, 40);
        doc.text('Patología: ' + patologia, 10, 50);
        doc.text('Notificador: ' + notificador, 10, 60);
        doc.text('Acciones: ' + acciones, 10, 70);
        doc.text('Observaciones: ' + observaciones, 10, 80);

        // Guardar el PDF en una variable Blob
        const pdfBlob = doc.output('blob');

        // Crear una URL para el Blob
        const pdfUrl = URL.createObjectURL(pdfBlob);

        // Abrir una nueva ventana con el PDF
        window.open(pdfUrl, '_blank');
    }
</script>

@endsection
