@extends('layout')
@section('title', 'Tablas | Antibioticos')
@section('guide','Tablas / Antibioticos')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container rounded p-4"  style="background-color: #a2231d">
            <div class="title-wrapper">
                <div class="row align-items-center">
                    <div class="mb-20">
                        @can('crud-create-medicamento')
                            <button class="btn btn-success btn-insertar" style="padding: 1%;">
                                <svg width="18" height="18" fill="#fff" class="bi bi-plus-circle me-2" viewBox="0 0 16 16" style="margin-top: -3px; ">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                                <strong>Agregar Antibiotico</strong>
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-style mb-30 p-4 text-black shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table mt-3 table-hover">
                            <thead class="text-white text-center" style="background-color: #198754;">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-muted">
                                @foreach($medicamentos as $medicamento)
                                <tr>
                                    <td>{{ $medicamento->nombre }}</td>
                                    <td class="text-center">
                                        @if ($medicamento->estado)
                                            <div class="badge bg-success bg-opacity-25 text-wrap text-success" style="width: 6rem;"><strong><em>Habilitado</em></strong></div>
                                        @else
                                            <div class="badge bg-danger bg-opacity-25 text-wrap text-danger" style="width: 7rem;"><strong><em>Deshabilitado</em></strong></div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @can('crud-edit-medicamento')
                                            <button class="btn-editar text-muted" style="background: none; border: none; text-decoration: none;" data-id="{{ $medicamento->cod_medicamento }}" data-nombre="{{ $medicamento->nombre }}" data-estado="{{ $medicamento->estado ? true : false }}" data-motivos="{{ $medicamento->motivos_baja }}">
                                                <svg width="17" height="17" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='currentColor';" style="stroke-width: 1; font-weight: lighter;">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                </svg>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Modificar -->
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarLabel">Modificar Antibiotico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-modificar" method="POST" action="{{ route('medicamento.update', ['medicamento' => ':id']) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                        @error('nombre')
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
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </select>
                        @error('estado')
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
                    <div class="form-group">
                        <label>Motivos de baja</label><br>
                        <textarea type="text" class="form-control"  id="motivos_baja" name="motivos_baja"></textarea>
                        @error('motivos_baja')
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" form="form-modificar" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal de Insertar -->
<div class="modal fade" id="modalInsertar" tabindex="-1" aria-labelledby="modalInsertarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalInsertarLabel">Insertar Antibiotico</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-insertar" method="POST" action="{{ route('medicamento.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                        @error('nombre')
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" form="form-insertar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // MODIFICAR
        $('.btn-editar').click(function() {
            var id = $(this).data('id');
            var actionUrl = $('#form-modificar').attr('action').replace(':id', id);
            var nombre = $(this).data('nombre');
            var estado = $(this).data('estado') ? '1' : '0';
            var motivo = $(this).data('motivos');

            actionUrl = actionUrl.replace(':id', id);

            $('#modalModificar #nombre').val(nombre);
            $('#modalModificar #estado').find('option[value="' + estado + '"]').prop('selected', true);
            $('#modalModificar #motivos_baja').val(motivo);
            $('#form-modificar').attr('action', actionUrl);
            $('#modalModificar').modal('show');
        });
        $('#form-modificar').on('submit', function(event) {
            var estado = $('#modalModificar #estado').val();
            var motivos = $('#modalModificar #motivos_baja').val();

            if (estado === '0' && motivos.trim() === '') {
                event.preventDefault();
                Swal.fire('Error', 'Debe proporcionar un motivo de baja.', 'error');
            }
        });
        var successMessage = '{{ Session::get('success') }}';
        if (successMessage) {
            Swal.fire('Éxito', successMessage, 'success');
        }
        var errors = @json($errors->all());

        if (errors.length > 0) {
            Swal.fire('Error', errors[0], 'error');
        }
        ///INSERTAR
        $('.btn-insertar').click(function() {
            $('#modalInsertar').modal('show');
        });
    });
</script>
@endsection
