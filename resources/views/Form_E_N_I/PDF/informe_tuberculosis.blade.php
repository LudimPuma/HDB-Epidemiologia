<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informe Tuberculosis</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <h1 class="text-center"> Informe {{$nombre}} </h1>
    <h1 class="text-center"> Pacientes con diagnostico de tuberculosis H.D.B.</h1>

    <h2 class="text-center">Gestion: {{$fechaSeleccionada}}</h2>
    <div class="container">
        @foreach ($informeMensual as $mesData)
            <h2>{{ $mesData['mes'] }}:</h2>
            <table class="table">
                <thead>
                    <tr class="table-header">
                        <th>SEXO</th>
                        <th>POSITIVO</th>
                        <th>NEGATIVO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Masculino</th>
                        <td>{{ $mesData['totalMasculinoPositivo'] }}</td>
                        <td>{{ $mesData['totalMasculinoNegativo'] }}</td>
                        <td>{{ $mesData['totalMasculino'] }}</td>
                    </tr>
                    <tr>
                        <th>Femenino</th>
                        <td>{{ $mesData['totalFemeninoPositivo'] }}</td>
                        <td>{{ $mesData['totalFemeninoNegativo'] }}</td>
                        <td>{{ $mesData['totalFemenino'] }}</td>
                    </tr>
                    <tr class="table-footer">
                        <th colspan="3">Total {{ $mesData['mes'] }}</th>
                        <th>{{ $mesData['totalMes'] }}</th>

                    </tr>
                </tbody>
            </table>
        @endforeach
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>
</body>
</html>

