@extends('layout')
@section('title', 'Informe | Trimestral')
@section('content')
<div class="tables-wrapper">
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 style="text-align: center">Informe Trimestral por Servicio</h1>
            <br>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="seleccion">Seleccione un servicio:</label>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="rango">Trimestre</label>
                        <select name="rango" id="rango" class="form-control custom-select">
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="primer_trimestre"> primer trimestre</option>
                            <option value="segundo_trimestre"> segundo trimestre</option>
                            <option value="tercer_trimestre"> tercer trimestre</option>
                            <option value="cuarto_trimestre"> cuarto trimestre</option>
                        </select>
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
        var trimestre = document.getElementById("rango").value;
        if (seleccion === "") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Seleccione una opción en el campo "seleccion"',
        });
            return;
        }

        // Verifica si se ha seleccionado una opción en el campo "trimestre"
        if (trimestre === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Seleccione una opción en el campo "trimestre"',
            });
            return;
        }

        // Verifica si se ha ingresado un año válido en el campo "a"
        if (isNaN(year) || year === "") {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese un año válido en el campo "Año"',
            });
            return;
        }
        if (seleccion === "Resistencia_Bacteriana_IAAS") {
            // Si se selecciona "IAAS", cambiar el action del formulario a la ruta correspondiente
            document.getElementById("miFormulario").action = "{{ route('informe.semestral.trimestral.IAAS') }}";
        }else if (seleccion === "Tuberculosis") {
            document.getElementById("miFormulario").action = "{{ route('informe.trimestre.semestre.Tuberculosis.E_N_I') }}";
            console.log("prueba");
        }
        // Enviar el formulario
        document.getElementById("miFormulario").submit();
    });
</script>
@endsection

