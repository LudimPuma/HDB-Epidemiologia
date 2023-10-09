<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte Rango de Fechas IAAS</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h2>Rango de Fechas: {{ $fechaEntrada }} a {{ $fechaSalida }}</h2>

        @if (count($informe) > 0)
            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th>Bacteria</th>
                        <th>Medicamento</th>
                        <th>Casos Resistentes</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentBacteria = null;
                        $totalCasosPorBacteria = 0;
                        $previousBacteria = null;
                    @endphp
                    @foreach($informe as $informeItem)
                        @if($informeItem->bacteria !== $currentBacteria)
                            <!-- Nueva fila para mostrar el total de casos por bacteria -->
                            @if($currentBacteria !== null)
                                <tr class="table-footer">
                                    <th colspan="2">Total: {{$currentBacteria}}</th>
                                    <th>{{ $totalCasosPorBacteria }}</th>
                                </tr>
                            @endif
                            <!-- Actualizar la bacteria actual y reiniciar el total de casos por bacteria -->
                            @php
                                $currentBacteria = $informeItem->bacteria;
                                $totalCasosPorBacteria = 0;
                            @endphp
                        @endif
                        <tr>
                            @if ($previousBacteria !== $informeItem->bacteria)
                                <th rowspan="{{ count($informe->where('bacteria', $informeItem->bacteria)) }}">{{ $informeItem->bacteria }}</th>
                                    @php
                                        $previousBacteria = $informeItem->bacteria;
                                    @endphp
                            @endif

                                <td>{{ $informeItem->medicamento }}</td>
                                <td>{{ $informeItem->casos_resistentes }}</td>


                        </tr>
                        @php
                            $totalCasosPorBacteria += $informeItem->casos_resistentes;
                        @endphp
                    @endforeach
                    <!-- Mostrar el total de casos para la última bacteria -->
                    @if($currentBacteria !== null)
                        <tr class="table-footer">
                            <th colspan="2">Total: {{$currentBacteria}}</th>
                            <th>{{ $totalCasosPorBacteria }}</th>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Mostrar el total de casos resistentes para el rango de fechas completo -->
            <p><strong>Total Casos Resistentes para el rango de fechas: {{ $totalCasosResistentes }}</strong></p>
        @else
            <p>No se encontraron datos para el rango de fechas seleccionado.</p>
        @endif
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>

</body>
</html>
