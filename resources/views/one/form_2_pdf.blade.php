<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario Enfermedades Notificaion Inmediata</title>
    <style>
        /* Estilos CSS para el PDF */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .form-container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }

        h1 {
            text-align: center;
            margin-bottom: 15px;
            text-decoration: underline;
        }
        h3{
            text-align: center;
            margin-bottom: 12px;
        }
        h4{
            text-align: center;
            margin-bottom: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .footer {
        position: fixed;
        bottom: -20px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 10px;
        }
    </style>
</head>
<body>
    <img src="{{ asset('img/logo_HDB.png') }}" alt="logo_icono" class="logo">


    <h1>Hospital Daniel Bracamonte</h1>
    <h3>Departamento de Epidemiología Hospitalaria</h3>
    <h4>Formulario de Enfermedades de Notificación Inmediata</h4>
    <div class="form-container">
        <table>
            <tr>
                <th>Nro. Formulario</th>
                <td>{{ $formulario->id_f_notificacion_inmediata }}</td>
            </tr>
            <tr>
                <th>Fecha</th>
                <td>{{ $formulario->fecha }}</td>
            </tr>
            <tr>
                <th>Nombre(s) del paciente</th>
                <td>{{ $paciente->nombre_paciente }}</td>
            </tr>
            <tr>
                <th>Apellido paterno</th>
                <td>{{ $paciente->ap_paterno }}</td>
            </tr>
            <tr>
                <th>Apellido materno</th>
                <td>{{ $paciente->ap_materno }}</td>
            </tr>
            <tr>
                <th>Edad</th>
                <td>{{ $paciente->edad }}</td>
            </tr>
            <tr>
                <th>Sexo</th>
                <td>{{ $paciente->sexo }}</td>
            </tr>
            <tr>
                <th>Servicio</th>
                <td>{{ $servicio->nombre }}</td>
            </tr>
            <tr>
                <th>Patología</th>
                <td>{{ $patologia->nombre }}</td>
            </tr>
            <tr>
                <th>Notificador</th>
                <td>{{ $formulario->notificador }}</td>
            </tr>
            <tr>
                <th>Acciones</th>
                <td>{{ $formulario->acciones }}</td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td>{{ $formulario->observaciones }}</td>
            </tr>
        </table>
    </div>
    <div class="footer">
        FECHA DE IMPRESIÓN: {{ $fechaHoraActual }}
    </div>
</body>
</html>
