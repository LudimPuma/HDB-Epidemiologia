<!DOCTYPE html>
<html>
<head>
    <title>Reporte IAAS</title>
    <style>
        h1 {
            text-align: center;
            margin: 5px 0; /* Espacio reducido arriba y abajo */
            font-size: 22px;
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
            font-size: 10px; /* Tamaño de fuente reducido para el pie de página */
        }
    </style>
</head>
<body>
    <h1>Reporte Antibiograma para {{ $nombreMesSeleccionado }} de {{ $anioSeleccionado }}</h1>

    <table border="1" cellspacing="0" cellpadding="5" >
        <thead>
            <tr>
                <th >Bacteria</th>
                <th >Medicamento</th>
                <th >Resistente (%)</th>
                <th >Intermedio (%)</th>
                <th >Sensible (%)</th>
            </tr>
        </thead>
        <tbody>
            @php

                $rowspan = 0;
            @endphp

            @foreach ($estadisticas as $bacteria => $medicamentos)
                @php $isFirstRow = true; @endphp
                @foreach ($medicamentos as $medicamento => $niveles)
                    <tr>
                        @if ($isFirstRow)
                            <td rowspan="{{ count($medicamentos) }}"  style="text-align: center">{{ $bacteria }}</td>
                            @php $isFirstRow = false; @endphp
                        @endif

                        <td  style="text-align: center">{{ $medicamento }}</td>
                        <td  style="text-align: center">{{ $niveles['Resistente'] }}%</td>
                        <td  style="text-align: center">{{ $niveles['Intermedio'] }}%</td>
                        <td  style="text-align: center">{{ $niveles['Sensible'] }}%</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    <div class="signature-container">
        <h5>Dr. {{ Auth::user()->persona->nombres }}</h5>
    </div>
    <div class="footer">
        FECHA DE IMPRESIÓN: {{ $fechaHoraActual }}
    </div>
</body>
</html>
