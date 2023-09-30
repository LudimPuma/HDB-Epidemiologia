@extends('layout')
@section('content')

<div class="tables-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-style mb-30">

            <h2 class="mb-10" style="text-align: center">IAAS</h2>
            {{-- BOTONES MODAL --}}
            <div class="row">
                <div class="col-lg-4 text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#h_paciente">
                        Agregar Formulario
                    </button>
                </div>
                <div class="col-lg-4 text-center">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalreporte">
                        Generar Reporte
                    </button>
                </div>
                <div class="col-lg-4 text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalinforme">
                        Informe General
                    </button>
                </div>
            </div>
            <br>

        {{-- TABLA --}}
          <div class="table-wrapper table-responsive">
            <table class="table table-hover" id="dataTable" class="table">
                <thead class="table-primary">
                    <tr >
                        {{-- <th><h6>Nro. Formulario</h6></th> --}}
                        <th><h6>H. Clínico</h6></th>
                        <th><h6>Nombre del Paciente</h6></th>
                        <th><h6>Fecha de Llenado</h6></th>
                        <th><h6>Estado</h6></th>
                        <th><h6>Opciones</h6></th>
                      </tr>
                </thead>
                <tbody>
                    @foreach ($formularios as $formulario)
                        <tr>
                            {{-- <td class="min-width">
                                <p>{{ $formulario->cod_form_notificacion_p }}</p>
                            </td> --}}
                            <td class="min-width">
                                <p>{{ $formulario->h_clinico }}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->datopaciente->nombre_paciente }} {{ $formulario->datopaciente->ap_paterno }} {{ $formulario->datopaciente->ap_materno}}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->fecha_llenado }}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->estado }}</p>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('generar.pdf', $formulario->cod_form_notificacion_p) }}" class="btn" target="_blanck">
                                        <i class="lni lni-eye"></i>
                                    </a>

                                    {{-- PRUEBA --}}
                                    <form id="cambiarEstadoFormulario{{ $formulario->cod_form_notificacion_p }}" action="{{ route('cambiar.estado', $formulario->cod_form_notificacion_p) }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Usa PUT o POST según tu configuración -->
                                        <button type="button" class="btn btn-link text-danger cambiar-estado-formulario" data-codigo="{{ $formulario->cod_form_notificacion_p }}">
                                            <i class="lni lni-arrow-down"></i>
                                        </button>
                                        <input type="hidden" name="motivos_baja" value="{{ $formulario->motivos_baja }}">
                                        <!-- Agregar aquí los motivos actuales -->
                                        <p id="motivos-actuales">{{ $formulario->motivos_baja }}</p>
                                    </form>








                                    {{-- <form id="eliminarFormulario{{ $formulario->cod_form_notificacion_p }}" action="{{ route('eliminar.formulario', $formulario->cod_form_notificacion_p) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-link text-danger" onclick="confirmarEliminacion('{{ $formulario->cod_form_notificacion_p }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                    </form> --}}

                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- end table -->
          </div>
        </div>
        <!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
</div>

<!-- Modal de selección de fechas REPORTE-->
<div class="modal fade" id="modalreporte" tabindex="-1" role="dialog" aria-labelledby="modalreporte" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalreporte">Seleccionar Fechas para el Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('generar.reporte') }}" method="POST" target="_blank">
                    @csrf
                    <div class="form-group">
                        <label for="fecha">Fech:</label>
                        <input type="month" id="fecha" name="fecha" value="{{date("Y-m")}}" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
                <form action="{{ route('reporte.anual') }}" method="POST" target="_blank">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="a">Año:</label>
                            <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Modal de selección de fechas INFORME-->
<div class="modal fade" id="modalinforme" tabindex="-1" role="dialog" aria-labelledby="modalinforme" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalinforme">Seleccionar Fechas para el Informe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="{{ route('informe.anual') }}" method="POST" target="_blank">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="a">Año:</label>
                            <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Generar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
{{-- <script>
    function confirmarEliminacion(codigoFormulario) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción no se puede revertir.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('eliminarFormulario' + codigoFormulario).submit();
            }
        });
    }
</script> --}}

