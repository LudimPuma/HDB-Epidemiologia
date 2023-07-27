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
                    <div class="card-style mb-30">
                        <h6 class="mb-25">Datos Generales</h6>
                        <div class="row">
                            <div class="col-lg-3">
                                <!-- Nro Historial -->
                                <div class="form-group input-style-1">
                                    <label for="h_clinico">N° Historial:</label>
                                    <input type="text" class="form-control" id="h_clinico" name="h_clinico" value="{{ $id }}" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- Datos paciente -->
                                <div class="form-group input-style-1">
                                    <label for="dato_paciente">Nombre completo:</label>
                                    <input type="text" class="form-control" id="dato_paciente" name="dato_paciente" value="{{ $nombre }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- fecha-->
                                <div class="form-group input-style-1">
                                    <label for="fecha">Fecha</label>
                                    <input type="date" name="fecha" id="fecha" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- llenado del formulario --}}
                    <div class="card-style mb-30">
                        <h6 class="mb-25">Enfermedades de Notificacion Inmediata</h6>
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- Campo para servicio -->
                                <div class="form-group select-style-1">
                                    <label for="servicio_inicio_sintomas">Servicio:</label>
                                    <div class="select-position">
                                        <select class="form-control" id="servicio_inicio_sintomas" name="servicio_inicio_sintomas" >
                                            @foreach ($servicios as $servicio)
                                                <option value="{{ $servicio->cod_servicio }}">{{ $servicio->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!-- Campo para patologia -->
                                <div class="form-group select-style-1">
                                    <label for="patologia">Patología:</label>
                                    <div class="select-position">
                                        <select class="form-control" id="patologia" name="patologia" >
                                            @foreach ($patologias as $patologia)
                                                <option value="{{ $patologia->cod_patologia }}">{{ $patologia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <!-- Campo para Notificador -->
                                <div class="form-group input-style-1">
                                    <label for="notificador">Notificador:</label>
                                    <input type="text" class="form-control" id="notificador" name="notificador">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Campo para acciones -->
                                <div class="form-group input-style-1">
                                    <label for="acciones">Acciones:</label>
                                    <textarea class="form-control" id="acciones" name="acciones" ></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- Campo para observaciones -->
                                <div class="form-group input-style-1">
                                    <label for="observaciones">Observaciones:</label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" ></textarea>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.min.css">

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('js/mis-scripts.js') }}"></script>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>


// $(document).ready(function() {
//         $('#boton_guardar').click(function(event) {
//             event.preventDefault();

//             // Imprimir los datos del formulario en la consola
//             console.log($('form').serialize());

//             // Aquí puedes agregar el código para enviar el formulario al servidor
//             // ...
//         });
//     });
</script>
@endsection
