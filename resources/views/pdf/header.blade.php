<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Puedes definir los estilos CSS para tu encabezado aquí si es necesario -->
    <style>
        /* Estilo para el encabezado */
        .header {
            height: 2.6cm; /* Altura del encabezado */
            /* Otros estilos, como colores de fondo, fuentes, etc. */
        }
        .encabezado {
            height: auto; /* Esto mantiene la proporción de la imagen */
            width:110%;
            margin-left: -40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="http://localhost/HDB-Epi/public/img/encabezado.png" alt="Logo" class="encabezado" >
        {{-- <img src="{{ public_path('img/encabezado.png') }}" alt="Logo" class="encabezado"> --}}
        {{-- <img src="public/img/encabezado.png" alt="Logo" class="encabezado"> --}}


    </div>
</body>
</html>
