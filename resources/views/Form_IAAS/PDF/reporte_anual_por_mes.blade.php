<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte por Gestión - IAAS</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte IAAS Anual por Meses</h1>
        <h2 class="text-center"> Gestión {{ $añoSeleccionado }}</h2>
        @foreach ($meses as $mesNumero => $nombreMes)
            @if (isset($totalCasosPorMes[$nombreMes]) && $totalCasosPorMes[$nombreMes] > 0)
                <h2>{{ $nombreMes }}:</h2>
                <table class="table ">
                    <thead>
                        <tr class="table-header">
                            <th>Bacteria</th>
                            <th>Medicamento</th>
                            <th>Casos Resistentes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $previousBacteria = null;
                        @endphp
                        @foreach($informePorMes[$nombreMes] as $informe)
                            <tr>
                                @if ($previousBacteria !== $informe->bacteria)
                                    <th rowspan="{{ count($informePorMes[$nombreMes]->where('bacteria', $informe->bacteria)) }}">{{ $informe->bacteria }}</th>
                                    @php
                                        $previousBacteria = $informe->bacteria;
                                    @endphp
                                @endif
                                <td>{{ $informe->medicamento }}</td>
                                <td>{{ $informe->casos_resistentes }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tr class="table-footer">
                        <th colspan="2">Total Casos Resistentes para {{ $nombreMes }}</th>
                        <th>{{ $totalCasosPorMes[$nombreMes] }}</th>
                    </tr>
                </table>
            @endif
        @endforeach
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>
</body>
</html>


    {{-- <div class="row">

        <div class="col-lg-7">
            <div class="card-style mb-30">
                <div class="">
                    <canvas id="miGrafico" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script>

        const canvas = document.getElementById('miGrafico');


        const data = {
          labels: ['Manzanas', 'Plátanos', 'Naranjas'],
          datasets: [{
            data: [10, 5, 8],
            backgroundColor: ['#FF5733', '#FFC300', '#33FF57']
          }]
        };


        const ctx = canvas.getContext('2d');
        const myDoughnutChart = new Chart(ctx, {
          type: 'doughnut',
          data: data,
          options: {

            title: {
              display: true,
              text: 'Mi Gráfico de Rosquilla'
            }
          }
        });
    </script> --}}
