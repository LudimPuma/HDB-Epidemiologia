@extends('layout')
@section('title', 'Tablas | IAAS')
@section('guide', 'Tablas / IAAS')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container rounded p-4"  style="background-color: #a2231d">
            <div class="title-wrapper">
                <div class="row align-items-center">
                    <div class="mb-20">
                    </div>
                </div>
            </div>
            <div class="card-style mb-30  p-4  text-black shadow-lg">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable" class="table  mt-3  table-hover  ">
                            <thead class="text-white text-center" style="background-color: #198754;">
                                <tr>
                                    <th>H. Clínico</th>
                                    <th>Nombre del Paciente</th>
                                    <th class="d-none d-md-table-cell">Fecha de Llenado</th>
                                    <th class="d-none d-md-table-cell">Estado</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-muted">
                                @foreach ($patients as $patient)
                                    <tr>
                                        <td>{{ $patient['h_clinico'] }}</td>
                                        <td>{{ $patient['nombre'] }} {{ $patient['ap_paterno'] }} {{ $patient['ap_materno'] }}</td>
                                        <td class="d-none d-md-table-cell">{{ $patient['fecha'] }}</td>
                                        <td class="d-none d-md-table-cell text-center">
                                            @if ($patient['estado'] === 'alta')
                                                <div class="badge bg-success bg-opacity-25 text-wrap text-success" style="width: 6rem;"><strong><em>Habilitado</em></strong></div>
                                            @else
                                                <div class="badge bg-danger bg-opacity-25 text-wrap text-danger" style="width: 7rem;"><strong><em>Deshabilitado</em></strong></div>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @can('button-form-pdf-iaas')
                                                <a href="{{ route('generar.pdf', $patient['cod_form_notificacion_p']) }}" class="btn" target="_blank">
                                                    <svg width="17" height="17" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16" style="color: red; fill: red; opacity: 1;" onmouseover="this.style.fill='black'; this.style.opacity=1;" onmouseout="this.style.fill='red'; this.style.opacity=1;">
                                                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.380.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('edit-form-iaas')
                                                <button class="btn-editar text-muted" style="background: none; border: none; text-decoration: none;" data-id="{{ $patient['cod_form_notificacion_p']}}" data-h="{{$patient['h_clinico']}}" data-fecha_llenado="{{$patient['fecha'] }}" data-nombre="{{ $patient['nombre'] }} {{ $patient['ap_paterno'] }} {{ $patient['ap_materno'] }}" data-estado="{{ $patient['estado'] }}" data-motivos="{{ $patient['motivos_baja'] }}">
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
{{-- MODIFICAR --}}
<div class="modal fade" id="modalModificar" tabindex="-1" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalModificarLabel">Modificar Agente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-modificar" method="POST" action="{{ route('actualizar-estado.IAAS', ['formulario' => ':id']) }}">
                    @csrf
                    @method('PUT')
                    <p></p>
                    <div class="row">
                        <div class="col-md-4">
                            <label>H. Clinico</label><br>
                            <input type="number" class="form-control"  id="h" name="h" disabled>
                        </div>
                        <div class="col-md-8">
                            <label>Nombre</label><br>
                            <input type="text" class="form-control"  id="nombre" name="nombre" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control" required>
                            <option value="baja">Deshabilitado</option>
                            <option value="alta">Habilitado</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Motivos de baja</label><br>
                        <textarea type="text" class="form-control @error('motivos_baja') is-invalid @enderror" id="motivos_baja" name="motivos_baja"></textarea>
                        @error('motivos_baja')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
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

<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $('.btn-editar').on('click', function() {
        var id = $(this).data('id');
        var actionUrl = "{{ route('actualizar-estado.IAAS', ['formulario' => ':id']) }}";
        actionUrl = actionUrl.replace(':id', id);
        var h = $(this).data('h');
        var nombre = $(this).data('nombre');
        var estado = $(this).data('estado');
        var motivo = $(this).data('motivos');
        $('#modalModificar #h').val(h);
        $('#modalModificar #nombre').val(nombre);
        $('#modalModificar #estado').val(estado);
        $('#modalModificar #motivos_baja').val(motivo);

        $('#form-modificar').attr('action', actionUrl);
        if (estado === 'baja' && motivo === '') {
            Swal.fire('Error', 'Debe proporcionar un motivo de baja.', 'error');
        } else {
            $('#modalModificar').modal('show');
        }
    });

    $('#form-modificar').on('submit', function(event) {
        var estado = $('#estado').val();
        var motivos = $('#motivos_baja').val();

        if (estado === 'baja' && motivos.trim() === '') {
            event.preventDefault();
            Swal.fire('Error', 'Debe proporcionar un motivo de baja.', 'error');
        }
    });

    $(document).ready(function () {
        var successMessage = '{{ Session::get('success') }}';
        if (successMessage) {
            Swal.fire('Éxito', successMessage, 'success');
        }
    });
</script>

@endsection


