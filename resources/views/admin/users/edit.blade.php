@extends('layout')
@section('title', 'Administración | Usuarios | Editar')
@section('guide', 'Administración / Usuarios / Editar')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="container bg-white rounded p-4 shadow-lg" >
            <div class="container bg-light rounded p-4 shadow-lg">
                <div class="title-wrapper">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-15 ml-30">
                            <div class="title ">
                                <h2>Editar Usuario</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('usuarios.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8">
                        <!-- Detalles de Persona -->
                        <div class="title-wrapper">
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-15 ">
                                    <div class="title">
                                        <h3 class="text-dark">Datos Personales</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <h3 class="text-light">Detalles de Persona</h3> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ci">CI:</label>
                                    <input type="number" name="ci" class="form-control" value="{{ $user->persona->ci }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="extension">Extensión de CI:</label>
                                    <select class="form-select" id="extension" name="extension" required>
                                        <option value="PT" {{ $user->persona->extension == 'PT' ? 'selected' : '' }}>Potosi</option>
                                        <option value="OR" {{ $user->persona->extension == 'OR' ? 'selected' : '' }}>Oruro</option>
                                        <option value="CB" {{ $user->persona->extension == 'CB' ? 'selected' : '' }}>Cochabamba</option>
                                        <option value="LP" {{ $user->persona->extension == 'LP' ? 'selected' : '' }}>La Paz</option>
                                        <option value="TJ" {{ $user->persona->extension == 'TJ' ? 'selected' : '' }}>Tarija</option>
                                        <option value="SC" {{ $user->persona->extension == 'SC' ? 'selected' : '' }}>Santa Cruz</option>
                                        <option value="BN" {{ $user->persona->extension == 'BN' ? 'selected' : '' }}>Beni</option>
                                        <option value="PA" {{ $user->persona->extension == 'PA' ? 'selected' : '' }}>Pando</option>
                                        <option value="CH" {{ $user->persona->extension == 'CH' ? 'selected' : '' }}>Chuquisaca</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $user->persona->fecha_nacimiento }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombres">Nombres:</label>
                                    <input type="text" name="nombres" class="form-control" value="{{ $user->persona->nombres }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos:</label>
                                    <input type="text" name="apellidos" class="form-control" value="{{ $user->persona->apellidos }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genero">Género:</label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="masculino" {{ $user->persona->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ $user->persona->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion">Direccion:</label>
                                    <input type="text" name="direccion" class="form-control" value="{{ $user->persona->direccion }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono">Telefono:</label>
                                    <input type="text" name="telefono" class="form-control" value="{{ $user->persona->telefono }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="celular">Celular:</label>
                                    <input type="text" name="celular" class="form-control" value="{{ $user->persona->celular }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_civil">Estado Civil:</label>
                                    <select class="form-select" id="estado_civil" name="estado_civil" required>
                                        <option value="Soltero(a)" {{ $user->persona->estado_civil == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                        <option value="Casado(a)" {{ $user->persona->estado_civil == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Divorcido(a)" {{ $user->persona->estado_civil == 'Divorcido(a)' ? 'selected' : '' }}>Divorcido(a)</option>
                                        <option value="Viudo(a)" {{ $user->persona->estado_civil == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8">
                        <div class="title-wrapper">
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-15 ">
                                    <div class="title">
                                        <h3 class="text-dark">Datos de Usuario</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Detalles de Usuario -->
                        {{-- <h3>Detalles de Usuario</h3> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" name="password" class="form-control" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profesion">Profesion:</label>
                                    <select class="form-select" id="profesion" name="profesion" required>
                                        <option value="Bachiller" {{ $user->profesion == 'Bachiller' ? 'selected' : '' }}>Bachiller</option>
                                        <option value="Licenciatura" {{ $user->profesion == 'Licenciatura' ? 'selected' : '' }}>Licenciado(a)</option>
                                        <option value="Ingenieria" {{ $user->profesion == 'Ingenieria' ? 'selected' : '' }}>Ingeniero(a)</option>
                                        <option value="Técnico Medio en Enfermería" {{ $user->profesion == 'Técnico Medio en Enfermería' ? 'selected' : '' }}>Técnico Medio en Enfermería</option>
                                        <option value="Doctor(a)" {{ $user->profesion == '"Doctor(a)' ? 'selected' : '' }}>Doctor(a)</option>
                                        <option value="Enfermero(a)" {{ $user->profesion == 'Enfermero(a)' ? 'selected' : '' }}>Enfermero(a)</option>
                                        <option value="Terapeuta" {{ $user->profesion == 'Terapeuta' ? 'selected' : '' }}>Terapeuta</option>
                                        <option value="Radiólogo(a)" {{ $user->profesion == 'Radiólogo(a)' ? 'selected' : '' }}>Radiólogo(a)</option>
                                        <option value="Farmacéutico(a)" {{ $user->profesion == 'Farmacéutico(a)' ? 'selected' : '' }}>Farmacéutico(a)</option>
                                        <option value="Nutricionista" {{ $user->profesion == 'Nutricionista' ? 'selected' : '' }}>Nutricionista</option>
                                        <option value="Psicólogo(a)" {{ $user->profesion == 'Psicólogo(a)' ? 'selected' : '' }}>Psicólogo(a)</option>
                                        <option value="Trabajador(a) Social" {{ $user->profesion == 'Trabajador(a) Social' ? 'selected' : '' }}>Trabajador(a) Social</option>
                                        <option value="Técnico de Laboratorio" {{ $user->profesion == 'Técnico de Laboratorio' ? 'selected' : '' }}>Técnico de Laboratorio</option>
                                        <option value="Administrador(a) de Salud" {{ $user->profesion == 'Administrador(a) de Salud' ? 'selected' : '' }}>Administrador(a) de Salud</option>
                                        <option value="Fisioterapeuta" {{ $user->profesion == 'Fisioterapeuta' ? 'selected' : '' }}>Fisioterapeuta</option>
                                        <option value="Terapeuta Ocupacional" {{ $user->profesion == 'Terapeuta Ocupacional' ? 'selected' : '' }}>Terapeuta Ocupacional</option>
                                        <option value="Dentista" {{ $user->profesion == 'Dentista' ? 'selected' : '' }}>Dentista</option>
                                        <option value="Asistente Médico" {{ $user->profesion == 'Asistente Médico' ? 'selected' : '' }}>Asistente Médico</option>
                                        <option value="Optometrista" {{ $user->profesion == 'Optometrista' ? 'selected' : '' }}>Optometrista</option>
                                        <option value="Logopeda" {{ $user->profesion == 'Logopeda' ? 'selected' : '' }}>Logopeda</option>
                                        <option value="Técnico en Imagenología" {{ $user->profesion == 'Técnico en Imagenología' ? 'selected' : '' }}>Técnico en Imagenología</option>
                                        <option value="Paramédico(a)" {{ $user->profesion == 'Paramédico(a)' ? 'selected' : '' }}>Paramédico(a)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="matricula_profesion">Matricula Profesion:</label>
                                    <input type="text" name="matricula_profesion" class="form-control" value="{{ $user->matricula_profesion }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="matricula_colegio">Matricula Colegio:</label>
                                    <input type="text" name="matricula_colegio" class="form-control" value="{{ $user->matricula_colegio }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cargo">Cargo:</label>
                                    <select class="form-select" id="cargo" name="cargo" required>
                                        <option value="Responsable" {{ $user->cargo == 'Responsable' ? 'selected' : '' }}>Responsable</option>
                                        <option value="Medico" {{ $user->cargo == 'Medico' ? 'selected' : '' }}>Medico</option>
                                        <option value="Asesor(a) Legal" {{ $user->cargo == 'Asesor(a) Legal' ? 'selected' : '' }}>Asesor(a) Legal</option>
                                        <option value="Enfermero(a)" {{ $user->cargo == 'Enfermero(a)' ? 'selected' : '' }}>Enfermero(a)</option>
                                        <option value="Asesor(a) Adjunto" {{ $user->cargo == 'Asesor(a) Adjunto' ? 'selected' : '' }}>Asesor(a) Adjunto</option>
                                        <option value="Auxiliar Administrativo" {{ $user->cargo == 'Auxiliar Administrativo' ? 'selected' : '' }}>Auxiliar Administrativo</option>
                                        <option value="Personal" {{ $user->cargo == 'Personal' ? 'selected' : '' }}>Personal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area">Area:</label>
                                    <input type="text" name="area" class="form-control" value="{{ $user->area }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="roles">Roles:</label>
                                    <select name="roles[]" class="form-control" id="roles" required data-placeholder="Seleccione una o mas roles" >
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nuevaimagen">Subir imagen</label>
                                    <input type="file" name="nuevaimagen" class="form-control-file" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="model_type" value="{{ $model_type }}">

                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.rtl.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}" />
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $( '#roles' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
        closeOnSelect: false,
    } );
    $( '#genero' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
    $( '#estado_civil' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
    $( '#profesion' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
    $( '#extension' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
    $( '#cargo' ).select2( {
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $( this ).data( 'placeholder' ),
    } );
</script>
@endsection




{{-- @extends('layout')

@section('content')
    <div class="container">
        <h1>User Edit</h1>

        <form method="POST" action="{{ route('usuarios.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="roles">Roles:</label>
                <select name="roles[]" id="rol" class="form-select" data-placeholder="Seleccione un rol">
                    @foreach ($roles as $role)
                        <option value=""></option>
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="model_type" value="App\User">

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.rtl.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}" />
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <script>
        $( '#rol' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            closeOnSelect: false,
        } );
    </script>
@endsection --}}
