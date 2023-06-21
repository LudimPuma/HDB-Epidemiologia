@extends('layout')
@section('content')
<section class="tab-components">
    <div class="container-fluid">
        <div class="form-elements-wrapper">
            <div class="row">
                <h1>Enfermedades de Notificacion Inmediata</h1>
                <form method="POST" action="{{ route('guardar_datos_form_Enf_Not_Inmediata') }}">
                    @csrf
                    {{-- datos paciente --}}
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <h6 class="mb-25">Datos Generales</h6>
                            <div class="col-lg-6">
                                <!-- Campo para N_clinico-->
                                <div class="form-group input-style-1">
                                    <label for="h_clinico">h_clinico:</label>
                                    <input type="text" class="form-control" id="h_clinico" name="h_clinico" required>
                                </div>
                                <!-- Campo para Nombres-->
                                <div class="form-group input-style-1">
                                    <label for="nombres">Nombres:</label>
                                    <input type="text" class="form-control" id="nombres" name="nombres" disabled>
                                </div>
                                <!-- Campo para ap_Paterno-->
                                <div class="form-group input-style-1">
                                    <label for="paterno">Apellido Paterno:</label>
                                    <input type="text" class="form-control" id="paterno" name="paterno" disabled>
                                </div>
                                <!-- Campo para ap_Materno-->
                                <div class="form-group input-style-1">
                                    <label for="materno">Apellido Materno:</label>
                                    <input type="text" class="form-control" id="materno" name="materno" disabled>
                                </div>
                            </div>
                            <div class="col-lg-6">

                            </div>


                        </div>
                    </div>
                    {{-- llenado del formulario --}}
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <h6 class="mb-25">Título</h6>
                            <div class="col-lg-6">
                                <!-- Campo para servicio -->
                                <div class="form-group select-style-1">
                                    <label for="servicio_inicio_sintomas">Servicio:</label>
                                    <div class="select-position">
                                        <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas" >
                                            @foreach ($servicios as $servicio)
                                                <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <!-- Campo para patologia -->
                                <div class="form-group select-style-1">
                                    <label for="servicio_inicio_sintomas">Patología:</label>
                                    <div class="select-position">
                                        <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas" >
                                            @foreach ($patologias as $patologia)
                                                <option value="{{ $patologia->id }}">{{ $patologia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <!-- Campo para Notificador -->
                                <div class="form-group input-style-1">
                                    <label for="notificador">Notificador:</label>
                                    <input type="text" class="form-control" id="notificador" name="notificador" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <!-- Campo para acciones -->
                                <div class="form-group input-style-1">
                                    <label for="acciones">Acciones:</label>
                                    <textarea class="form-control" id="acciones" name="acciones" required></textarea>
                                </div>
                                <!-- Campo para observaciones -->
                                <div class="form-group input-style-1">
                                    <label for="observaciones">Observaciones:</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
