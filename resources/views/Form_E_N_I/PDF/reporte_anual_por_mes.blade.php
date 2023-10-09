<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="language" content="es">
    <title>Reporte por Gestión - Enf. Notificación Inmediata</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte Enfermedades de Notificación Inmediata Anual por Meses</h1>
        <h2 class="text-center">Gestión {{ $fecha_select }}</h2>
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
                <table class="table">
                    <thead>
                        <tr class="table-header">
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
                        <tr class="table-footer">
                            <th>Total Casos</th>
                            <th>{{ $totalCasos }}</th>
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
