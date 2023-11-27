@extends('layout')
@section('title', 'Administración | Usuarios')
@section('guide', 'Administración / Usuarios')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container rounded p-4"  style="background-color: #a2231d">
            <div class="title-wrapper">
                <div class="row align-items-center">
                    <div class="mb-20">
                        <a class="btn btn-success" href="{{ route('usuarios.create') }}" style="padding: 1%;">
                            <svg width="18" height="18" fill="#fff" class="bi bi-plus-circle me-2" viewBox="0 0 16 16" style="margin-top: -3px; ">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            <strong>Agregar Usuario</strong>
                        </a>
                    </div>
                </div>
                <div class="card-style mb-30  p-4  text-black shadow-lg">
                    @if (session('success'))
                        <script src="{{asset('assets/js/sweetalert2/dist/sweetalert2.min.js')}}"></script>
                        <script>
                            var successMessage = '{{ Session::get('success') }}';
                            Swal.fire('Éxito', successMessage, 'success');
                        </script>
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table  mt-3  table-hover  ">
                                <thead class="text-white" style="background-color: #198754;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th class="d-none d-md-table-cell">Roles</th>
                                        <th class="d-none d-md-table-cell">Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="text-muted">
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->persona->nombres }} {{ $user->persona->apellidos}}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="d-none d-md-table-cell">
                                                @foreach ($user->roles as $role)
                                                    {{ $role->name }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="d-none d-md-table-cell text-center">
                                                @if ($user->estado === 'enable')
                                                    <div class="badge bg-success bg-opacity-25 text-wrap text-success" style="width: 6rem;"><strong><em>Habilitado</em></strong></div>
                                                @else
                                                    <div class="badge bg-danger bg-opacity-25 text-wrap text-danger" style="width: 7rem;"><strong><em>Deshabilitado</em></strong></div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('usuarios.show', $user->id) }}" style="text-decoration: none;" class="text-muted">
                                                    <svg width="17" height="17" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='currentColor';" style="stroke-width: 1; font-weight: lighter;">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                    </svg>
                                                </a>

                                                <a href="{{ route('usuarios.edit', $user->id) }}" style="text-decoration: none;" class="text-muted">
                                                    <svg width="17" height="17" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='currentColor';" style="stroke-width: 1; font-weight: lighter;">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                    </svg>
                                                </a>
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
</div>
@endsection
