<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte PDF</title>
    <style>
        /* Estilos CSS para el PDF */
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
    </style>
</head>
<body>
    <h1>Reporte PDF</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>

            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($reporte as $item)
                <tr>
                    <td>{{ $item->id_f_notificacion_inmediata }}</td>
                    <td>{{ $item->nombre }}</td>

                </tr>
            @endforeach --}}
        </tbody>
    </table>
</body>
</html>
