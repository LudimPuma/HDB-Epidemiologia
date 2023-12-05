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

        <h1 class="text-center">Reporte {{$nombre}} Por Servicios</h1>
        <h2 class="text-center">Gestión {{ $fecha_select }}</h2>
        @foreach ($informePorServicio as $informe)
            @if (count($informe['total_casos_resistentes_bacteria']) > 0)
                <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
                @php
                    $bacteriaAnterior = null;
                    $totalResistentesPorServicio = 0; //variable para el total de resistentes por servicio
                @endphp
                <table class="table">
                    <thead>
                        <tr class="table-header">
                            <th>Bacteria</th>
                            <th>Antibioticos</th>
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
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>
</body>
</html>
