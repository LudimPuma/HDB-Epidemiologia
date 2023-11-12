@extends('layout')
@section('title', 'Reporte | Por Servicios - Gestión')
@section('content')
<div class="tables-wrapper">
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 style="text-align: center">Reporte Por Servicios - Gestión</h1>
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="a">Año:</label>
                        <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
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
        var year = document.getElementById("a").value;

        if (seleccion === "IAAS") {
            // Si se selecciona "IAAS", cambiar el action del formulario a la ruta correspondiente
            document.getElementById("miFormulario").action = "{{ route('reporte.anual') }}";
        }else if (seleccion === "Enf_Not_Inm") {
            document.getElementById("miFormulario").action = "{{ route('rep.anual.Enf.Not.Inmediata') }}";
            console.log("prueba");
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
