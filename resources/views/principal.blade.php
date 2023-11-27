@extends('layout')
{{-- @section('title', 'Principal') --}}
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

{{-- <h1 style="text-align: center">
  {{ $mensaje }} {{ Auth::user()->persona->nombres }}
</h1> --}}
{{-- <div class="title mb-30 text-center">
    <h2>{{ $mensaje }} {{ Auth::user()->persona->nombres }}</h2>
</div> --}}

{{-- GRAFICA --}}
<div class="row">
    {{-- ENFERMEDADES NOTIFICACION INMEDIATA --}}
    <div class="col-lg-7">
        <div class="card-style mb-30">
            <div class="title d-flex flex-wrap align-items-center justify-content-between">
                <div class="left">
                    <h4 class="text-medium mb-2">Enfermedades de Notificación Inmediata</h4>
                </div>
            </div>
            <div class="chart">
                <div id="legend3">
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
                <canvas id="Chart3" style="width: 100%; height: 400px"></canvas>
            </div>
        </div>
    </div>
    {{-- IAAS --}}
    <div class="col-lg-5">
        <div class="card-style mb-30">
            <div class="title d-flex flex-wrap align-items-center justify-content-between">
                <div class="left mb-50">
                    <h4 class="text-medium">IAAS</h4>
                </div>
                <div class="right">
                    <div class="select-style-1" style="margin-top: -20px;">
                        <div class="select-position select-sm">
                            <select id="selectBacteria" class="light-bg">
                                @foreach ($bacterias as $bacteria)
                                    <option value="{{ $bacteria->bacteria }}">{{ $bacteria->bacteria }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart">
                <canvas id="Chart2" style="width: 100%; height: 430px"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row align-items-stretch">

    <div class="col-lg-7 d-flex">
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

        <div class="chart">
          <canvas
            id="Chart3"
            style="width: 100%; height: 256px"
          ></canvas>
        </div>
      </div>
    </div>
    <div class="col-lg-5 d-flex">
        <div class="card-style mb-30">
            <div
                class="
                title
                d-flex
                flex-wrap
                align-items-center
                justify-content-between
                "
            >
                <div class="left">
                <h6 class="text-medium mb-30">Sales/Revenue</h6>
                </div>
                <div class="right">
                <div class="select-style-1">
                    <div class="select-position select-sm">
                    <select class="light-bg">
                        <option value="">Yearly</option>
                        <option value="">Monthly</option>
                        <option value="">Weekly</option>
                    </select>
                    </div>
                </div>
                <!-- end select -->
                </div>
            </div>
            <!-- End Title -->
            <div class="chart">
                <canvas
                id="Chart2"
                style="width: 100%; height: 400px"
                ></canvas>
            </div>
          <!-- End Chart -->
        </div>
    </div>
</div> --}}

<script src="assets/js/Chart.min.js"></script>
<script>
// Los datos reales que vienen desde el controlador
const labels = @json($labels);
const datasets = @json($datasets);
const datosBacteria = @json($datosBacteria);
// =========== chart three start
    const ctx3 = document.getElementById("Chart3").getContext("2d");
    const chart3 = new Chart(ctx3, {
        type: "line",

        data: {
            labels: labels,
            datasets: datasets.map(dataset => {
                const patologia = dataset.label;
                return {
                    ...dataset,
                    backgroundColor: "transparent",
                    borderColor: dataset.borderColor, // Usar el color definido en el controlador
                    pointBackgroundColor: "transparent",
                    pointHoverBackgroundColor: dataset.borderColor, // Usar el color definido en el controlador
                    pointBorderColor: "transparent",
                    pointHoverBorderColor: "#fff",
                    pointHoverBorderWidth: 3,
                    pointBorderWidth: 5,
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    line: {
                        pointRadius: 0, // Establecer el radio de los puntos a 0 para que no sean visibles
                    },
                };
            }),
        },

        options: {
            tooltips: {
                intersect: false,
                backgroundColor: "#fbfbfb",
                titleFontColor: "#8F92A1",
                titleFontSize: 14,
                titleFontFamily: "Inter",
                titleFontStyle: "400",
                bodyFontFamily: "Inter",
                bodyFontColor: "#171717",
                bodyFontSize: 12,
                multiKeyBackground: "transparent",
                displayColors: false,
                xPadding: 20,
                yPadding: 10,
                borderColor: "rgba(143, 146, 161, .1)",
                borderWidth: 2,
                title: false,
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
                        suggestedMax: 100, // Extensión máxima del eje Y hasta 100
                        stepSize: 20, // Tamaño del paso entre los valores del eje Y
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

    document.addEventListener("DOMContentLoaded", function () {
        const ctx2 = document.getElementById("Chart2").getContext("2d");
        const selectBacteria = document.getElementById("selectBacteria");

        // Declarar bacteriaSeleccionada antes de utilizarla
        let bacteriaSeleccionada;

        selectBacteria.addEventListener("change", function () {
            bacteriaSeleccionada = this.value;
            actualizarGrafico(ctx2, bacteriaSeleccionada, datosBacteria[bacteriaSeleccionada]);
        });

        // Llamar a la función inicialmente con el valor seleccionado
        bacteriaSeleccionada = selectBacteria.value;
        actualizarGrafico(ctx2, bacteriaSeleccionada, datosBacteria[bacteriaSeleccionada]);
    });

    function actualizarGrafico(ctx, bacteriaSeleccionada, datosBacteria) {
        const chart2 = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: bacteriaSeleccionada,
                        backgroundColor: "#00796B",
                        barThickness: 6,
                        maxBarThickness: 8,
                        data: datosBacteria['data'],
                    },
                ],
            },
            // Configuration options
            options: {
                borderColor: "#F3F6F8",
                borderWidth: 15,
                backgroundColor: "#F3F6F8",
                tooltips: {
                    callbacks: {
                        labelColor: function (tooltipItem, chart) {
                            return {
                                backgroundColor: "rgba(104, 110, 255, .0)",
                            };
                        },
                    },
                    backgroundColor: "#F3F6F8",
                    titleFontColor: "#8F92A1",
                    titleFontSize: 12,
                    bodyFontColor: "#171717",
                    bodyFontStyle: "bold",
                    bodyFontSize: 16,
                    multiKeyBackground: "transparent",
                    displayColors: false,
                    xPadding: 30,
                    yPadding: 10,
                    bodyAlign: "center",
                    titleAlign: "center",
                },

                title: {
                    display: false,
                },
                legend: {
                    display: false,
                },

                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawTicks: false,
                                drawBorder: false,
                            },
                            ticks: {
                                padding: 35,
                                max: 100,
                                min: 0,
                                stepSize: 20,
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: false,
                                color: "rgba(143, 146, 161, .1)",
                                zeroLineColor: "rgba(143, 146, 161, .1)",
                            },
                            ticks: {
                                padding: 20,
                            },
                        },
                    ],
                },
            },
        });
    }

</script>
@endsection
