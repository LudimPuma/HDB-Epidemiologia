@extends('layout')
@section('content')
@php
  date_default_timezone_set('America/La_Paz');
  $hora_actual = date('H');
  $mensaje = '';

  if ($hora_actual >= 5 && $hora_actual < 12) {
    $mensaje = 'Buenos días';
  } elseif ($hora_actual >= 12 && $hora_actual < 18) {
    $mensaje = 'Buenas tardes';
  } else {
    $mensaje = 'Buenas noches';
  }
@endphp

<h1 style="text-align: center">
  {{ $mensaje }} {{ Auth::user()->persona->nombres }}
</h1>
<div class="row">
    <div class="col-lg-7">
      <div class="card-style mb-30">
        <div class="title d-flex flex-wrap align-items-center justify-content-between">
            <div class="left">
                <h4 class="text-medium mb-2">Enfermedades de Notificacion Inmediata</h4>
                <ul class="legend3 d-flex flex-wrap align-items-center mb-30">
                    @foreach($datasets as $dataset)
                        <li>
                            <div class="d-flex">
                                <span class="bg-color" style="background-color: {{ $dataset['borderColor'] }}"></span>
                                <div class="text">
                                    <p class="text-sm text-success">
                                        <span class="text-dark">{{ $dataset['label'] }}: </span>
                                        @php
                                            $totalCasos = array_sum($dataset['data']);
                                        @endphp
                                        {{ $totalCasos }} casos
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- End Title -->
        <div class="chart">
          <canvas
            id="Chart3"
            style="width: 100%; height: 450px"
          ></canvas>
        </div>
      </div>
    </div>
</div>

<script src="assets/js/Chart.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Los datos reales que vienen desde el controlador
    const labels = @json($labels);
    const datasets = @json($datasets);

    // =========== chart three start
    const ctx3 = document.getElementById("Chart3").getContext("2d");
    const chart3 = new Chart(ctx3, {
        type: "line",

        data: {
            labels: labels,
            datasets: datasets,
        },

        options: {
            tooltips: {
                // ... Opciones de tooltips ...
            },

            title: {
                display: false,
            },

            layout: {
                padding: {
                    top: 0,
                },
            },

            legend: {
                display: false, // Ocultar la leyenda
            },

            scales: {
                yAxes: [{
                    gridLines: {
                        display: false,
                        drawTicks: false,
                        drawBorder: false,
                    },
                    ticks: {
                        padding: 35,
                        suggestedMin: 0, // Inicio del eje Y en 0
                        suggestedMax: 50, // Extensión máxima del eje Y hasta 100
                        stepSize: 10, // Tamaño del paso entre los valores del eje Y
                    },
                }],
                xAxes: [{
                    gridLines: {
                        drawBorder: false,
                        color: "rgba(143, 146, 161, .1)",
                        zeroLineColor: "rgba(143, 146, 161, .1)",
                    },
                    ticks: {
                        padding: 20,
                    },
                }],
            },
        },
    });
</script>

@endsection
