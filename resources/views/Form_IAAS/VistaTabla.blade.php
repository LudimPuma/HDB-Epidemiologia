@extends('layout')
@section('content')

<div class="tables-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <div class="card-style mb-30">
          <h4 class="mb-10">IAAS</h4>
          <div class="table-wrapper table-responsive">
            <table class="table table-hover">
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
                                <p>{{ $formulario->cod_form_notificacion_p }}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->h_clinico }}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->datopaciente->nombre_paciente }} {{ $formulario->datopaciente->ap_paterno }} {{ $formulario->datopaciente->ap_materno}}</p>
                            </td>
                            <td class="min-width">
                                <p>{{ $formulario->fecha_llenado }}</p>
                            </td>
                            <td>
                                <div class="action">
                                    <a href="{{ route('generar.pdf', $formulario->cod_form_notificacion_p) }}" class="btn" target="_blanck">
                                        <i class="lni lni-eye"></i>
                                    </a>
                                    {{-- <a href="#" class="text-danger" onclick="confirmarEliminacion('{{ route('eliminar.formulario', $formulario->cod_form_notificacion_p) }}')">
                                        <i class="lni lni-trash-can"></i>
                                    </a> --}}
                                    <form id="eliminarFormulario{{ $formulario->cod_form_notificacion_p }}" action="{{ route('eliminar.formulario', $formulario->cod_form_notificacion_p) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-link text-danger" onclick="confirmarEliminacion('{{ $formulario->cod_form_notificacion_p }}')">
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


{{-- <div class="container">
    <h1>Formulario IAAS</h1>
    <table class="table table-hover">
        <thead class="">
            <tr>
                <th scope="col">Nro. Formulario</th>
                <th scope="col">H. Clínico</th>
                <th scope="col">Nombre del Paciente</th>
                <th scope="col">Fecha de Llenado</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>--}}
        {{-- <tbody>
            @foreach ($formularios as $formulario)
                <tr>
                    <td>{{ $formulario->cod_form_notificacion_p }}</td>
                    <td>{{ $formulario->h_clinico }}</td>
                    <td>{{ $formulario->DatoPaciente->nombre }}</td>
                    <td>{{ $formulario->fecha_llenado }}</td>
                    <td>
                        <a href="{{ route('formulario.show', $formulario->COD_FORM_NOTIFICACION_P) }}" class="btn btn-primary">Vista Previa</a>
                        <a href="{{ route('formulario.edit', $formulario->COD_FORM_NOTIFICACION_P) }}" class="btn btn-warning">Editar</a>
                        <!-- Agregar enlaces para dar baja y eliminar -->
                    </td>
                </tr>
            @endforeach
        </tbody> --}}
    {{-- </table>
</div> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.5/dist/sweetalert2.min.js"></script>
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
@endsection


