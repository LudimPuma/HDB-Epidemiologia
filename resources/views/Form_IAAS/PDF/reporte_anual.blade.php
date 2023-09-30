<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{public_path('assets/css/pdf.css')}}" /> --}}
    {{-- <link rel="stylesheet" href="{{asset('assets/css/pdf.css')}}" /> --}}
    <title>Reporte anual</title>
    <style>

        table {
            width: 100%;
            border-collapse: collapse;
        }
        .page-break {
        page-break-before: always;
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
            position: absolute; /* Posición absoluta para el contenido */
            top: 1.5cm; /* Deja espacio para el encabezado */
            left: 0.5cm; /* Posición en la parte izquierda */
            width: 94%; /* Ancho completo */

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

    <div class="contenido">

        <h1>Informe Anual para {{ $fecha_select }}</h1>
        @php
        $nuevaPagina = false; // Inicialmente, no inicies una nueva página
        @endphp

        @foreach ($informePorServicio as $informe)
            @if (count($informe['total_casos_resistentes_bacteria']) > 0)
                <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
                @php
                    $bacteriaAnterior = null;
                @endphp
                @foreach ($informe['informe_servicio'] as $detalle)
                    @php
                        $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                    @endphp
                    @if ($detalle->bacteria != $bacteriaAnterior)
                        <p>Bacteria: {{ $detalle->bacteria }}</p>
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Medicamentos</th>
                                    <th>Resistencia</th>
                                </tr>
                            </thead>
                        @php
                            $bacteriaAnterior = $detalle->bacteria;
                            $nuevaPagina = true; // Establecer la variable de control para iniciar una nueva página antes de la próxima tabla
                        @endphp
                    @endif
                        <tbody>
                            <tr>
                                <td style="text-align: center">{{ $detalle->medicamento }}</td>
                                <td style="text-align: center">{{ $detalle->casos_resistentes }}</td>
                            </tr>
                        </tbody>

                    @if ($loop->last || $detalle->bacteria != $informe['informe_servicio'][$loop->index + 1]->bacteria)
                    <thead>
                        <tr>
                            <th colspan="1" style="text-align:right">Total Casos  </th>
                            <th colspan="1" style="text-align:center"> {{ $aux }}</th>
                        </tr>
                    </thead>
                        </table>

                        @if ($nuevaPagina)
                            <div class="page-break"></div> {{-- Aplicar la clase CSS para iniciar una nueva página --}}
                            @php
                                $nuevaPagina = false; // Restablecer la variable de control después de iniciar una nueva página
                            @endphp
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach









        <h1>Informe Anual para {{ $fecha_select }}</h1>
        @foreach ($informePorServicio as $informe)
        @if (count($informe['total_casos_resistentes_bacteria']) > 0)
            <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
            @php
                $bacteriaAnterior = null;
            @endphp
            @foreach ($informe['informe_servicio'] as $detalle)
                @php
                    $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                @endphp
                @if ($detalle->bacteria != $bacteriaAnterior)
                    <p>Bacteria: {{ $detalle->bacteria }}</p>
                    {{-- <p>Total Casos: {{ $aux }}</p> --}}

                    <table border="1">
                        <thead>
                            <tr>
                                {{-- <th colspan="2" style="text-align: left">Bacteria: {{ $detalle->bacteria }}</th> --}}

                            </tr>
                            {{-- <tr>
                                <th colspan="2" style="text-align:left">Total Casos: {{ $aux }}</th>
                            </tr> --}}
                            <tr>
                                <th>Medicamentos</th>
                                <th>Resistencia</th>
                            </tr>
                        </thead>
                    @php
                        $bacteriaAnterior = $detalle->bacteria;
                    @endphp
                @endif
                    <tbody>
                        <tr>
                            <td style="text-align: center">{{ $detalle->medicamento }}</td>
                            <td style="text-align: center">{{ $detalle->casos_resistentes }}</td>
                        </tr>
                    </tbody>

                @if ($loop->last || $detalle->bacteria != $informe['informe_servicio'][$loop->index + 1]->bacteria)
                <thead>
                    <tr>
                        <th colspan="1" style="text-align:right">Total Casos  </th>
                        <th colspan="1" style="text-align:center"> {{ $aux }}</th>
                    </tr>
                </thead>
                    </table>

                @endif
            @endforeach
        @endif
    @endforeach



        <h1>Informe Anual para {{ $fecha_select }}</h1>
        @foreach ($informePorServicio as $informe)
        @if (count($informe['total_casos_resistentes_bacteria']) > 0)
            <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
            @php
                $bacteriaAnterior = null;
            @endphp
            @foreach ($informe['informe_servicio'] as $detalle)
                @php
                    $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                @endphp
                @if ($detalle->bacteria != $bacteriaAnterior)
                    <p>Bacteria: {{ $detalle->bacteria }}</p>
                    <p>Total Casos: {{ $aux }}</p>
                @endif
                <table border="1">
                    <thead>
                        <tr>
                            <th>Medicamentos</th>
                            <th>Resistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $detalle->medicamento }}</td>
                            <td>{{ $detalle->casos_resistentes }}</td>
                        </tr>
                    </tbody>
                </table>
                @php
                    $bacteriaAnterior = $detalle->bacteria;
                @endphp
            @endforeach
        @endif
    @endforeach


        <h1>Informe Anual para {{ $fecha_select }}</h1>
        @foreach ($informePorServicio as $informe)
        @if (count($informe['total_casos_resistentes_bacteria']) > 0)
            <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
            @php
                $bacteriaAnterior = null;
            @endphp
            <table border="1">
                <thead>
                    <tr>
                        <th>Bacteria</th>
                        <th>Total Casos</th>
                        <th>Medicamentos</th>
                        <th>Resistencia</th>
                    </tr>
                </thead>
                <tbody>
            @foreach ($informe['informe_servicio'] as $detalle)
                @php
                    $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                @endphp
                @if ($detalle->bacteria != $bacteriaAnterior)
                    <tr>
                        <td colspan="1" style="text-align: center">{{ $detalle->bacteria }}</td>
                        <td colspan="" style="text-align: center">{{ $aux }}</td>
                        <td colspan="2"></td>
                        {{-- <td colspan="2"></td> --}}
                    </tr>
                @endif
                <tr>
                    <td colspan="2"></td>
                    <td style="text-align: center">{{ $detalle->medicamento }}</td>
                    <td style="text-align: center">{{ $detalle->casos_resistentes }}</td>
                </tr>
                @php
                    $bacteriaAnterior = $detalle->bacteria;
                @endphp
            @endforeach
            </tbody>
        </table>
        @endif
    @endforeach

        {{-- @foreach ($informePorServicio as $informe)
            @if (count($informe['total_casos_resistentes_bacteria']) > 0)
                <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>
                @php
                    $bacteriaAnterior = null;
                @endphp
                @foreach ($informe['informe_servicio'] as $detalle)
                @php
                    $aux = $informe['total_casos_resistentes_bacteria'][$detalle->bacteria] ?? 0;
                @endphp
                    @if ($detalle->bacteria != $bacteriaAnterior)
                        <table border="1">
                            <thead>
                                <tr>
                                    <th colspan="2">Bacteria: {{ $detalle->bacteria }}</th>
                                </tr>
                                <tr>
                                    <th colspan="2">Total Casos: {{ $aux }}</th>

                                </tr>
                                <tr>
                                    <th>Medicamentos</th>
                                    <th>Resistencia</th>
                                </tr>
                            </thead>
                    @endif
                            <tbody>
                                <tr>
                                    <td>{{ $detalle->medicamento }}</td>
                                    <td>{{ $detalle->casos_resistentes }}</td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                            $bacteriaAnterior = $detalle->bacteria;
                        @endphp
                @endforeach
            @endif
        @endforeach --}}






        {{-- <h1>Informe Anual para {{ $fecha_select }}</h1>
        @foreach ($informePorServicio as $informe)
        <h2>Servicio: {{ $informe['nombre_servicio'] }}</h2>

        @foreach ($informe['informe_servicio'] as $detalle)
            <p>Bacteria: {{ $detalle->bacteria }}</p>
            <p>Medicamento: {{ $detalle->medicamento }}</p>
            <p>Casos Resistentes: {{ $detalle->casos_resistentes }}</p>
        @endforeach

        @if (count($informe['total_casos_resistentes_bacteria']) > 0)
            <p>Total Casos por Bacteria:</p>
            <ul>
                @foreach ($informe['total_casos_resistentes_bacteria'] as $bacteria => $totalCasos)
                    <li>{{ $bacteria }}: {{ $totalCasos }}</li>
                @endforeach
            </ul>
        @endif
    @endforeach --}}







        {{-- @foreach ($informePorServicio as $nombreServicio => $datosServicio)
        <h1>Informe para el Servicio: {{ $nombreServicio }}</h1>
        <table border="1" cellspacing="0" cellpadding="5">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Bacteria</th>
                    <th>Medicamento</th>
                    <th>Total Casos</th>
                    <th>Casos Resistentes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosServicio as $item)
                    <tr>
                        <td>{{ $nombreServicio }}</td>
                        <td>{{ $item->bacteria }}</td>
                        <td>{{ $item->medicamento }}</td>
                        <td>{{ $item->total_casos_resistentes }}</td>
                        <td>{{ $item->casos_resistentes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endforeach --}}

        <div class="signature-container">
            <h5>Dr. {{ Auth::user()->persona->nombres }}</h5>
        </div>

    </div>

</body>
</html>
{{-- <script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(270, 780, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 10);
        ');
    }
</script> --}}
