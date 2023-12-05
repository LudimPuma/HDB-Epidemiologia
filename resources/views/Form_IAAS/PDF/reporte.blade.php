<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Mensual - IAAS</title>
    <link rel="stylesheet" href="{{ asset('pdf/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('pdf/pdf.css') }}" />
</head>
<body>
    <div class="container" >
        <h1 class="text-center">Reporte Mensual Antibiograma {{ $nombreMesSeleccionado }} - {{ $anioSeleccionado }}</h1>
        <table  class="table " >
            <thead>
                <tr class="table-header">
                    <th >Bacteria</th>
                    <th >Antibioticos</th>
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
                                <th rowspan="{{ count($medicamentos) }}"   scope="row">{{ $bacteria }}</th>
                                @php $isFirstRow = false; @endphp
                            @endif

                            <td >{{ $medicamento }}</td>
                            <td  >{{ $niveles['Resistente'] }}%</td>
                            <td  >{{ $niveles['Intermedio'] }}%</td>
                            <td  >{{ $niveles['Sensible'] }}%</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
        <div class="signature-container">
            <h5>{{ Auth::user()->persona->nombres }} {{ Auth::user()->persona->apellidos }}</h5>
        </div>
    </div>
</body>
</html>
