<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe Mensual</title>
    <style>
        /* Agrega estilos CSS personalizados aquí si es necesario */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Informe Mensual</h1>
    <p>Rango de Fechas: {{ $fechaEntrada }} a {{ $fechaSalida }}</p>

    @if (count($informe) > 0)
        <table>
            <thead>
                <tr>
                    <th>Bacteria</th>
                    <th>Medicamento</th>
                    <th>Casos Resistentes</th>
                    <th>Total Casos Resistentes por Bacteria</th> <!-- Nueva columna -->
                </tr>
            </thead>
            <tbody>
                @php
                    $currentBacteria = null;
                    $totalCasosPorBacteria = 0;
                @endphp
                @foreach($informe as $informeItem)
                    @if($informeItem->bacteria !== $currentBacteria)
                        <!-- Nueva fila para mostrar el total de casos por bacteria -->
                        @if($currentBacteria !== null)
                            <tr>
                                <td><strong>Total por Bacteria</strong></td>
                                <td></td>
                                <td></td>
                                <td>{{ $totalCasosPorBacteria }}</td>
                            </tr>
                        @endif
                        <!-- Actualizar la bacteria actual y reiniciar el total de casos por bacteria -->
                        @php
                            $currentBacteria = $informeItem->bacteria;
                            $totalCasosPorBacteria = 0;
                        @endphp
                    @endif
                    <tr>
                        <td>{{ $informeItem->bacteria }}</td>
                        <td>{{ $informeItem->medicamento }}</td>
                        <td>{{ $informeItem->casos_resistentes }}</td>
                        <td></td> <!-- Deja esta celda en blanco para las filas de bacteria -->
                    </tr>
                    @php
                        $totalCasosPorBacteria += $informeItem->casos_resistentes;
                    @endphp
                @endforeach
                <!-- Mostrar el total de casos para la última bacteria -->
                @if($currentBacteria !== null)
                    <tr>
                        <td><strong>Total por Bacteria</strong></td>
                        <td></td>
                        <td></td>
                        <td>{{ $totalCasosPorBacteria }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Mostrar el total de casos resistentes para el rango de fechas completo -->
        <p>Total Casos Resistentes para el rango de fechas: {{ $totalCasosResistentes }}</p>
    @else
        <p>No se encontraron datos para el rango de fechas seleccionado.</p>
    @endif

    <p>Fecha de generación del informe: {{ $fechaHoraActual }}</p>
</body>
</html>
