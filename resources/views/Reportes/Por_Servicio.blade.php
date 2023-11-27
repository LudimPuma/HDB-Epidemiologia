@extends('layout')
@section('title', 'Reportes | Por Servicios')
@section('guide','Reportes / Por Servicios')
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
                                        <select id="seleccion" name="seleccion" class="form-control">
                                            <option value="" disabled selected>Seleccione una opción</option>
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
                                        {{-- <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" pattern="[0-9]+" title="Ingrese un año válido" required> --}}
                                        <input type="text" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
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
                            {{-- <br>
                            <div class="text-center ">
                                <button type="button" id="generar-btn" class="btn btn-outline-light"><strong>Generar</strong></button>
                            </div> --}}
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
    }  else if (!/^\d{4}$/.test(year.trim())) {
        console.log("Año no válido");
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ingrese un año válido (formato: YYYY)',
        });
        return;
    }

    // Enviar el formulario
    console.log("Enviando formulario");
    document.getElementById("miFormulario").submit();
});


    // document.getElementById("generar-btn").addEventListener("click", function (event) {
    //     var seleccion = document.getElementById("seleccion").value;
    //     var year = document.getElementById("a").value;

    //     if (seleccion === "IAAS") {
    //         // Si se selecciona "IAAS", cambiar el action del formulario a la ruta correspondiente
    //         document.getElementById("miFormulario").action = "{{ route('reporte.anual') }}";
    //     }else if (seleccion === "Enf_Not_Inm") {
    //         document.getElementById("miFormulario").action = "{{ route('rep.anual.Enf.Not.Inmediata') }}";
    //         console.log("prueba");
    //     } else if (seleccion === "") {
    //         console.log("vacio");
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Error',
    //             text: 'Seleccione una opción',
    //         });
    //         return; // Salir de la función sin hacer nada
    //     } else if (year.trim() === "") { // Agrega una validación para el campo de año
    //         console.log("año vacio");
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Error',
    //             text: 'Ingrese un año válido',
    //         });
    //         return; // Salir de la función sin hacer nada
    //     }
    //     // Enviar el formulario
    //     document.getElementById("miFormulario").submit();
    // });
</script>
@endsection
