<!DOCTYPE html>
<html>
<head>
    <title>Reporte IAAS</title>
    <style>
        body{
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;

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
            bottom: 1; /* Posición inferior*/
            left: 0;
            right: 0;
            text-align: right;
            font-size: 9px; /* Tamaño de fuente reducido para el pie de página */
        }
        .marcaAgua {
            position: fixed;
            opacity: 0.1; /* Opacidad de la marca de agua */
            width: 100%; /* Ancho de la marca de agua */
            height: 100%; /* Altura de la marca de agua */
            z-index: -1000; /* Colocar la marca de agua detrás del contenido */
            background-image: url('{{ $imageSrc }}'); /* Usar la variable $imageSrc */
            background-repeat: no-repeat;
            background-size: 40%; /* Tamaño de la marca de agua */
            background-position: center;
        }
        .encabezado {
            position: fixed;
            width: 21.59cm; /* Ancho de 21.59 cm */
            height: 3cm; /* Alto de 3 cm */
            top: -1cm; /* Posición en la parte superior */
            left: -1.3cm; /* Posición en la parte izquierda */
            background-image: url('{{ $encabezadoSrc }}');
            background-size: contain; /* Ajusta el tamaño de la imagen para que quepa completamente sin cortar */
        }
        .paginacion{
            position: fixed;
            width: 21.59cm; /* Ancho de 21.59 cm */
            height: 1.5cm; /* Alto de 3 cm */
            bottom: -1.3cm;
            left: -1.6cm;
            background-image: url('{{ $paginacionSrc }}');
            background-size: contain; /* Ajusta el tamaño de la imagen para que quepa completamente sin cortar */
        }
        .contenido {
            position: absolute; Posición absoluta para el contenido */
            top: 1.7cm; /* Deja espacio para el encabezado */
            left: 0.5cm; /* Posición en la parte izquierda */
            width: 94%; /* Ancho completo */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

    </style>
</head>
<body>
    <div class="encabezado"></div>
    <div class="marcaAgua"></div>
    <div class="paginacion"></div>
    <div class="footer">
        FECHA DE IMPRESIÓN: {{ $fechaHoraActual }}
    </div>
    <div class="contenido"><br><br><br>
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
    </div>
</body>
</html>
