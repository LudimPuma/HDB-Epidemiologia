<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe IAAS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0 auto; /* Centra el contenido horizontalmente */
            max-width: 21cm; /* Ancho máximo en centímetros (A4) */
            padding: 20px;
        }

        /* Estilos para los títulos de las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px; /* Agrega espacio entre las tablas */
        }

        th {
            text-align: center;
            background-color: #f2f2f2; /* Color de fondo para los encabezados */
        }

        /* Estilos para las celdas de las tablas */
        td {
            text-align: center;
            padding: 5px;
        }
        .signature-container {
            text-align: center;
            margin-top: 100px;
            border-top: 1px solid #000; /* Borde superior reducido */
            height: 20px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .footer {
            position: fixed;
            bottom: -10px; /* Posición inferior*/
            left: 0;
            right: 0;
            text-align: right;
            font-size: 8px; /* Tamaño de fuente reducido para el pie de página */
        }
    </style>
</head>
<body>
    <h2 style="text-align: center">Resistencia Bacteriana de IAAS </h2>
    <h3 style="text-align: center">Hospital Daniel Bracamonte</h3>

    <table border="1">
        <thead>
            <tr>
                <th>Bacterias</th>
                <th>Número</th>
                <th>Resistencia</th>
            </tr>
        </thead>
        @foreach ($total_casos_resistentes_por_bacteria as $bacteria => $data)
            <tr>
                <td>{{ $bacteria }}</td>
                <td>{{ $data['total_resistentes'] }}</td>
                <td>
                    @foreach ($data['medicamentos'] as $medicamento)
                        {{ $medicamento }},
                    @endforeach
                </td>

            </tr>
        @endforeach
    </table>

    <h3 style="text-align: center">Resistencia a Gram Positivos</h3>

    <table border="1">
        <thead>
            <tr>
                <th>Bacterias</th>
                <th>
                    <p>Meticilina Resist.</p>
                    <p>Kirby Bawer</p>
                </th>
            </tr>
        </thead>
        @foreach ($bacteriasEspecificas as $bacteriaEspecifica)
            @php
                $informeBacteriaEspecifica = $informeEspecifico->firstWhere('bacteria', $bacteriaEspecifica);
                $totalResistentes = $informeBacteriaEspecifica ? $informeBacteriaEspecifica->casos_resistentes : 0;
            @endphp
            <tr>
                <td style="text-align: center">{{ $bacteriaEspecifica }}</td>
                <td style="text-align: center">{{ $totalResistentes }}</td>
            </tr>
        @endforeach
    </table>

    <h3 style="text-align: center">Resistencia a Carbapenems (Kirby Bawer)</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Bacterias</th>
                <th>IMP</th>
                <th>MER</th>
            </tr>
        </thead>
        @foreach ($bacteriasEspecificas2 as $bacteriaEspecifica2)
            <tr>
                <td style="text-align: center">{{ $bacteriaEspecifica2 }}</td>
                <td style="text-align: center">{{ $conteoCasosPorMedicamento[$bacteriaEspecifica2]['IMP'] }}</td>
                <td style="text-align: center">{{ $conteoCasosPorMedicamento[$bacteriaEspecifica2]['MER'] }}</td>

            </tr>
        @endforeach

    </table>

    <div class="signature-container">
        <h5>Dr. {{ Auth::user()->persona->nombres }}</h5>
    </div>
    <div class="footer">
        FECHA DE IMPRESIÓN: {{ $fechaHoraActual }}
    </div>
</body>
</html>
<!DOCTYPE html>

