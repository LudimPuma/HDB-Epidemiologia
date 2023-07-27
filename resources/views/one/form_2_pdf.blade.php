<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario Enfermedades Notificaion Inmediata</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 10px;
        }

        .form-container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            margin-top:10px
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
            padding: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
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
        text-align: center;
        font-size: 10px;
        }
    </style>
</head>
<body>
    <img src="{{ asset('img/logo_HDB.png') }}" alt="logo_icono" class="logo">


    <h1>Hospital Daniel Bracamonte</h1>
    <h3>Departamento de Epidemiología Hospitalaria</h3>
    <h4>Ficha de Enfermedades de Notificación Inmediata</h4>
    <div class="form-container">
        <h5>DATOS PACIENTE</h5>
        <table>
            <tr>
                <th>Nro. Formulario</th>
                <td>{{ $formulario->id_f_notificacion_inmediata }}</td>
                <th>Fecha</th>
                <td>{{ $formulario->fecha }}</td>
            </tr>
            <tr>
                <th>Paciente</th>
                <td colspan="3">{{ $paciente->nombre_paciente }} {{ $paciente->ap_paterno }} {{ $paciente->ap_materno }}</td>

            </tr>
            <tr>
                <th>Edad</th>
                <td>{{ $paciente->edad }}</td>
                <th>Sexo</th>
                <td>{{ $paciente->sexo }}</td>
            </tr>
        </table>
    </div>
    <div class="form-container">
        <h5>LLENADO DEL FORMULARIO</h5>
        <table>
            <tr>
                <th>Servicio</th>
                <td>{{ $servicio->nombre }}</td>
                <th>Patología</th>
                <td>{{ $patologia->nombre }}</td>
            </tr>
            <tr>
                <th>Notificador</th>
                <td>{{ $formulario->notificador }}</td>
                <th>Firma Notificador</th>
                <td></td>
            </tr>
            <tr>
                <th>Acciones</th>
                <td colspan="3">{{ $formulario->acciones }}</td>
            </tr>
            <tr>
                <th>Observaciones</th>
                <td colspan="3">{{ $formulario->observaciones }}</td>
            </tr>
        </table>

    </div>
    <div class="form-container">
        <h5>DATOS ENCARGADO LLENADO DE FICHA</h5>
        <table>
            <tr>
                <th>Nombre:</th>
                <td>Dr. {{ Auth::user()->persona->nombres }}</td>
                <th>Cargo</th>
                <td>{{ Auth::user()->profesion  }}</td>
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
