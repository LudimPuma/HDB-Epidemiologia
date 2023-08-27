<!DOCTYPE html>
<html>
<head>
    <title>Formulario IAAS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 20px; /* Tamaño de fuente general reducido */
        }
        h1 {
        text-align: center;
        margin: 5px 0; /* Espacio reducido arriba y abajo */
        font-size: 18px;
    }
        h3 {
            text-align: center;
            margin: 10px 0; /* Espacio reducido entre título y contenido */
            font-size: 16px; /* Tamaño de fuente para h3 */
        }
        h4 {
            text-align: center;
            margin: 10px 0; /* Espacio reducido entre título y contenido */
            font-size: 14px; /* Tamaño de fuente para h4 */
        }
        .section {
            margin: 10px 0; /* Espacio reducido entre secciones */
        }
        .section h2 {
            font-size: 14px; /* Tamaño de fuente para h2 */
            margin: 5px 0; /* Espacio reducido entre título y contenido */
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px; /* Tamaño de fuente reducido para la tabla */
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
    {{-- <img src="/img/logo.png" >
    {{-- <img src="img/logo1.png" class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" --}}
    {{-- width="50px" alt="profile"> --}}
    <h1>Hospital Daniel Bracamonte</h1>
    <h3>Departamento de Epidemiología Hospitalaria</h3>
    <h4>Ficha IAAS</h4>
    <!-- DATOS GENERALES -->
    <div class="section">
        <h2>Datos Generales</h2>
        <table>
            <tr>
                <th>Nro de Historial:</th>
                <td >{{ $h_clinico }}</td>
                <th>Nombre Paciente:</th>
                <td >{{ $nombreP->nombre_paciente }} {{ $nombreP->ap_paterno }} {{ $nombreP->ap_materno }}</td>
            </tr>
            <tr>
                <th>Fecha de Llenado</th>
                <td>{{ $fecha_llenado }}</td>
                <th>Fecha de Ingreso</th>
                <td>{{ $fecha_ingreso }}</td>
            </tr>
            <tr>
                <th>Servicio de Inicio de sistomas: </th>
                <td>{{ $servicio_inicio_sintomas->nombre }}</td>
                <th>Servicio Notificador: </th>
                <td>{{ $servicio_notificador->nombre }}</td>
            </tr>
            <tr>
                <th>Diagnóstico de ingreso</th>
                <td colspan="3">{{ $diagnostico_ingreso }}</td>
            </tr>
            <tr>
                <th>Diagnóstico de sala</th>
                <td colspan="3">{{ $diagnostico_sala }}</td>
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
                <th>Uso de Antimicrobianos</th>
                <td>{{ $uso_antimicrobanos }}</td>
            </tr>
            <tr>
                <th>Tipo de Muestra para Cultivo</th>
                <td>{{ $tipo_muestra_cultivo->nombre }}</td>
                <th>Procedimiento Invasivo</th>
                <td>{{ $procedimiento_invasivo->nombre }}</td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="3" style="text-align: center">Antibiograma</th>
                </tr>
                <tr>
                    <th rowspan="1" style="text-align: center">Bacterias</th>
                    <th rowspan="1" style="text-align: center">Medicamento</th>
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
