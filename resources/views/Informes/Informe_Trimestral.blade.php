@extends('layout')
@section('content')
<div class="tables-wrapper">
    <br><br><br><br>
    <form id="miFormulario" action="#" method="POST" target="_blank">
        @csrf
        <div class="card-style mb-30">
            <h1 style="text-align: center">Reporte Trimestral por Servicio</h1>
            <br>
            <select id="seleccion" name="seleccion">
                <option value="">Seleccione</option>
                <option value="Resistencia_Bacteriana_IAAS">Resistencia Bacteriana IAAS</option>
                <option value="Tuberculosis">Tuberculosis</option>
            </select>
            <div class="modal-body">
                <div class="form-group">
                    <label for="a">Año:</label>
                    <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control" required>
                </div>
                <div>
                    <label for="rango">Trimestre</label>
                    <select name="rango" id="rango">
                        <option value="">Seleccione</option>
                        <option value="primer_trimestre"> primer trimestre</option>
                        <option value="segundo_trimestre"> segundo trimestre</option>
                        <option value="tercer_trimestre"> tercer trimestre</option>
                        <option value="cuarto_trimestre"> cuarto trimestre</option>
                    </select>
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

