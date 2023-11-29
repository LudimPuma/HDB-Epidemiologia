@extends('layout')
@section('title', 'Reportes | Por Trimestre')
@section('guide','Reportes / Por Trimestre')
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
                                            <h2 class="text-light">Trimestral por Servicio</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="seleccion"><em>Seleccione un servicio:</em></label>
                                            <select id="seleccion" name="seleccion" class="form-control custom-select">
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
                                            <label for="a"><em>Año:</em></label>
                                            <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control custom-input" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rango"><em>Trimestre:</em></label>
                                            <select name="rango" id="rango" class="form-control custom-select">
                                                <option value="" disabled selected>Seleccionar</option>
                                                <option value="primer_trimestre">Primer trimestre</option>
                                                <option value="segundo_trimestre">Segundo trimestre</option>
                                                <option value="tercer_trimestre">Tercer trimestre</option>
                                                <option value="cuarto_trimestre">Cuarto trimestre</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="button" id="generar-btn" class="btn btn-outline-light custom-button"><strong>Generar Informe</strong></button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.getElementById("generar-btn").addEventListener("click", function (event) {
        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;
        var trimestre = document.getElementById("rango").value;

        if (seleccion === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción en el campo "servicio"',
            });
            return;
        }
        if (trimestre === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción en el campo "trimestre"',
            });
            return;
        }
        if (isNaN(year) || year === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese un año válido en el campo "Año"',
            });
            return;
        }
        if (seleccion === "IAAS") {
            var pdfUrl = "{{ route('reporte.trimestral.semestral.por.servicio.IAAS') }}";
            window.open(pdfUrl, "_blank", "width=800,height=600");
        } else if (seleccion === "Enf_Not_Inm") {
            var pdfUrl = "{{ route('reporte.trimestre.semestre.por.servicio.E_N_I') }}";
            window.open(pdfUrl, "_blank", "width=800,height=600");
        }

        // Evita el envío del formulario
        event.preventDefault();
    });
</script> --}}

<script>
    document.getElementById("generar-btn").addEventListener("click", function (event) {
        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;
        var trimestre = document.getElementById("rango").value;
        if (seleccion === "") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Seleccione una opción en el campo "servicio"',
        });
            return;
        }
        if (trimestre === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción en el campo "trimestre"',
            });
            return;
        }
        if (isNaN(year) || year === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese un año válido en el campo "Año"',
            });
            return;
        }
        if (seleccion === "IAAS") {
            document.getElementById("miFormulario").action = "{{ route('reporte.trimestral.semestral.por.servicio.IAAS') }}";
        }else if (seleccion === "Enf_Not_Inm") {
            document.getElementById("miFormulario").action = "{{ route('reporte.trimestre.semestre.por.servicio.E_N_I') }}";
            console.log("prueba");
        }
        document.getElementById("miFormulario").submit();

    });
</script>
@endsection

