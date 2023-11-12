@extends('layout')
@section('title', 'Informe | Por Gestión')
@section('content')
<div class="tables-wrapper">
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 class="text-center">Informe por Gestión</h1>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seleccion">Seleccionar:</label>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="a">Año:</label>
                        <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="text-center">
                <button type="button" id="generar-btn" class="btn btn-primary">Generar</button>
            </div>
        </div>
    </form>
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
