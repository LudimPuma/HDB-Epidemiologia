<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reporte Mensual Enf. Notificación Inmediata</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte Mensual Enfermedades de Notificación Inmediata</h1>
        <h2 class="text-center">{{ $nombreMesSeleccionado }} {{ $anioSeleccionado }}</h2>
        <table class="table">
            <thead>
                <tr class="table-header">
                    <th>Patología</th>
                    <th>Total de casos</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalCasos = 0; // Inicializar la variable para la sumatoria
                @endphp

                @foreach ($conteoCombinado as $conteo)
                    @php
                        $totalCasos += $conteo['total_casos']; // Sumar el valor de total_casos a la variable totalCasos
                    @endphp

                    <tr>
                        <td>{{ $conteo['patologia'] }}</td>
                        <td>{{ $conteo['total_casos'] }}</td>
                    </tr>
                @endforeach

                <tr class="table-footer">
                    <th>Total general</th>
                    <th>{{ $totalCasos }}</th> <!-- Mostrar el total de casos -->
                </tr>
            </tbody>
        </table>
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>

</body>
</html>
