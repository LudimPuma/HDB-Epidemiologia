@extends('layout')
@section('title', 'Reportes | Por Servicios')
@section('guide','Reportes / Por Servicios')
@section('content')
<style>
    .card-style {
        background-image: url("img/logohdb.png");
        background-size: 10%;
        background-repeat: no-repeat;
        background-position: calc(100% - 10px) 10px;
        /* background-position: top right; */
        padding: 100px;
    }
</style>
<div class="row ">
    <div class="col-12">
        <div class="container bg-white rounded p-4 shadow-lg" >
            <div class="container bg-light rounded p-4 shadow-lg">
                <div class="tables-wrapper">
                    <form id="miFormulario" action="#" method="POST" target="_blank">
                        @csrf
                        <div class="card-style mb-30 p-4 text-light shadow-lg" style="background-color: #00796B">
                            <div class="title-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-10 mb-15 ml-30">
                                        <div class="title text-muted">
                                            <h2 class="text-light">Por Servicios</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seleccion"><em>Seleccionar:</em></label>
                                        <select id="seleccion" name="seleccion" class="form-select">
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @can('button-form-reports-iaas')
                                                {{-- <option value="IAAS">IAAS</option> --}}
                                                <option value="IAAS" {{ old('seleccion') == 'IAAS' ? 'selected' : '' }}>IAAS</option>
                                            @endcan
                                            @can('button-form-reports-eni')
                                                <option value="Enf_Not_Inm" {{ old('seleccion') == 'Enf_Not_Inm' ? 'selected' : '' }}>Enfermedades de Notificación Inmediata</option>
                                            {{-- <option value="Enf_Not_Inm">Enfermedades de Notificación Inmediata</option> --}}
                                            @endcan
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a"> <em>Año:</em></label>
                                        {{-- <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" pattern="[0-9]+" title="Ingrese un año válido" required> --}}
                                        <input type="text" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                                        @error('a')
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
                                <div class="col-md-3">
                                    <div class="form-group text-center">
                                        <br>
                                        <button type="button" id="generar-btn" class="btn btn-outline-light"><strong>Generar Reporte</strong></button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById("generar-btn").addEventListener("click", function (event) {
        console.log("Botón Generar presionado");

        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;

        if (seleccion === "IAAS") {
            console.log("Seleccion IAAS");
            document.getElementById("miFormulario").action = "{{ route('reporte.anual') }}";
        } else if (seleccion === "Enf_Not_Inm") {
            console.log("Seleccion Enf_Not_Inm");
            document.getElementById("miFormulario").action = "{{ route('rep.anual.Enf.Not.Inmediata') }}";
        } else if (seleccion === "") {
            console.log("Selección vacía");
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción',
            });
            return;
        }
        if (isNaN(year) || year === "" || year <= '1950') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ingrese un año válido en el campo "Año"',
                });
                return;
            }
        console.log("Enviando formulario");
        document.getElementById("miFormulario").submit();
    });
</script>
@endsection
