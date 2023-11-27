@extends('layout')
@section('title', 'Administración | Roles | Detalles')
@section('guide', 'Administración / Roles / Detalles')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container bg-white rounded p-4 shadow-lg">
            <div class="container bg-light rounded p-4 shadow-lg">
                <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8" >
                    <h5 class="text-muted">Nombre del Rol: <strong><em><small>{{ $rol->name }}</small></em></strong>   </h5>
                    <h5 class="text-muted">Detalles: <strong><em><small>{{$rol->details}}</small></em></strong></h5>
                    <h5 class="text-muted">Permisos Asignados:</h5>
                    {{-- <ul>
                        @foreach ($rol->permissions as $permission)
                            <li>
                                {{ $permission->details }}
                            </li>
                        @endforeach

                    </ul> --}}
                    <div class="row">
                        @php
                            $permissionsCount = $rol->permissions->count();
                            $columnSize = ceil($permissionsCount / 2);
                        @endphp

                        @foreach ($rol->permissions->chunk($columnSize) as $chunk)
                            <div class="col-md-6">
                                <ul>
                                    @foreach ($chunk as $permission)
                                        <li>
                                            {{ $permission->details }}

                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
