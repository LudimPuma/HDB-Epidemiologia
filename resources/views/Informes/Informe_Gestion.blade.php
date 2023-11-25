@extends('layout')
@section('title', 'Informes | Por Gestión')
@section('guide','Informes / Por Gestión')
@section('content')
<style>
    .card-style{
        background-image: url("img/logohdb.png");
        background-size: 20%;
        background-repeat: no-repeat;
        background-position: center;
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
                        <div class="card-style mb-30  p-4  text-light shadow-lg" style="background-color: #00796B">
                            <div class="title-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-10 mb-15 ml-30">
                                        <div class="title text-muted">
                                            <h2 class="text-light">Por Gestión</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seleccion"><em>Seleccionar:</em></label>
                                        <select id="seleccion" name="seleccion" class="form-control custom-select">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a"><em>Año:</em></label>
                                        <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group text-center">
                                        <br>
                                        <button type="button" id="generar-btn" class="btn btn-outline-light"><strong>Generar Informe</strong></button>
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
        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;

        if (seleccion === "Resistencia_Bacteriana_IAAS") {
            document.getElementById("miFormulario").action = "{{ route('informe.anual') }}";
        }else if (seleccion === "Tuberculosis") {
            document.getElementById("miFormulario").action = "{{ route('informe.Tuberculosis.E_N_I') }}";
            console.log("prueba");
        } else if (seleccion === "") {
            console.log("vacio");
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción',
            });
            return;
        }
        document.getElementById("miFormulario").submit();
    });
</script>

@endsection
