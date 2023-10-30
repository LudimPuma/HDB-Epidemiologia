@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 offset-md">
            <div class="card">
                <br>
                <h2 class="text-center">Bacterias</h2>
                    @can('crud-create-bacteria')
                        <div class="text-center">
                            <button class="btn btn-primary btn-insertar">Agregar</button>
                        </div>
                    @endcan
                    <div class="card-body">
                        <table id="dataTable"  class="table text-center mt-3 table-hover table-bordered table-striped">
                            <thead class="table-primary">
                                <tr>
                                <th>Nombre</th>
                                <th>Medicamentos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bacterias as $bacteria)
                                <tr>
                                    <td>{{ $bacteria->nombre }}</td>
                                    <td>
                                        @foreach($bacteria->medicamentos as $medicamento)
                                            {{ $medicamento->nombre }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td >
                                        @if ($bacteria->estado)
                                            <div class="badge bg-success text-wrap" style="width: 5rem;">Habilitado</div>
                                        @else
                                            <div class="badge bg-danger text-wrap" style="width: 5rem;">Deshabilitado</div>
                                        @endif
                                    </td>
                                    <td>
                                        @can('crud-edit-bacteria')
                                            <button class="btn-editar" style="background: none; border: none; " data-id="{{ $bacteria->cod_bacterias}} " data-nombre="{{ $bacteria->nombre }}" data-estado="{{ $bacteria->estado }}" data-motivos="{{ $bacteria->motivos_baja }}" data-medicamentos="{{ json_encode($bacteria->medicamentos->pluck('cod_medicamento')) }}">
                                                <svg width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" style="color: #FFC107; fill: #FFC107;" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='#FFC107';">
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
{{-- MODIFICAR --}}
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarLabel">Modificar Agente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-modificar" method="POST" action="{{ route('bacteria.update', ['bacteria' => ':id']) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="0">Deshabilitado</option>
                            <option value="1">Habilitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Motivos de baja</label><br>
                        <textarea type="text" class="form-control"  id="motivos_baja" name="motivos_baja"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Medicamentos Asociados</label><br>
                        <div class="checkbox-table">
                            <div class="row">
                                @foreach($medicamentos as $index => $medicamento)
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="medicamentos[]" id="medicamento{{ $index }}" value="{{ $medicamento->cod_medicamento }}">
                                            <label class="form-check-label" for="medicamento{{ $index }}">{{ $medicamento->nombre }}</label>
                                        </div>
                                    </div>
                                    @if(($index + 1) % 4 === 0)
                                        </div>
                                        <div class="row">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label>Medicamentos Asociados</label><br>
                        @foreach($medicamentos as $medicamento)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="medicamentos[]" value="{{ $medicamento->cod_medicamento }}">
                                <label class="form-check-label">{{ $medicamento->nombre }}</label>
                            </div>
                        @endforeach
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" form="form-modificar" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- INSERTAR --}}
<div class="modal fade" id="modalInsertar" tabindex="-1" aria-labelledby="modalInsertarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalInsertarLabel">Insertar Agente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-insertar" method="POST" action="{{ route('bacteria.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Medicamentos Asociados</label><br>
                        <div class="checkbox-table">
                            <div class="row">
                                @foreach($medicamentos as $index => $medicamento)
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="medicamentos[]" id="medicamento{{ $index }}" value="{{ $medicamento->cod_medicamento }}">
                                            <label class="form-check-label" for="medicamento{{ $index }}">{{ $medicamento->nombre }}</label>
                                        </div>
                                    </div>
                                    @if(($index + 1) % 4 === 0)
                                        </div>
                                        <div class="row">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <label>Medicamentos Asociados</label><br>
                        @foreach($medicamentos as $medicamento)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="medicamentos[]" value="{{ $medicamento->cod_medicamento }}">
                                <label class="form-check-label">{{ $medicamento->nombre }}</label>
                            </div>
                        @endforeach
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" form="form-insertar" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
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

            $('#modalModificar #nombre').val(nombre);
            $('#modalModificar #estado').find('option[value="' + estado + '"]').prop('selected', true);
            $('#modalModificar #motivos_baja').val(motivo);
            $('#form-modificar').attr('action', actionUrl);
            $('#modalModificar').modal('show');
            // Obtener los medicamentos asociados a la bacteria
            var medicamentosAsociados = $(this).data('medicamentos');
            // Marcar los checkboxes de medicamentos según la asociación
            medicamentosAsociados.forEach(function(medicamentoId) {
                $('#modalModificar input[name="medicamentos[]"][value="' + medicamentoId + '"]').prop('checked', true);
            });
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
        ///INSERTAR
        $('.btn-insertar').click(function() {
            $('#modalInsertar').modal('show');
        });
    });
</script>

{{-- <script>
    $('.btn-editar').on('click', function() {
        var id = $(this).data('id');
        var actionUrl = "{{ route('bacteria.update', ['bacteria' => ':id']) }}";
        actionUrl = actionUrl.replace(':id', id);
        var nombre = $(this).data('nombre');
        var estado = $(this).data('estado');
        $('#modalModificar #nombre').val(nombre);
        $('#modalModificar #estado').val(estado);
        if (estado === 1) {
            $('#modalModificar #estado').val('1');
        } else {
            $('#modalModificar #estado').val('0');
        }
        // Obtener los medicamentos asociados a la bacteria
        var medicamentosAsociados = $(this).data('medicamentos');
        // Marcar los checkboxes de medicamentos según la asociación
        medicamentosAsociados.forEach(function(medicamentoId) {
            $('#modalModificar input[name="medicamentos[]"][value="' + medicamentoId + '"]').prop('checked', true);
        });
        $('#form-modificar').attr('action', actionUrl);
        $('#modalModificar').modal('show');
    });
    $('.btn-insertar').on('click', function() {
        $('#modalInsertar input[name="medicamentos[]"]').prop('checked', false);
        $('#modalInsertar').modal('show');
    });
    function actualizarTabla(data) {
        var tbody = $('#tabla-bacterias');
        tbody.empty();
        $.each(data, function(index, bacteria) {
            var row = $('<tr>');
            row.append('<td class="text-center">' + bacteria.cod_bacterias + '</td>');
            row.append('<td>' + bacteria.nombre + '</td>');
            row.append('<td class="text-center">Acciones</td>');
            tbody.append(row);
        });
    }
</script> --}}
@endsection
