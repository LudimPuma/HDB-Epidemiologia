@extends('layout')
@section('title', 'Informes | Por Semestre')
@section('guide','Informes / Por Semestre')
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
    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var errorMessage = @json(session('error'));
                if (errorMessage) {
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        </script>
    @endif

    <div class="col-12">
        <div class="container bg-white rounded p-4 shadow-lg" >
            <div class="container bg-light rounded p-4 shadow-lg">
                <div class="tables-wrapper">
                    <form id="miFormulario" action="#" method="POST" target="_blank">
                        @csrf
                        <div class="card-style mb-30  p-4  text-light shadow-lg" style="background-color: #424242">
                            <div class="title-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-10 mb-15 ml-30">
                                        <div class="title text-muted">
                                            <h2 class="text-light">Por Semestre</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="seleccion"><em>Seleccione un servicio:</em></label>
                                        <select id="seleccion" name="seleccion" class="form-select custom-select">
                                            <option value="" disabled selected>Seleccionar</option>
                                            @can('button-form-informe-iaas')
                                                <option value="Resistencia_Bacteriana_IAAS">Resistencia Bacteriana IAAS</option>
                                            @endcan
                                            @can('button-form-informe-eni')
                                                <option value="Tuberculosis">Tuberculosis</option>
                                            @endcan
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="a"><em>Año:</em></label>
                                        <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rango"><em>Semestre:</em></label>
                                        <select name="rango" id="rango" class="form-select custom-select">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="primer_semestre"> primer semestre</option>
                                            <option value="segundo_semestre"> segundo semestre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="text-center">
                                <button type="button" id="generar-btn" class="btn btn-outline-light custom-button"><strong>Generar</strong></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>

<script>
    document.getElementById("generar-btn").addEventListener("click", function (event) {
        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;
        var semestre = document.getElementById("rango").value;
        if (seleccion === "") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Seleccione una opción en el campo "seleccion"',
        });
            return;
        }

        // Verifica si se ha seleccionado una opción en el campo "semestre"
        if (semestre === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción en el campo "semestre"',
            });
            return;
        }

        // Verifica si se ha ingresado un año válido en el campo "a"
        if (isNaN(year) || year === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese un año válido en el campo "Año"',
            });
            return;
        }
        if (seleccion === "Resistencia_Bacteriana_IAAS") {
            // Si se selecciona "IAAS", cambiar el action del formulario a la ruta correspondiente
            // document.getElementById("miFormulario").action = "{{ route('reporte.anual') }}";
            document.getElementById("miFormulario").action = "{{ route('informe.semestral.trimestral.IAAS') }}";
        }else if (seleccion === "Tuberculosis") {
            document.getElementById("miFormulario").action = "{{ route('informe.trimestre.semestre.Tuberculosis.E_N_I') }}";
            console.log("prueba");
        }
        // Enviar el formulario
        document.getElementById("miFormulario").submit();
    });
</script>
@endsection
