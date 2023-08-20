<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>
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
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h1>Reporte Enfermedades de Notificación Inmediata</h1>
    <p>Mes: {{ $nombreMesSeleccionado }} de {{ $anioSeleccionado }}</p>
    <table>
        <thead>
            <tr>
                <th>Patología</th>
                <th>Total de casos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($conteoCombinado as $conteo)
            <tr>
                <td>{{ $conteo['patologia'] }}</td>
                <td>{{ $conteo['total_casos'] }}</td>
            </tr>
            @endforeach
            {{-- @foreach ($conteoPorPatologia as $patologia)
                <tr>
                    <td>{{ $patologia->patologia }}</td>
                    <td>{{ $patologia->total_casos }}</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>




</body>
</html>
