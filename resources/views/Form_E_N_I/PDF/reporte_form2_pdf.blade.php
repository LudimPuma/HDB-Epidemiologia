<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reporte PDF</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
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

    </style>
</head>
<body>
    <div class="encabezado"></div>
    <div class="watermark"></div>
    <div class="paginacion"></div>
    <div class="footer">
        FECHA DE IMPRESIÓN: {{ $fechaHoraActual }}
    </div>
    <h1>Reporte Enfermedades de Notificación Inmediata</h1>
    <p>Mes: {{ $nombreMesSeleccionado }} de {{ $anioSeleccionado }}</p>
    <table>
        <thead>
            <tr>
                <th>Patología</th>
                <th>Total de casos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($conteoCombinado as $conteo)
            <tr>
                <td>{{ $conteo['patologia'] }}</td>
                <td>{{ $conteo['total_casos'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
