@extends('layout')
@section('content')
<div class="tables-wrapper">
    <br><br><br><br>

    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 style="text-align: center">Reporte por Rango de Fechas</h1>
            <br>
            <select id="seleccion" name="seleccion">
                <option value="" disabled selected>Seleccionar</option>
                <option value="IAAS">IAAS</option>
                <option value="Enf_Not_Inm">Enfermedades de Notificación Inmediata</option>
            </select>
            <div class="">
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha_e" name="fecha_e" value="" class="form-control" required>
                    a
                    <input type="date" id="fecha_s" name="fecha_s" value="" class="form-control" required>
                </div>
            </div>
            <br>
            <button type="button" id="generar-btn" class="btn btn-primary">Generar</button>
        </div>
    </form>

    <p id="seleccionado"></p>
    <p id="fecha"></p>
</div>
<script>
    document.getElementById("generar-btn").addEventListener("click", function (event) {
        var seleccion = document.getElementById("seleccion").value;
        // var fecha = document.getElementById("fecha").value;

        if (seleccion === "IAAS") {
            // Si se selecciona "IAAS", cambiar el action del formulario a la ruta correspondiente
            document.getElementById("miFormulario").action = "{{ route('reporte.por.rango.IAAS') }}";

        } else if (seleccion === "Enf_Not_Inm") {
            document.getElementById("miFormulario").action = "{{ route('reporte.por.rango.E_N_I') }}";

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


        // Enviar el formulario
        document.getElementById("miFormulario").submit();
    });

</script>

@endsection
