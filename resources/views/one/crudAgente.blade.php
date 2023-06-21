@extends('layout')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th class="text-center">Código</th>
            <th>Nombre</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($agentes as $agente)
          <tr>
            <td class="text-center">{{ $agente->cod_agente_causal }}</td>
            <td>{{ $agente->nombre }}</td>
            <td class="text-center">
              <button class="btn btn-info btn-editar" data-id="{{ $agente->cod_agente_causal }} " data-nombre="{{ $agente->nombre }}">Editar</button>
              {{-- <button class="btn btn-danger btn-eliminar" data-id="{{ $agente->cod_agente_causal }}">Eliminar</button> --}}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="text-center">
        <button class="btn btn-primary btn-insertar">Crear Agente</button>
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
          <form id="form-modificar" method="POST" action="{{ route('agente.update', ['agente' => ':id']) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" class="form-control" required>
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
<!-- Modal de Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEliminarLabel">Eliminar Agente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que deseas eliminar este agente?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <form id="form-eliminar" method="POST" action="{{ route('agente.destroy', $agente->cod_agente_causal) }}">
          @csrf
          @method('DELETE')
          <button type="submit" form="form-eliminar" class="btn btn-danger">Eliminar</button>
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
        <form id="form-insertar" method="POST" action="{{ route('agente.store') }}">
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Evento modificar
    $('.btn-editar').on('click', function() {
        var id = $(this).data('id');
        var actionUrl = $('#form-modificar').attr('action').replace(':id', id);
        var nombre = $(this).data('nombre');
        $('#modalModificar #nombre').val(nombre);
        $('#form-modificar').attr('action', actionUrl);
        $('#modalModificar').modal('show');
      //ajax
    });

    // Evento Eliminar
    $('.btn-eliminar').on('click', function() {
      var id = $(this).data('id');
      if (confirm('¿Estás seguro de que deseas eliminar este agente?')) {
        //ajax
      }
    });

    // Evento insertar
    $('.btn-insertar').on('click', function() {
      $('#modalInsertar').modal('show');
    });
  });
</script>
@endsection
