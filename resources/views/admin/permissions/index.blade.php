@extends('layout')
@section('title', 'Administración | Permisos')
@section('guide', 'Administración / Permisos')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container rounded p-4"  style="background-color: #a2231d">
            <div class="title-wrapper">
                {{-- <div class="row align-items-center">
                        <div class="mb-60">
                            <a class="btn btn-outline-dark" href="{{ route('permissions.create') }}">Agregar Permisos</a>
                        </div>
                    </div>
                </div> --}}
                <div class="card-style mb-30  p-4  text-black shadow-lg">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table  mt-3  table-hover  ">
                                <thead class="text-white" style="background-color: #198754;">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Detalles</th>
                                        {{-- <th>Actions</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->details }}</td>
                                            {{-- <td class="text-center">
                                                <a href="{{ route('permissions.show', $permission->id) }}" style="text-decoration: none;" class="text-muted">
                                                    <svg width="17" height="17" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16" onmouseover="this.style.fill='#000';" onmouseout="this.style.fill='currentColor';" style="stroke-width: 1; font-weight: lighter;">
                                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                                    </svg>
                                                </a>
                                            </td> --}}
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
