@extends('layout')

@section('content')
<div class="container">
    <h1 class="text-center">Detalles del Usuario</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Detalles de la Persona</h2>
            <ul>
                <li><strong>CI:</strong> {{ $user->persona->ci }}</li>
                <li><strong>Extensión de CI:</strong> {{ $user->persona->extension }}</li>
                <li><strong>Nombres:</strong> {{ $user->persona->nombres }}</li>
                <li><strong>Apellidos:</strong> {{ $user->persona->apellidos }}</li>
                <li><strong>Género:</strong> {{ $user->persona->genero }}</li>
                <li><strong>Dirección:</strong> {{ $user->persona->direccion }}</li>
                <li><strong>Teléfono:</strong> {{ $user->persona->telefono }}</li>
                <li><strong>Celular:</strong> {{ $user->persona->celular }}</li>
                <li><strong>Fecha de Nacimiento:</strong> {{ $user->persona->fecha_nacimiento }}</li>
                <li><strong>Edad:</strong> {{ \Carbon\Carbon::parse($user->persona->fecha_nacimiento)->age }} años</li>
                <li><strong>Estado Civil:</strong> {{ $user->persona->estado_civil }}</li>
            </ul>
        </div>

        <div class="col-md-6">
            <h2>Detalles del Usuario</h2>
            <ul>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Estado:</strong> {{ $user->estado }}</li>
                <li><strong>Profesión:</strong> {{ $user->profesion }}</li>
                <li><strong>Matrícula Profesión:</strong> {{ $user->matricula_profesion }}</li>
                <li><strong>Matrícula Colegio:</strong> {{ $user->matricula_colegio }}</li>
                <li><strong>Cargo:</strong> {{ $user->cargo }}</li>
                <li><strong>Área:</strong> {{ $user->area }}</li>
                <li><strong>Roles:</strong>
                    @if ($user->getRoleNames()->count() > 0)
                        @foreach ($user->getRoleNames() as $role)
                            {{ $role }},
                        @endforeach
                    @else
                        El usuario no tiene roles asignados.
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
