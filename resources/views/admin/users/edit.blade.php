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
                                <h2>Datos Personales</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('usuarios.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ci"><strong><small>CI:</small></strong></label>
                                    <input type="text" name="ci" class="form-control" value="{{ old('ci', $user->persona->ci) }}" required>
                                    @error('ci')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="extension"><strong><small>Extensión de CI:</small></strong></label>
                                    <select class="form-select" id="extension" name="extension" required>
                                        <option value="PT" {{ old('extension', $user->persona->extension) == 'PT' ? 'selected' : '' }}>Potosi</option>
                                        <option value="OR" {{ old('extension', $user->persona->extension) == 'OR' ? 'selected' : '' }}>Oruro</option>
                                        <option value="CB" {{ old('extension', $user->persona->extension) == 'CB' ? 'selected' : '' }}>Cochabamba</option>
                                        <option value="LP" {{ old('extension', $user->persona->extension) == 'LP' ? 'selected' : '' }}>La Paz</option>
                                        <option value="TJ" {{ old('extension', $user->persona->extension) == 'TJ' ? 'selected' : '' }}>Tarija</option>
                                        <option value="SC" {{ old('extension', $user->persona->extension) == 'SC' ? 'selected' : '' }}>Santa Cruz</option>
                                        <option value="BN" {{ old('extension', $user->persona->extension) == 'BN' ? 'selected' : '' }}>Beni</option>
                                        <option value="PA" {{ old('extension', $user->persona->extension) == 'PA' ? 'selected' : '' }}>Pando</option>
                                        <option value="CH" {{ old('extension', $user->persona->extension) == 'CH' ? 'selected' : '' }}>Chuquisaca</option>
                                    </select>
                                    @error('extension')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fecha_nacimiento"><strong><small>Fecha de Nacimiento:</small></strong></label>
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $user->persona->fecha_nacimiento) }}" required>
                                    @error('fecha_nacimiento')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombres"><strong><small>Nombres:</small></strong></label>
                                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $user->persona->nombres) }}" required>
                                    @error('nombres')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidos"><strong><small>Apellidos:</small></strong></label>
                                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $user->persona->apellidos) }}" required>
                                    @error('apellidos')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="genero"><strong><small>Género:</small></strong></label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="masculino" {{ old('genero', $user->persona->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="femenino" {{ old('genero', $user->persona->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                    @error('genero')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="direccion"><strong><small>Direccion:</small></strong></label>
                                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $user->persona->direccion) }}" required>
                                    @error('direccion')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefono"><strong><small>Telefono:</small></strong></label>
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->persona->telefono) }}">
                                    @error('telefono')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="celular"><strong><small>Celular:</small></strong></label>
                                    <input type="number" name="celular" class="form-control" value="{{ old('celular', $user->persona->celular) }}" required>
                                    @error('celular')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado_civil"><strong><small>Estado Civil:</small></strong></label>
                                    <select class="form-select" id="estado_civil" name="estado_civil" required>
                                        <option value="Soltero(a)" {{ old('estado_civil', $user->persona->estado_civil) == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                        <option value="Casado(a)" {{ old('estado_civil', $user->persona->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Divorcido(a)" {{ old('estado_civil', $user->persona->estado_civil) == 'Divorcido(a)' ? 'selected' : '' }}>Divorcido(a)</option>
                                        <option value="Viudo(a)" {{ old('estado_civil', $user->persona->estado_civil) == 'Viudo(a)' ? 'selected' : '' }}>Viudo(a)</option>
                                    </select>
                                    @error('estado_civil')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="profesion"><strong><small>Profesion:</small></strong></label>
                                    <select class="form-select" id="profesion" name="profesion" required>
                                        <option value="Bachiller" {{ old('profesion', $user->profesion) == 'Bachiller' ? 'selected' : '' }}>Bachiller</option>
                                        <option value="Licenciatura" {{ old('profesion', $user->profesion) == 'Licenciatura' ? 'selected' : '' }}>Licenciado(a)</option>
                                        <option value="Ingenieria" {{ old('profesion', $user->profesion) == 'Ingenieria' ? 'selected' : '' }}>Ingeniero(a)</option>
                                        <option value="Técnico Medio en Enfermería" {{ old('profesion', $user->profesion) == 'Técnico Medio en Enfermería' ? 'selected' : '' }}>Técnico Medio en Enfermería</option>
                                        <option value="Doctor(a)" {{ old('profesion', $user->profesion) == '"Doctor(a)' ? 'selected' : '' }}>Doctor(a)</option>
                                        <option value="Enfermero(a)" {{ old('profesion', $user->profesion) == 'Enfermero(a)' ? 'selected' : '' }}>Enfermero(a)</option>
                                        <option value="Terapeuta" {{ old('profesion', $user->profesion) == 'Terapeuta' ? 'selected' : '' }}>Terapeuta</option>
                                        <option value="Radiólogo(a)" {{ old('profesion', $user->profesion) == 'Radiólogo(a)' ? 'selected' : '' }}>Radiólogo(a)</option>
                                        <option value="Farmacéutico(a)" {{ old('profesion', $user->profesion) == 'Farmacéutico(a)' ? 'selected' : '' }}>Farmacéutico(a)</option>
                                        <option value="Nutricionista" {{ old('profesion', $user->profesion) == 'Nutricionista' ? 'selected' : '' }}>Nutricionista</option>
                                        <option value="Psicólogo(a)" {{ old('profesion', $user->profesion) == 'Psicólogo(a)' ? 'selected' : '' }}>Psicólogo(a)</option>
                                        <option value="Trabajador(a) Social" {{ old('profesion', $user->profesion) == 'Trabajador(a) Social' ? 'selected' : '' }}>Trabajador(a) Social</option>
                                        <option value="Técnico de Laboratorio" {{ old('profesion', $user->profesion) == 'Técnico de Laboratorio' ? 'selected' : '' }}>Técnico de Laboratorio</option>
                                        <option value="Administrador(a) de Salud" {{ old('profesion', $user->profesion) == 'Administrador(a) de Salud' ? 'selected' : '' }}>Administrador(a) de Salud</option>
                                        <option value="Fisioterapeuta" {{ old('profesion', $user->profesion) == 'Fisioterapeuta' ? 'selected' : '' }}>Fisioterapeuta</option>
                                        <option value="Terapeuta Ocupacional" {{ old('profesion', $user->profesion) == 'Terapeuta Ocupacional' ? 'selected' : '' }}>Terapeuta Ocupacional</option>
                                        <option value="Dentista" {{ old('profesion', $user->profesion) == 'Dentista' ? 'selected' : '' }}>Dentista</option>
                                        <option value="Asistente Médico" {{ old('profesion', $user->profesion) == 'Asistente Médico' ? 'selected' : '' }}>Asistente Médico</option>
                                        <option value="Optometrista" {{ old('profesion', $user->profesion) == 'Optometrista' ? 'selected' : '' }}>Optometrista</option>
                                        <option value="Logopeda" {{ old('profesion', $user->profesion) == 'Logopeda' ? 'selected' : '' }}>Logopeda</option>
                                        <option value="Técnico en Imagenología" {{ old('profesion', $user->profesion) == 'Técnico en Imagenología' ? 'selected' : '' }}>Técnico en Imagenología</option>
                                        <option value="Paramédico(a)" {{ old('profesion', $user->profesion) == 'Paramédico(a)' ? 'selected' : '' }}>Paramédico(a)</option>
                                        <option value="Bacteriólogo(a)" {{ old('profesion', $user->profesion) == 'Bacteriólogo(a)' ? 'selected' : '' }}>Bacteriólogo(a)</option>
                                    </select>
                                    @error('profesion')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="matricula_profesion"><strong><small>Matricula Profesion:</small></strong></label>
                                    <input type="text" name="matricula_profesion" class="form-control" value="{{ old('matricula_profesion', $user->matricula_profesion) }}">
                                    @error('matricula_profesion')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="matricula_colegio"><strong><small>Matricula Colegio:</small></strong></label>
                                    <input type="text" name="matricula_colegio" class="form-control" value="{{ old('matricula_colegio', $user->matricula_colegio) }}">
                                    @error('matricula_colegio')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="imagen"><strong><small>Subir imagen</small></strong></label>
                                    <input type="file" name="nuevaimagen" class="form-control-file" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="title-wrapper">
                        <div class="row align-items-center">
                            <div class="col-md-10 mb-15 ml-30">
                                <div class="title text-muted">
                                    <h2 class="">Datos de Usuario</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-style mb-30  p-4  text-dark shadow-lg" style="background-color: #9ad0a8">
                        <div class="row">
                            <div class="col-md-8 mx-auto mb-4">
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Nombre de Usuario" class="form-control" value="{{ old('email', $user->email) }}" required>
                                    <label for="email"><strong><small><em>Requerido. 150 caracteres como maximo. Unicamente letras, digitos y @/./-/_</em></small></strong></label>
                                    @error('email')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mx-auto mb-4">
                                <div class="form-group">
                                    <input type="password" name="password" placeholder="Contraseña" class="form-control" >
                                    <ul class="ms-4">
                                        <li>&#8226; <strong><small><em>La contraseña debe contener como minimo 8 caracteres</em></small></strong></li>
                                        <li>&#8226; <strong><small><em>Es recomendable una combinación de letras,numeros y simbolos</em></small></strong></li>
                                    </ul>
                                    @error('password')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mx-auto mb-3">
                                <div class="form-group">
                                    <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" class="form-control" >
                                    <label for="password_confirmation"></label><strong><small><em>Escriba nuevamente la contraseña</em></small></strong>
                                    @error('password_confirmation')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cargo"><strong><small><em>Cargo:</em></small></strong></label>
                                    <input type="text" name="cargo" class="form-control" value="{{ old('cargo', $user->cargo) }}" required>

                                    {{-- <select class="form-select" id="cargo" name="cargo" required>
                                        <option value="Responsable" {{ old('cargo', $user->cargo) == 'Responsable' ? 'selected' : '' }}>Responsable</option>
                                        <option value="Medico" {{ old('cargo', $user->cargo) == 'Medico' ? 'selected' : '' }}>Medico</option>
                                        <option value="Asesor(a) Legal" {{ old('cargo', $user->cargo) == 'Asesor(a) Legal' ? 'selected' : '' }}>Asesor(a) Legal</option>
                                        <option value="Enfermero(a)" {{ old('cargo', $user->cargo) == 'Enfermero(a)' ? 'selected' : '' }}>Enfermero(a)</option>
                                        <option value="Asesor(a) Adjunto" {{ old('cargo', $user->cargo) == 'Asesor(a) Adjunto' ? 'selected' : '' }}>Asesor(a) Adjunto</option>
                                        <option value="Auxiliar Administrativo" {{ old('cargo', $user->cargo) == 'Auxiliar Administrativo' ? 'selected' : '' }}>Auxiliar Administrativo</option>
                                        <option value="Personal" {{ old('cargo', $user->cargo) == 'Personal' ? 'selected' : '' }}>Personal</option>
                                    </select> --}}
                                    @error('cargo')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="area"><strong><small><em>Área de trabajo:</em></small></strong></label>
                                    <input type="text" name="area" class="form-control" value="{{ old('area', $user->area) }}" required>
                                    @error('area')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="roles"><strong><small><em>Roles:</em></small></strong></label>
                                    <select name="roles[]" class="form-control" id="roles" required data-placeholder="Seleccione uno o más roles">
                                        <option value=""></option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->getRoleNames()->toArray())) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <select name="roles[]" class="form-control" id="roles" required data-placeholder="Seleccione una o mas roles" >
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select> --}}
                                    @error('roles')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado"><strong><small><em>Estado:</em></small></strong></label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="enable" {{ old('estado', $user->estado) == 'enable' ? 'selected' : '' }}>Habilitado</option>
                                        <option value="disable" {{ old('estado', $user->estado) == 'disable' ? 'selected' : '' }}>Deshabilitado</option>
                                    </select>
                                    @error('estado')
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                var errorMessage = @json($message);
                                                if (errorMessage) {
                                                    Swal.fire('Error', errorMessage, 'error');
                                                }
                                            });
                                        </script>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="model_type" value="{{ $model_type }}">
                    <div class="mb-2 d-grid gap-2 col-6 mx-auto">
                        <button id="submit-button" type="submit" class="btn btn-success ">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.rtl.min.css')}}" />
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}" />
<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('assets/js/sweetalert2/dist/sweetalert2.min.js') }}"></script>
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
