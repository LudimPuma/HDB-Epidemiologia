@extends('layout')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 offset-md">
            <div class="card">
                <br>
                <h2 class="text-center">Tipos de Infección</h2>
                <br>
                @can('crud-create-tipoInfeccion')
                    <div class="text-center">
                        <button class="btn btn-primary btn-insertar">Crear Tipo de infección</button>
                    </div>
                @endcan

                <div class="card-body">
                    <table id="dataTable"  class="table text-center mt-3 table-hover table-bordered table-striped">
                        <thead class="table-primary">
                            <tr>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tInfecciones as $tInfeccion)
                            <tr>
                                <td>{{ $tInfeccion->nombre }}</td>
                                <td >
                                    @if ($tInfeccion->estado)
                                        <div class="badge bg-success text-wrap" style="width: 7rem;">Habilitado</div>
                                    @else
                                        <div class="badge bg-danger text-wrap" style="width: 7rem;">Deshabilitado</div>
                                    @endif
                                </td>
                                <td>
                                    @can('crud-edit-tipoInfeccion')
                                        <button class="btn-editar" data-id="{{ $tInfeccion->cod_tipo_infeccion }}" data-nombre="{{ $tInfeccion->nombre }}" data-estado="{{ $tInfeccion->estado ? true : false }}" data-motivos="{{ $tInfeccion->motivos_baja }}" style="background: none; border: none;">
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
<!-- Modal de Modificar -->
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalModificarLabel">Modificar Agente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="form-modificar" method="POST" action="{{ route('tipoInfeccion.update', ['tipoInfeccion' => ':id']) }}">
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
        <h5 class="modal-title" id="modalInsertarLabel">Insertar Agente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-insertar" method="POST" action="{{ route('tipoInfeccion.store') }}">
          @csrf
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
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
        ///INSERTAR
        $('.btn-insertar').click(function() {
            $('#modalInsertar').modal('show');
        });
    });
</script>

@endsection
