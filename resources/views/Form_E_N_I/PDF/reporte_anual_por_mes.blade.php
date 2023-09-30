<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="es">
    <title>Informe Mensual</title>
</head>
<body>
    <h1>Informe Mensual</h1>
    <p>Año: {{ $fecha_select }}</p>
    @php
    // Arreglo para mapear nombres de meses en inglés a español
    $mesesEnIngles = [
        'January' => 'Enero',
        'February' => 'Febrero',
        'March' => 'Marzo',
        'April' => 'Abril',
        'May' => 'Mayo',
        'June' => 'Junio',
        'July' => 'Julio',
        'August' => 'Agosto',
        'September' => 'Septiembre',
        'October' => 'Octubre',
        'November' => 'Noviembre',
        'December' => 'Diciembre',
    ];
    @endphp
    @foreach ($informeMensual->unique('mes') as $mesInfo)
        @php
            $mes = \Carbon\Carbon::create()->month($mesInfo->mes)->format('F'); // Obtener el nombre del mes
            $mesData = $informeMensual->where('mes', $mesInfo->mes);
            $totalCasos = $totalCasosPorMes[$mesInfo->mes]; // Obtener el total de casos por mes
        @endphp

        @if ($mesInfo->mes <= $mesActual)
            <!-- Mostrar solo si el mes es menor o igual al mes actual -->
            <h2>{{ $mesesEnIngles[$mes] }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Patología</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mesData as $row)
                        <tr>
                            <td>{{ $row->patologia }}</td>
                            <td>{{ $row->cantidad }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Total Casos</td>
                        <td>{{ $totalCasos }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    @endforeach

    <p>Fecha de generación del informe: {{ $fechaHoraActual }}</p>
</body>
</html>
