@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">Detalles del Rol</div>
                    <div class="card-body">
                        <h4>Nombre del Rol: {{ $rol->name }}</h4>
                        <h4>Detalles: {{$rol->details}}</h4>
                        <h4>Permisos Asignados:</h4>
                        <ul>
                            @foreach ($permissions as $permission)
                                <li>
                                    {{ $permission->details }}
                                    @if ($rol->permissions->contains($permission))
                                        <span class="badge badge-success">Asignado</span>
                                    @else
                                        <span class="badge badge-danger">No asignado</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
