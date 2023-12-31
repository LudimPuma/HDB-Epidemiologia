<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario IAAS</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 20px; /* Tamaño de fuente general reducido */
        }

        h3 {

            margin: 10px 0; /* Espacio reducido entre título y contenido */
            font-size: 16px; /* Tamaño de fuente para h3 */
        }

        .section {
            margin: 10px 0; /* Espacio reducido entre secciones */
            background-color: #fff;
            border: 1px solid #ccc;
        }
        .section h2 {
            font-size: 14px; /* Tamaño de fuente para h2 */
            margin: 5px 0; /* Espacio reducido entre título y contenido */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px; /* Tamaño de fuente reducido para la tabla */
        }
        table, th, td {
            border: 1px solid black;
            border-right: 1px solid black;
        }
        th, td {
            padding: 2px; /* Espaciado reducido en celdas */
            text-align: left;
        }
        .signature-container {
            text-align: center;
            margin-top: 50px;
            border-top: 1px solid #000; /* Borde superior reducido */
            height: 20px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Ficha de casos de IAAS</h2>
        <!-- DATOS GENERALES -->
        <div class="section">
            <h3 > <strong>Datos Generales</strong></h3>
            <table >
                <tr>
                    <th>Nro de Historia Clinica:</th>
                    <td >{{ $h_clinico }}</td>
                    <th>Nombre Paciente:</th>
                    <td colspan="3">
                        @foreach ($nombreP as $nombrePa)
                            {{ $nombrePa['nombre'] }} {{ $nombrePa['ap_paterno'] }} {{ $nombrePa['ap_materno'] }}
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Fecha de Ingreso:</th>
                    <td>{{ $fecha_ingreso }}</td>
                    <th>Fecha de Egreso:</th>
                    <td>{{ $fecha_egreso }}</td>
                    <th>Dias de Internacion:</th>
                    <td>{{$dias_internacion}}</td>
                </tr>
                <tr>
                    <th>Servicio de Inicio de sistomas: </th>
                    <td>{{ $servicio_inicio_sintomas->nombre }}</td>
                    <th>Servicio Notificador: </th>
                    <td colspan="3">{{ $servicio_notificador->nombre }}</td>

                </tr>
                <tr>
                    <th>Diagnóstico de ingreso</th>
                    <td colspan="5">{{ $diagnostico_ingreso }}</td>
                </tr>
                <tr>
                    <th>Diagnóstico de sala</th>
                    <td colspan="5">{{ $diagnostico_sala }}</td>
                </tr>
                <tr>
                    <th>Diagnóstico de egreso</th>
                    <td colspan="5">{{ $diagnostico_egreso }}</td>
                </tr>
            </table>
        </div>
        <!-- DATOS LABORATORIO -->
        <div class="section">
            <h3><strong>Datos de Laboratorio</strong></h3>
            <table>
                <tr>
                    <th>Tipo de Infección Hospitalaria</th>
                    <td>
                        @foreach ($nombresTiposInfeccion as $nombreTipoInfeccion)
                            {{ $nombreTipoInfeccion }},
                        @endforeach
                    </td>
                    <th>Uso de Antimicrobianos</th>
                    <td>{{ $uso_antimicrobanos }}</td>
                </tr>
                <tr>
                    <th>Tipo de Muestra para Cultivo</th>
                    <td>{{ $tipo_muestra_cultivo->nombre }}</td>
                    <th>Procedimiento Invasivo</th>
                    <td>{{ $procedimiento_invasivo->nombre }}</td>
                </tr>
                <tr>
                    <th>Tipo de Hongo</th>
                    <td colspan="3">
                        @foreach ($nombresTipoHongos as $nombreTipoHongo)
                            {{ $nombreTipoHongo }},
                        @endforeach
                    </td>
                </tr>
            </table>
            <table>
                <thead>
                    <tr>
                        <th colspan="3" style="text-align: center">Antibiograma</th>
                    </tr>
                    <tr>
                        <th rowspan="1" style="text-align: center">Bacterias</th>
                        <th rowspan="1" style="text-align: center">Antibioticos</th>
                        <th rowspan="1" style="text-align: center">Nivel de Resistencia</th>
                    </tr>
                </thead>
                <tbody>
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
                                <td rowspan="{{ $rowspan }}" style="text-align: center">{{ $dato['bacteria'] }}</td>
                                <td style="text-align: center">{{ $dato['medicamento'] }}</td>
                                <td style="text-align: center">{{ $dato['resistencia'] }}</td>
                            </tr>
                        @else
                            <tr>
                                <td style="text-align: center">{{ $dato['medicamento'] }}</td>
                                <td style="text-align: center">{{ $dato['resistencia'] }}</td>
                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- DATOS EPIDEMIOLOGICOS -->
        <div class="section">
            <h3><strong>Datos Epidemiológicos</strong></h3>
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
        {{--  --}}
        <div class="section">
            <h3><strong>Datos Encargado llenado de ficha</strong></h3>
            <table >
                <tr>
                    <th>Nombre:</th>
                    <td>{{ $NombreFormSave}}</td>
                    <th>Cargo</th>
                    <td>{{ $cargo->cargo }}</td>
                </tr>
            </table>
        </div>
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>




        </div>
    </div>
</body>
</html>
