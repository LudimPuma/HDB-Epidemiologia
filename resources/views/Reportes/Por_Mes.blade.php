@extends('layout')
@section('title', 'Reportes | Por Mes')
@section('guide','Reportes / Por Mes')
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
                                        <div class="title text-muted">
                                            <h2 class="text-light">Por Mes</h2>
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
                                        <label for="fecha"><em>Fecha:</em></label>
                                        <input type="month" id="fecha" name="fecha" value="{{date("Y-m")}}" class="form-control" required>
                                        @error('fecha')
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
        var seleccion = document.getElementById("seleccion").value;
        var fecha = document.getElementById("fecha").value;

        if (seleccion === "IAAS") {
            // Si se selecciona "IAAS", cambiar el action del formulario a la ruta correspondiente
            document.getElementById("miFormulario").action = "{{ route('generar.reporte') }}";
            console.log("IAAS");
        } else if (seleccion === "Enf_Not_Inm") {
            document.getElementById("miFormulario").action = "{{ route('formulario.generar') }}";
            console.log("Enf");
        } else if (seleccion === "") {
            console.log("vacio");
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción',
            });
            return; // Salir de la función sin hacer nada
        }
        // Enviar el formulario
        document.getElementById("miFormulario").submit();
    });

</script>

@endsection
