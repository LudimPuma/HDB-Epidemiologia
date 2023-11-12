@extends('layout')
@section('title', 'Reporte | Por Mes')
@section('content')
<div class="tables-wrapper">
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 class="text-center">Reporte por Mes</h1>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="seleccion">Seleccionar:</label>
                        <select id="seleccion" name="seleccion" class="form-control">
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
                        <label for="fecha">Fecha:</label>
                        <input type="month" id="fecha" name="fecha" value="{{date("Y-m")}}" class="form-control" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-center">
                <button type="button" id="generar-btn" class="btn btn-success">Generar</button>
            </div>
        </div>
    </form>

    <p id="seleccionado"></p>
    <p id="fecha"></p>
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

        // Mostrar la selección y el año en los elementos <p>
        document.getElementById("seleccionado").innerText = "Selección: " + seleccion;
        document.getElementById("fecha").innerText = "Fecha: " + fecha;

        // Enviar el formulario
        document.getElementById("miFormulario").submit();
    });

</script>

@endsection
