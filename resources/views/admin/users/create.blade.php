@extends('layout')

@section('content')
    <div class="container">
        <h1>Add User</h1>

        <form method="POST" action="{{ route('usuarios.store') }}" enctype="multipart/form-data">
            @csrf
            <h2 class="text-center">Person</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ci">CI:</label>
                        <input type="number" name="ci" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="extension">Extensión de CI:</label>extension
                        <select class="form-select" id="extension" name="extension" required data-placeholder="Seleccione un departamento">
                            <option></option>
                            <option value="PT">Potosi</option>
                            <option value="OR">Oruro</option>
                            <option value="CB">Cochabamba</option>
                            <option value="LP">La Paz</option>
                            <option value="TJ">Tarija</option>
                            <option value="SC">Santa Cruz</option>
                            <option value="BN">Beni</option>
                            <option value="PA">Pando</option>
                            <option value="CH">Chuquisaca</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" name="apellidos" class="form-control"required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="genero">Género:</label>
                        <select class="form-select" id="genero" name="genero" required data-placeholder="Seleccione el Género">
                            <option></option>
                            <option value="masculino">Masculino</option>
                            <option value="femenino">Femenino</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="direccion">Direccion:</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefono">Telefono:</label>
                        <input type="text" name="telefono" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="text" name="celular" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="estado_civil">Estado Civil:</label>
                        <select class="form-select" id="estado_civil" name="estado_civil" required data-placeholder="Seleccione un Estado Civil">
                            <option></option>
                            <option value="Soltero(a)">Soltero(a)</option>
                            <option value="Casado(a)">Casado(a)</option>
                            <option value="Divorcido(a)">Divorcido(a)</option>
                            <option value="Viudo(a)">Viudo(a)</option>
                        </select>
                    </div>
                </div>
            </div>

            <h2 class="text-center">User</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="profesion">Profesion:</label>
                                <select class="form-select " id="profesion" name="profesion" required data-placeholder="Seleccione un una Profesión">
                                    <option></option>
                                    <option value="Bachiller">Bachiller</option>
                                    <option value="Licenciado(a)">Licenciado(a)</option>
                                    <option value="Ingeniero(a)">Ingeniero(a)</option>
                                    <option value="Técnico Medio en Enfermería">Técnico Medio en Enfermería</option>
                                    <option value="Doctor(a)">Doctor(a)</option>
                                    <option value="Enfermero(a)">Enfermero(a)</option>
                                    <option value="Terapeuta">Terapeuta</option>
                                    <option value="Radiólogo(a)">Radiólogo(a)</option>
                                    <option value="Farmacéutico(a)">Farmacéutico(a)</option>
                                    <option value="Nutricionista">Nutricionista</option>
                                    <option value="Psicólogo(a)">Psicólogo(a)</option>
                                    <option value="Trabajador(a) Social">Trabajador(a) Social</option>
                                    <option value="Técnico de Laboratorio">Técnico de Laboratorio</option>
                                    <option value="Administrador(a) de Salud">Administrador(a) de Salud</option>
                                    <option value="Fisioterapeuta">Fisioterapeuta</option>
                                    <option value="Terapeuta Ocupacional">Terapeuta Ocupacional</option>
                                    <option value="Dentista">Dentista</option>
                                    <option value="Asistente Médico">Asistente Médico</option>
                                    <option value="Optometrista">Optometrista</option>
                                    <option value="Logopeda">Logopeda</option>
                                    <option value="Técnico en Imagenología">Técnico en Imagenología</option>
                                    <option value="Paramédico(a)">Paramédico(a)</option>
                                </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="matricula_profesion">Matricula Profesion:</label>
                        <input type="text" name="matricula_profesion" class="form-control" >
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="matricula_colegio">Matricula Colegio:</label>
                        <input type="text" name="matricula_colegio" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="cargo">Cargo:</label>
                        <select class="form-select " id="cargo" name="cargo" required data-placeholder="Seleccione un Cargo">
                            <option></option>
                            <option value="Responsable">Responsable</option>
                            <option value="Medico">Medico</option>
                            <option value="Asesor(a) Legal">Asesor(a) Legal</option>
                            <option value="Enfermero(a)">Enfermero(a)</option>
                            <option value="Asesor(a) Adjunto">Asesor(a) Adjunto</option>
                            <option value="Auxiliar Administrativo">Auxiliar Administrativo</option>
                            <option value="Personal">Personal</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="area">Area:</label>
                        <input type="text" name="area" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="roles">Roles:</label>
                        <select name="roles[]" class="form-control" id="roles" required data-placeholder="Seleccione una o mas roles">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="imagen">Subir imagen</label>
                        <input type="file" name="imagen" class="form-control-file" accept="image/*">
                    </div>
                </div>
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
