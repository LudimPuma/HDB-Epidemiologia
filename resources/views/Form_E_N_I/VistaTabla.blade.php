@extends('layout')
@section('content')

<div class="tables-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-style mb-30">
          <h4 class="mb-10">Enfermedades de Notificación Inmediata</h4>
          <div class="table-wrapper table-responsive">
            <table class="table table-hover" id="dataTable" class="table">
                <thead class="thead-dark">
                    <tr >
                        <th><h6>Nro. Formulario</h6></th>
                        <th><h6>H. Clínico</h6></th>
                        <th><h6>Nombre del Paciente</h6></th>
                        <th><h6>Fecha de Llenado</h6></th>
                        <th><h6>Opciones</h6></th>
                      </tr>
                </thead>
                <tbody>
                    @foreach ($formularios as $formulario)
                        <tr>
                            <td class="min-width">
                                <p>{{ $formulario->id_f_notificacion_inmediata }}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->h_clinico }}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->datopaciente->nombre_paciente }} {{ $formulario->datopaciente->ap_paterno }} {{ $formulario->datopaciente->ap_materno}}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->fecha }}</p>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('vista-previa-pdf', $formulario->id_f_notificacion_inmediata) }}" class="btn" target="_blanck">
                                        <i class="lni lni-eye"></i>
                                    </a>
                                    <form id="eliminarFormulario{{ $formulario->id_f_notificacion_inmediata }}" action="{{ route('eliminar.formulario.N-I', $formulario->id_f_notificacion_inmediata) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-link text-danger" onclick="confirmarEliminacion('{{ $formulario->id_f_notificacion_inmediata }}')">
                                            <i class="lni lni-trash-can"></i>
                                        </button>
                                    </form>
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
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script> --}}
<script>
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
</script>

<!-- Agrega los archivos de DataTables y jQuery -->
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css"> --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> --}}

<script>
$(document).ready(function () {
    $('#dataTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" // Opcional: Traducción al español
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


