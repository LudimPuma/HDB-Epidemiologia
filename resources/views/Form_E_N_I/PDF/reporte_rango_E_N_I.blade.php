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
                    <th>Patología</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informe as $informeItem)
                    <tr>
                        <td>{{ $informeItem->patologia }}</td>
                        <td>{{ $informeItem->cantidad }}</td>
                    </tr>
                @endforeach
                <!-- Mostrar la sumatoria de total de casos -->
                <tr>
                    <td><strong>Total de Casos</strong></td>
                    <td>{{ $totalCasos }}</td>
                </tr>
            </tbody>
        </table>
    @else
        <p>No se encontraron datos para el rango de fechas seleccionado.</p>
    @endif

    <p>Fecha de generación del informe: {{ $fechaHoraActual }}</p>
</body>
</html>
