@extends('layout')
@section('content')
<div class="container-fluid">
    <div class="alert alert-success alert-dismissible fade show" id="mensaje-exito" role="alert" style="display: none;">
        Registro creado/actualizado exitosamente.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="row">
        <div class="col-md-6">
          <button class="btn btn-primary btn-insertar" data-target="#modalInsertar" data-bs-toggle="modal">Crear Agente Causal</button>
        </div>
    </div>

<div class="row">
    <div class="col">
        <table class="table table-hover align-middle" id="tabla-datos">
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


<!-- Modal de Insertar -->
<div class="modal fade" id="modalInsertar" tabindex="-1" aria-labelledby="modalInsertarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalInsertarLabel">Insertar Agente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-insertar" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombreInsertar">Nombre</label>
                        <input type="text" id="nombreInsertar" name="nombre" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script> --}}
<!-- Archivos CSS de DataTables -->
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">

<!-- Archivos JavaScript de DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabla-datos').DataTable({
            language: {
                // Personalizar textos en español
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    // Cambiar la ubicación del paginado
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            paging: true,
            // Otras opciones personalizadas aquí
        });

        // Evento modificar
        $(document).on('click', '.btn-editar', function() {
            var id = $(this).data('id');
            var actionUrl = $('#form-modificar').attr('action').replace(':id', id);
            var nombre = $(this).data('nombre');
            $('#modalModificar #nombre').val(nombre);
            $('#form-modificar').attr('action', actionUrl);
            $('#modalModificar').modal('show');
        });

        // Evento insertar
        $('.btn-insertar').on('click', function() {
            $('#modalInsertar').modal('show');
        });

        // Evento clic en botón "Guardar" del formulario de inserción
        $('#form-insertar').on('submit', function(event) {
            event.preventDefault();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: formData,
                dataType: 'json',
                success: function(response) {
                    var nombre = form.find('#nombreInsertar').val();
                    mostrarMensajeExito(nombre);
                    $('#modalInsertar').modal('hide');
                    // Recargar la tabla para mostrar el nuevo registro
                    $('#tabla-datos').DataTable().ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Evento abrir modal de inserción
        $('#modalInsertar').on('show.bs.modal', function() {
            // Limpiar el formulario de inserción
            $('#form-insertar')[0].reset();
        });

        // Función para mostrar la alerta de éxito y ocultarla después de un tiempo
        function mostrarMensajeExito(nombre) {
            $('#mensaje-exito').text('Registro "' + nombre + '" creado/actualizado exitosamente.');
            $('#mensaje-exito').fadeIn().delay(5000).fadeOut();
        }
    });
</script>
@endsection

