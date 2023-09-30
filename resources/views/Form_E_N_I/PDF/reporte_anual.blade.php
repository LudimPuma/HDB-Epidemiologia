<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe Anual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Informe Anual</h1>
    <p>Año: {{ $fecha_select }}</p>
    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Patología</th>
                <th>Cantidad</th>
                <th>Total Casos</th>
            </tr>
        </thead>
        <tbody>
            @php
                $currentService = null;
                $totalCasosPorServicio = 0;
            @endphp
            @foreach($informePatologias as $row)
                @if($row->servicio !== $currentService)
                    <!-- Nueva fila para mostrar el total de casos por servicio -->
                    @if($currentService !== null)
                        <tr>
                            <td><strong>Total por Servicio</strong></td>
                            <td></td>
                            <td></td>
                            <td>{{ $totalCasosPorServicio }}</td>
                        </tr>
                    @endif
                    <!-- Actualizar el servicio actual y reiniciar el total de casos por servicio -->
                    @php
                        $currentService = $row->servicio;
                        $totalCasosPorServicio = 0;
                    @endphp
                @endif
                <tr>
                    <td>{{ $row->servicio }}</td>
                    <td>{{ $row->patologia }}</td>
                    <td>{{ $row->cantidad }}</td>
                    <td></td> <!-- Deja esta celda en blanco para las filas de patología -->
                </tr>
                @php
                    $totalCasosPorServicio += $row->cantidad;
                @endphp
            @endforeach
            <!-- Mostrar el total de casos para el último servicio -->
            @if($currentService !== null)
                <tr>
                    <td><strong>Total por Servicio</strong></td>
                    <td></td>
                    <td></td>
                    <td>{{ $totalCasosPorServicio }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>


