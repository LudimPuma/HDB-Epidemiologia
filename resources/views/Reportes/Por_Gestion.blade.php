@extends('layout')
@section('content')
<div class="tables-wrapper">
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 class="text-center">Reporte por Gestión</h1>
            <br>
            <div class="row">
                <div class="">
                    <select id="seleccion" name="seleccion">
                        <option value="" disabled selected>Seleccionar</option>
                        @can('button-form-reports-iaas')
                            <option value="IAAS">IAAS</option>
                        @endcan
                        @can('button-form-reports-eni')
                            <option value="Enf_Not_Inm">Enfermedades de Notificación Inmediata</option>
                        @endcan

                    </select>
                </div>
                <div class="">
                    <div class="form-group">
                        <label for="a">Año:</label>
                        <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                    </div>
                </div>
            </div>

            <br>
            <button type="button" id="generar-btn" class="btn btn-primary">Generar</button>
        </div>
    </form>
</div>

<script>
    document.getElementById("generar-btn").addEventListener("click", function (event) {
        var seleccion = document.getElementById("seleccion").value;
        var year = document.getElementById("a").value;

        if (seleccion === "IAAS") {
            document.getElementById("miFormulario").action = "{{ route('reporte.anual.por.mes.IAAS') }}";
        }else if (seleccion === "Enf_Not_Inm") {
            document.getElementById("miFormulario").action = "{{ route('reporte.anual.Enf.Not.Inmediata') }}";
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
