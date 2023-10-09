<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Informe Anual Por Servicios Enf. Notificación Inmediata</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte Anual Por Servicios Enfermedades de Notificación Inmediata</h1>
        <h2 class="text-center">Gestión {{$fecha_select}}</h2>
        @foreach($informePatologias as $row)
            @if($loop->first || $row->servicio !== $currentService)
                <h2>Servicio: {{ $row->servicio }}</h2>
                <table class="table">
                    <thead>
                        <tr class="table-header">
                            <th>Patología</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $currentService = $row->servicio;
                        $totalCasosPorServicio = 0;
                    @endphp
            @endif

            <tr>
                <td>{{ $row->patologia }}</td>
                <td>{{ $row->cantidad }}</td>
            </tr>

            @php
                $totalCasosPorServicio += $row->cantidad;
            @endphp

            @if($loop->last || $informePatologias[$loop->index + 1]->servicio !== $currentService)
                    <tr class="table-footer">
                        <th>Total Casos en {{ $row->servicio }}</th>
                        <th>{{ $totalCasosPorServicio }}</th>
                    </tr>
                    </tbody>
                </table>
            @endif
        @endforeach
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>
</body>
</html>


