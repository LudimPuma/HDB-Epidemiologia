<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe Mensual</title>
</head>
<body>
    <h1>Informe Mensual</h1>
    <p>Año: {{ $añoSeleccionado }}</p>

    @foreach ($meses as $mesNumero => $nombreMes)
        @if (isset($totalCasosPorMes[$nombreMes]) && $totalCasosPorMes[$nombreMes] > 0)
            <!-- Mostrar solo si hay datos para este mes -->
            <h2>{{ $nombreMes }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Bacteria</th>
                        <th>Medicamento</th>
                        <th>Casos Resistentes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($informePorMes[$nombreMes] as $informe)
                        <tr>
                            <td>{{ $informe->bacteria }}</td>
                            <td>{{ $informe->medicamento }}</td>
                            <td>{{ $informe->casos_resistentes }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Mostrar el total de casos resistentes para este mes -->
            <p>Total Casos Resistentes para {{ $nombreMes }}: {{ $totalCasosPorMes[$nombreMes] }}</p>
        @endif
    @endforeach

    <p>Fecha de generación del informe: {{ $fechaHoraActual }}</p>
</body>
</html>
