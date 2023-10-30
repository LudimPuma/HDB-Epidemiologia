@extends('layout')
@section('content')
<div class="container mt-4">
    <form id="miFormulario" action="#" method="POST">
        @csrf
        <div class="card custom-card">
            <div class="card-body custom-body">
                <div class="text-center">
                    <h1>Reporte Trimestral por Servicio</h1>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seleccion">Seleccione un servicio:</label>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="a">Año:</label>
                            <input type="number" id="a" name="a" value="{{ date("Y") }}" class="form-control custom-input" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rango">Trimestre:</label>
                            <select name="rango" id="rango" class="form-control custom-select">
                                <option value="">Seleccione</option>
                                <option value="primer_trimestre">Primer trimestre</option>
                                <option value="segundo_trimestre">Segundo trimestre</option>
                                <option value="tercer_trimestre">Tercer trimestre</option>
                                <option value="cuarto_trimestre">Cuarto trimestre</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center custom-footer mb-4">
                <button type="button" id="generar-btn" class="btn btn-primary custom-button">Generar</button>
            </div>
        </div>
    </form>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">

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
      } else if (seleccion === "Enf_Not_Inm") {
        document.getElementById("miFormulario").action = "{{ route('reporte.trimestre.semestre.por.servicio.E_N_I') }}";
        console.log("prueba");
      }

      // Abre una nueva ventana con el formulario
      var pdfUrl = document.getElementById("miFormulario").action;
      window.open(pdfUrl, "_blank", "width=800,height=600");

      // Evita el envío del formulario
      event.preventDefault();
    });
  </script>




{{-- <script>
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

        var pdfUrl = document.getElementById("miFormulario").action;
        window.open(pdfUrl, "_blank", "width=800,height=600");
    });
</script> --}}
@endsection

