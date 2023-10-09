<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
    <title>Reporte por Servicios - IAAS</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte Anual Por Servicios</h1>
        <h2 class="text-center">Gestión {{ $fecha_select }}</h2>
        @foreach ($informePorServicio as $informe)
        @if (count($informe['total_casos_resistentes_bacteria']) > 0)
            <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
            @php
                $bacteriaAnterior = null;
                $totalResistentesPorServicio = 0; // Inicializa la variable para el total de resistentes por servicio
            @endphp
            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th>Bacteria</th>
                        <th>Medicamentos</th>
                        <th>Resistentes</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $previousBacteria = null;
                    @endphp
                    @foreach ($informe['informe_servicio'] as $detalle)
                        <tr>
                            @php
                                $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                                $totalResistentesPorServicio += $detalle->casos_resistentes; // Suma los resistentes por servicio
                            @endphp
                            @if ($detalle->bacteria != $bacteriaAnterior)
                                <th rowspan="{{ count($informe['informe_servicio']->where('bacteria', $detalle->bacteria)) }}">{{ $detalle->bacteria }}</th>
                                @php
                                    $previousBacteria = $detalle->bacteria;
                                @endphp
                            @endif

                            <td style="text-align: center">{{ $detalle->medicamento }}</td>
                            <td style="text-align: center">{{ $detalle->casos_resistentes }}</td>
                        </tr>
                        @php
                            $bacteriaAnterior = $detalle->bacteria;
                        @endphp
                    @endforeach
                    <tr class="table-footer">
                        <th colspan="2">Total casos</th>
                        <th style="text-align: center">{{ $totalResistentesPorServicio }}</th> <!-- Imprime el total de resistentes por servicio -->
                    </tr>
                </tbody>
            </table>
        @endif
    @endforeach


        {{-- @foreach ($informePorServicio as $informe)
            @if (count($informe['total_casos_resistentes_bacteria']) > 0)
                <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
                @php
                    $bacteriaAnterior = null;
                @endphp
                @foreach ($informe['informe_servicio'] as $detalle)
                @php
                    $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                @endphp
                    @if ($detalle->bacteria != $bacteriaAnterior)
                        <table border="1">
                            <thead>
                                <tr>
                                    <th colspan="2">Bacteria: {{ $detalle->bacteria }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Total Casos: {{ $aux }}</th>

                                </tr>
                                <tr>
                                    <th>Medicamentos</th>
                                    <th>Resistencia</th>
                                </tr>
                            </thead>
                    @endif
                            <tbody>
                                <tr>
                                    <td>{{ $detalle->medicamento }}</td>
                                    <td>{{ $detalle->casos_resistentes }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                            $bacteriaAnterior = $detalle->bacteria;
                        @endphp
                @endforeach
            @endif
        @endforeach --}}






        {{-- <h1>Informe Anual para {{ $fecha_select }}</h1>
        @foreach ($informePorServicio as $informe)
        <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>

        @foreach ($informe['informe_servicio'] as $detalle)
            <p>Bacteria: {{ $detalle->bacteria }}</p>
            <p>Medicamento: {{ $detalle->medicamento }}</p>
            <p>Casos Resistentes: {{ $detalle->casos_resistentes }}</p>
        @endforeach

        @if (count($informe['total_casos_resistentes_bacteria']) > 0)
            <p>Total Casos por Bacteria:</p>
            <ul>
                @foreach ($informe['total_casos_resistentes_bacteria'] as $bacteria => $totalCasos)
                    <li>{{ $bacteria }}: {{ $totalCasos }}</li>
                @endforeach
            </ul>
        @endif
    @endforeach --}}







        {{-- @foreach ($informePorServicio as $nombreServicio => $datosServicio)
        <h1>Informe para el Servicio: {{ $nombreServicio }}</h1>
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Bacteria</th>
                    <th>Medicamento</th>
                    <th>Total Casos</th>
                    <th>Casos Resistentes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosServicio as $item)
                    <tr>
                        <td>{{ $nombreServicio }}</td>
                        <td>{{ $item->bacteria }}</td>
                        <td>{{ $item->medicamento }}</td>
                        <td>{{ $item->total_casos_resistentes }}</td>
                        <td>{{ $item->casos_resistentes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach --}}

        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>

    </div>

</body>
</html>
{{-- <script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(270, 780, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
</script> --}}
