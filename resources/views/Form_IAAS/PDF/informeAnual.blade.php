<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe IAAS</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Resistencia Bacteriana de IAAS </h1>
        <h2 class="text-center">Hospital Daniel Bracamonte</h2>
        <table class="table ">
            <thead>
                <tr class="table-header">
                    <th>Bacterias</th>
                    <th>Número</th>
                    <th>Resistencia</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($total_casos_resistentes_por_bacteria as $bacteria => $data)
                    <tr >
                        <td>{{ $bacteria }}</td>
                        <td>{{ $data['total_resistentes'] }}</td>
                        <td>
                            @foreach ($data['medicamentos'] as $medicamento)
                                {{ $medicamento }},
                            @endforeach
                        </td>

                    </tr>
                @endforeach
                    <tr>
                        <td><p></p></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><p></p></td>
                        <td></td>
                        <td></td>
                    </tr>
            </tbody>

        </table>

        <h3 class="text-center">Resistencia a Gram Positivos</h3>

        <table class="table ">
            <thead>
                <tr class="table-header">
                    <th>Bacterias</th>
                    <th>
                        Meticilina Resist. <br>
                        Kirby Bawer
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bacteriasEspecificas as $bacteriaEspecifica)
                    @php
                        $informeBacteriaEspecifica = $informeEspecifico->firstWhere('bacteria', $bacteriaEspecifica);
                        $totalResistentes = $informeBacteriaEspecifica ? $informeBacteriaEspecifica->casos_resistentes : 0;
                    @endphp
                    <tr>
                        <td>{{ $bacteriaEspecifica }}</td>
                        <td>{{ $totalResistentes }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><p></p></td>
                    <td></td>
                </tr>
                <tr>
                    <td><p></p></td>
                    <td></td>
                </tr>
            </tbody>

        </table>

        <h3 class="text-center">Resistencia a Carbapenems (Kirby Bawer)</h3>
        <table class="table ">
            <thead>
                <tr class="table-header">
                    <th>Bacterias</th>
                    <th>IMP</th>
                    <th>MER</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bacteriasEspecificas2 as $bacteriaEspecifica2)
                    <tr>
                        <td>{{ $bacteriaEspecifica2 }}</td>
                        <td>{{ $conteoCasosPorMedicamento[$bacteriaEspecifica2]['IMP'] }}</td>
                        <td>{{ $conteoCasosPorMedicamento[$bacteriaEspecifica2]['MER'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td><p></p></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><p></p></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>


        </table>
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>

