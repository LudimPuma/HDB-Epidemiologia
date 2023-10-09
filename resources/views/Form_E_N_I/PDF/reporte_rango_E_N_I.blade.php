<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte por rango de fechas</h1>
        <h2>Rango de Fechas: {{ $fechaEntrada }} a {{ $fechaSalida }}</h2>

        @if (count($informe) > 0)
            <table class="table ">
                <thead>
                    <tr class="table-header">
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
                    <tr class="table-footer">
                        <th>Total de Casos</th>
                        <th>{{ $totalCasos }}</th>
                    </tr>
                </tbody>
            </table>
        @else
            <p>No se encontraron datos para el rango de fechas seleccionado.</p>
        @endif
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>
</body>
</html>
