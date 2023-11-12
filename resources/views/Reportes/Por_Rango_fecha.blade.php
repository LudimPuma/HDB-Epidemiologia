@extends('layout')
@section('title', 'Reporte | Por Rango de Fecha')
@section('content')
<div class="tables-wrapper">
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 style="text-align: center">Reporte por Rango de Fechas</h1>
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
                        <label for="fecha">Fecha Inicio:</label>
                        <input type="date" id="fecha_e" name="fecha_e" value="" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fecha">Fecha Fin:</label>
                        <input type="date" id="fecha_s" name="fecha_s" value="" class="form-control" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-center">
                <button type="button" id="generar-btn" class="btn btn-success">Generar</button>
            </div>
        </div>
    </form>
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




        // Enviar el formulario
        document.getElementById("miFormulario").submit();
    });

</script>

@endsection
