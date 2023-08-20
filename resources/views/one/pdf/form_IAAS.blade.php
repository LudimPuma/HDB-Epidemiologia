<!DOCTYPE html>
<html>
<head>
    <title>Formulario PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
        }
        h3{
            text-align: center;
        }
        h4{
            text-align: center;
        }
        .section {
            margin: 20px 0;
        }
        .section h2 {
            font-size: 18px;
            margin: 10px 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            border-right: 1px solid black;
        }
        th, td {
            padding: 3px;
            text-align: left;
        }
        .signature-container {
            text-align: center;
            margin-top: 70px;
            border-top: 2px solid #000;
            height: 20px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .footer {
        position: fixed;
        bottom: -20px;
        left: 0;
        right: 0;
        text-align: right;
        font-size: 10px;
        }


        /* .antibiograma-table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
        }

        .antibiograma-table th, .antibiograma-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .antibiograma-table th {
            background-color: #f2f2f2;
        }

        .antibiograma-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .antibiograma-table tbody tr:hover {
            background-color: #e0e0e0;
        } */
    </style>
</head>
<body>
    {{-- <img src="img/logo.png" alt="logo_icono" class="logo"> --}}
    {{-- <img src="img/logo1.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3"
    width="50px" alt="profile"> --}}
    <h1>Hospital Daniel Bracamonte</h1>
    <h3>Departamento de Epidemiología Hospitalaria</h3>
    <h4>Ficha IAAS</h4>
    <!-- DATOS GENERALES -->
    <div class="section">
        <h2>Datos Generales</h2>
        <table>
            <tr>
                <th>Número de Historial</th>
                <td>{{ $h_clinico }}</td>
            </tr>
            <tr>
                <th>Nombre Paciente</th>
                <td>{{ $nombreP->nombre_paciente }} {{ $nombreP->ap_paterno }} {{ $nombreP->ap_materno }}</td>
            </tr>
            <tr>
                <th>Fecha de Llenado</th>
                <td>{{ $fecha_llenado }}</td>
            </tr>
            <tr>
                <th>Fecha de Ingreso</th>
                <td>{{ $fecha_ingreso }}</td>
            </tr>
            <tr>
                <th>Servicio de Inicio de sistomas</th>
                <td>{{ $servicio_inicio_sintomas->nombre }}</td>
            </tr>
            <tr>
                <th>Diagnóstico de ingreso</th>
                <td>{{ $diagnostico_ingreso }}</td>
            </tr>
            <tr>
                <th>Diagnóstico de sala</th>
                <td>{{ $diagnostico_sala }}</td>
            </tr>

        </table>
    </div>
    <!-- DATOS LABORATORIO -->
    <div class="section">
        <h2>Datos de Laboratorio</h2>
        <table>
            <tr>
                <th>Tipo de Infección Hospitalaria</th>
                <td>
                    @foreach ($nombresTiposInfeccion as $nombreTipoInfeccion)
                        {{ $nombreTipoInfeccion }},
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>Uso de Antimicrobianos</th>
                <td>{{ $uso_antimicrobanos }}</td>
            </tr>
            <tr>
                <th>Tipo de Muestra para Cultivo</th>
                <td>{{ $tipo_muestra_cultivo->nombre }}</td>
            </tr>
            <tr>
                <th>Procedimiento Invasivo</th>
                <td>{{ $procedimiento_invasivo->nombre }}</td>
            </tr>
        </table>
        <h4>Antibiograma</h4>
        <table>
            <thead>
                <tr>
                    <th rowspan="2">Bacterias</th>
                    <th rowspan="2">Medicamento</th>
                    <th rowspan="2">Nivel de Resistencia</th>
                </tr>
            </thead>
            <tbody>
                {{-- <tr class="invisible-row">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> --}}
                @php
                    $previousBacteria = null;
                    $rowspan = 0;
                @endphp

                @foreach ($datosAntibiograma as $dato)
                    @if ($previousBacteria !== $dato['bacteria'])
                        @php
                            $previousBacteria = $dato['bacteria'];
                            $rowspan = count(array_filter($datosAntibiograma, function ($item) use ($previousBacteria) {
                                return $item['bacteria'] === $previousBacteria;
                            }));
                        @endphp

                        <tr>
                            <td rowspan="{{ $rowspan }}">{{ $dato['bacteria'] }}</td>
                            <td>{{ $dato['medicamento'] }}</td>
                            <td>{{ $dato['resistencia'] }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>{{ $dato['medicamento'] }}</td>
                            <td>{{ $dato['resistencia'] }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- DATOS EPIDEMIOLOGICOS -->
    <div class="section">
        <h2>Datos Epidemiológicos</h2>
        <table>
            <tr>
                <th>Medidas a Tomar</th>
                <td>{{ $medidas_tomar }}</td>
            </tr>
            <tr>
                <th>Aislamiento</th>
                <td>{{ $aislamiento }}</td>
            </tr>
            <tr>
                <th>Seguimiento</th>
                <td>{{ $seguimiento }}</td>
            </tr>
            <tr>
                <th>Observación</th>
                <td>{{ $observacion }}</td>
            </tr>
        </table>
    </div>
    <div class="signature-container">
        <h5>Dr. {{ Auth::user()->persona->nombres }}</h5>
    </div>
    <div class="footer">
        FECHA DE IMPRESIÓN: {{ $fechaHoraActual }}
    </div>
</body>
</html>
