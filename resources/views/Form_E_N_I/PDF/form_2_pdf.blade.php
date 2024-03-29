<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulario Enfermedades Notificacion Inmediata</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
    <style>
        .form-container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 20px;
            margin-top:10px
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
            text-align:
        }

        th {
            text-align: left;
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Ficha de Enfermedades de Notificación Inmediata</h1>

        <div class="form-container">
            <h5>DATOS PACIENTE</h5>
            <table class="table">
                <tr>
                    <th>H. Clinico</th>
                    <td>
                        @foreach ($paciente as $pacienteInfo)
                            {{ $pacienteInfo['hcl_codigo'] }} <br>
                        @endforeach
                    </td>
                    <th>Paciente</th>
                    <td>
                        @foreach ($paciente as $pacienteInfo)
                            {{ $pacienteInfo['nombre'] }} {{ $pacienteInfo['ap_paterno'] }} {{ $pacienteInfo['ap_materno'] }}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Fecha de reporte</th>
                    <td>{{ $formulario->fecha }}</td>
                    <th>Fecha de admisión</th>
                    <td>{{ $formulario->fecha_admision }}</td>
                </tr>
                <tr>
                    <th>Edad</th>
                    <td>
                        @foreach ($paciente as $pacienteInfo)
                            {{ $pacienteInfo['edad'] }}<br>
                        @endforeach
                    </td>
                    <th>Sexo</th>
                    <td>
                        @foreach ($paciente as $pacienteInfo)
                            {{ $pacienteInfo['sexo'] }}<br>
                        @endforeach
                    </td>

                </tr>
            </table>
        </div>
        <div class="form-container">
            <h5 >LLENADO DEL FORMULARIO</h5>
            <table class="table">
                <tr>
                    <th>Servicio</th>
                    <td>{{ $servicio->nombre }}</td>
                    <th>Patología</th>
                    <td>
                        @foreach ($patologias as $patologia)
                            {{ $patologia->nombre }}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Notificador</th>
                    <td>{{ $formulario->notificador }}</td>
                    <th>Firma Notificador</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Acciones</th>
                    <td colspan="3" style="text-align: left">{{ $formulario->acciones }}</td>
                </tr>
                <tr>
                    <th>Observaciones</th>
                    <td colspan="3" style="text-align: left">{{ $formulario->observaciones }}</td>
                </tr>
            </table>

        </div>
        <div class="form-container">
            <h5>DATOS ENCARGADO LLENADO DE FICHA</h5>
            <table class="table">
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
            <h5>{{ Auth::user()->cargo}}</h5>
            <h5>{{ Auth::user()->matricula_profesion}}</h5>
        </div>
    </div>
</body>
</html>
