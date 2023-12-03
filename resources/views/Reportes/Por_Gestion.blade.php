
@extends('layout')
@section('title', 'Reportes | Por Gestión')
@section('guide','Reportes / Por Gestión')
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
                        <div class="card-style mb-30  p-4  text-light shadow-lg" style="background-color: #424242">
                            <div class="title-wrapper">
                                <div class="row align-items-center">
                                    <div class="col-md-10 mb-15 ml-30">
                                        <div class="title ">
                                            <h2 class="text-light">Por Gestión</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="seleccion"><em>Seleccionar:</em></label>
                                        <select id="seleccion" name="seleccion" class="form-select">
                                            <option value="" disabled selected>Seleccionar</option>
                                            @can('button-form-reports-iaas')
                                                <option value="IAAS">IAAS</option>
                                            @endcan
                                            @can('button-form-reports-eni')
                                                <option value="Enf_Not_Inm">Enfermedades de Notificación Inmediata</option>
                                            @endcan
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a"> <em>Año:</em></label>
                                        <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
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
        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;
        if (isNaN(year) || year === "" || year <= '1950') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese un año válido en el campo "Año"',
            });
            return;
        }
        if (seleccion === "IAAS") {
            document.getElementById("miFormulario").action = "{{ route('reporte.anual.por.mes.IAAS') }}";
        }else if (seleccion === "Enf_Not_Inm") {
            document.getElementById("miFormulario").action = "{{ route('reporte.anual.Enf.Not.Inmediata') }}";
            console.log("X");
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