{{-- PRUEBA --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        function confirmarCambioEstado(codigoFormulario) {
            console.log(codigoFormulario);

            if (codigoFormulario) {
                // Obtener los motivos actuales y configurarlos en el elemento <p id="motivos-actuales">
                var elementoMotivosActuales = document.getElementById('motivos-actuales');
                var motivosActuales = elementoMotivosActuales.textContent; // Obtén los motivos actuales

                // Configura los motivos actuales en el mensaje de la ventana modal
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: 'Esta acción cambiará el estado a "baja".',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, cambiar estado',
                    cancelButtonText: 'Cancelar',
                    html:
                        '<p>Motivos de baja actuales:</p>' +
                        '<p>' + motivosActuales + '</p>' +
                        '<input id="motivos_baja" class="swal2-input" placeholder="Nuevos motivos de baja">',
                    preConfirm: function () {
                        return document.getElementById('motivos_baja').value;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Obtener los nuevos motivos de baja
                        var nuevosMotivos = result.value;

                        // Aquí puedes realizar la actualización del estado con nuevosMotivos si es necesario

                        Swal.fire(
                            'Estado cambiado',
                            'El estado del formulario se ha cambiado a "baja".',
                            'success'
                        ).then(function () {
                            // Actualizar la vista si es necesario
                            location.reload();
                        });
                    }
                });

                // Aquí debes configurar data-motivos en el momento adecuado
                var elemento = document.querySelector('.cambiar-estado-formulario[data-motivos="' + codigoFormulario + '"]');
                console.log(elemento);
                // elemento.setAttribute('data-motivos', motivosActuales);
            } else {
                console.error('Código de formulario no válido.');
                // Puedes mostrar un mensaje al usuario o realizar otra acción aquí
            }
        }

        // Agregar el evento click a los botones después de cargar el DOM
        var buttons = document.querySelectorAll('.cambiar-estado-formulario');
        buttons.forEach(function (button) {
            button.addEventListener('click', function () {
                var codigoFormulario = this.getAttribute('data-codigo');
                confirmarCambioEstado(codigoFormulario);
            });
        });
    });
</script>




{{-- <script>
function confirmarCambioEstado(codigoFormulario) {
    console.log(codigoFormulario);
    document.addEventListener("DOMContentLoaded", function () {

        if (codigoFormulario) {
            // Obtener los motivos actuales y configurarlos en el elemento <p id="motivos-actuales">
            var elementoMotivosActuales = document.getElementById('motivos-actuales');
            var motivosActuales = elementoMotivosActuales.textContent; // Obtén los motivos actuales

            // Configura los motivos actuales en el mensaje de la ventana modal
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción cambiará el estado a "baja".',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, cambiar estado',
                cancelButtonText: 'Cancelar',
                html:
                    '<p>Motivos de baja actuales:</p>' +
                    '<p>' + motivosActuales + '</p>' +
                    '<input id="motivos_baja" class="swal2-input" placeholder="Nuevos motivos de baja">',
                preConfirm: function () {
                    return document.getElementById('motivos_baja').value;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Obtener los nuevos motivos de baja
                    var nuevosMotivos = result.value;

                    // Aquí puedes realizar la actualización del estado con nuevosMotivos si es necesario

                    Swal.fire(
                        'Estado cambiado',
                        'El estado del formulario se ha cambiado a "baja".',
                        'success'
                    ).then(function () {
                        // Actualizar la vista si es necesario
                        location.reload();
                    });
                }
            });

            // Aquí debes configurar data-motivos en el momento adecuado
            var elemento = document.querySelector('.cambiar-estado-formulario[data-motivos="' + codigoFormulario + '"]');
            console.log(elemento);
            // elemento.setAttribute('data-motivos', motivosActuales);
        } else {
            console.error('Código de formulario no válido.');
            // Puedes mostrar un mensaje al usuario o realizar otra acción aquí
        }

    // if (codigoFormulario) {
    //     var elemento = document.getElementById('cambiarEstadoFormulario' + codigoFormulario);

    //     if (elemento) {
    //         var motivos = elemento.getAttribute('data-motivos');
    //         console.log(motivos);

    //     } else {
    //         console.error('Elemento no encontrado.');
    //         // Puedes mostrar un mensaje al usuario o realizar otra acción aquí
    //     }
    // } else {
    //     console.error('Código de formulario no válido.');
    //     // Puedes mostrar un mensaje al usuario o realizar otra acción aquí
    // }

});
}

</script> --}}








<!-- Agrega los archivos de DataTables y jQuery -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

{{-- DATATABLE --}}
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Traducción al español
            },
            "paging": true, // Activar paginación
            "searching": true, // Activar búsqueda
            "lengthChange": true, // Cambiar cantidad de resultados por página
            "pageLength": 10, // Cantidad de resultados por página
            "ordering": false // Desactivar la ordenación de la tabla
        });
    });

</script>
@endsection


