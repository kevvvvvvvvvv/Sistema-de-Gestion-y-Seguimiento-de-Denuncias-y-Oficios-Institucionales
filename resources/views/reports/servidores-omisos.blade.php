<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de servidores omisos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; }
        .report-container { max-width: 800px; margin: auto; }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .header img {
            width: 200px; 
        }
        .header .address {
            text-align: right;
            font-size: 11px;
            color: #555;
        }
        .header .address p {
            margin: 0;
        }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="report-container">
        <header class="header">
            <img src="{{ $logoBase64 }}" alt="Logo IMTA">
            <div class="address">
                <p><strong>Instituto Mexicano de Tecnología del Agua</strong></p>
                <p>Oficina de Representación en el IMTA del OIC-SEMARNAT</p>
                <p>Blvd. Paseo Cuauhnáhuac 8532, Progreso, 62550 Jiutepec, Mor.</p>
            </div>
        </header>
        
        <h1>Reporte de servidores omisos</h1>

        <div>
            @if($filtroInstitucion)
                <p><strong>Mostrando resultados para la institución:</strong> {{ $filtroInstitucion }}</p>
            @else
                <p><strong>Mostrando resultados para todas las instituciones.</strong></p>
            @endif

            @if($filtroDocumento === 'inicio')
                <p><strong>Filtrando por:</strong> Falta Acuerdo de Inicio</p>
            @elseif($filtroDocumento === 'modificacion')
                <p><strong>Filtrando por:</strong> Falta Acuerdo de Modificación</p>
            @elseif($filtroDocumento === 'conclusion')
                <p><strong>Filtrando por:</strong> Falta Acuerdo de Conclusión</p>
            @else
                <p><strong>Mostrando todos los estados de documentos.</strong></p>
            @endif
        </div>

        <br>

        <p>No. de servidores omisos: {{ count($servidoresOmisos) }}</p>

        <br>

        <table>
            <thead>
                <tr>
                    <th>Núm. expediente</th>
                    <th>Nombre completo</th>
                    <th>Institución</th>
                    <th>Departamento</th>
                    <th>Ac. Inicio</th>
                    <th>Ac. Modif.</th>
                    <th>Ac. Concl.</th>
                    <th>Detalles de omisión</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($servidoresOmisos as $servidor)
                    <tr>
                        <td>{{ $servidor->numero }}</td>
                        <td>{{ $servidor->nombreCompleto }}</td>
                        <td>{{ $servidor->institucion }}</td>
                        <td>{{ $servidor->departamento }}</td>
                        <td>{{ $servidor->acInicio }}</td>
                        <td>{{ $servidor->acModificacion }}</td>
                        <td>{{ $servidor->acConclusion }}</td>
                        <td>
                            <ul>
                                @if($servidor->acInicio === 'No')
                                    <li><b>Inicio:</b> {{ $servidor->fechaLimiteIni }} (<b>Días:</b> {{ $servidor->difDiasIni }})</li>
                                @endif
                                @if($servidor->acModificacion === 'No')
                                    <li><b>Modif.:</b> {{ $servidor->fechaLimiteModi }} (<b>Días:</b> {{ $servidor->difDiasModi }})</li>
                                @endif
                                @if($servidor->acConclusion === 'No')
                                    <li><b>Concl.:</b> {{ $servidor->fechaLimiteCon }} (<b>Días:</b> {{ $servidor->difDiasCon }})</li>
                                @endif
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>