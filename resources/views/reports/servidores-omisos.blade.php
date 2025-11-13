<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de servidores omisos</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @page {
            margin-top: 20mm;
            margin-right: 15mm;
            margin-bottom: 15mm;
            margin-left: 15mm;
        }

        body { font-family: sans-serif; }
        .report-container { max-width: 800px; margin: auto; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-container">
            <table style="width: 100%; border: none; border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 30px;">
                <tbody>
                    <tr>
                        <td style="width: 210px; border: none; padding: 0; vertical-align: top;">
                            <img src="{{ $logoBase64 }}" alt="Logo IMTA" style="width: 200px;">
                        </td>
                        <td style="text-align: right; font-size: 11px; color: #555; border: none; padding: 0; vertical-align: top;">
                            <p style="margin: 0;"><strong>Instituto Mexicano de Tecnología del Agua</strong></p>
                            <p style="margin: 0;">Oficina de Representación en el IMTA del OIC-SEMARNAT</p>
                            <p style="margin: 0;">Blvd. Paseo Cuauhnáhuac 8532, Progreso, 62550 Jiutepec, Mor.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <h1>Reporte de servidores omisos</h1>

        <div>
            @if(!empty($filtro))
                <p>Filtro aplicado: {{ $filtro }}</p>
            @else
                <p>Mostrando todos los registros sin filtrar.</p>
            @endif
        </div>

        <br>

        <p>No. de servidores omisos sin Acuerdo de Conclusión: {{ $numOmisosBaja }}</p>
        <p>No. de servidores omisos sin Acuerdo de Inicio: {{ $numOmisosAlta }}</p>

        <br>

        <h2>Servidores omisos por falta del Acuerdo de Conclusión</h2>
        <table>
            <thead>
                <tr>
                    <th>Número de expediente</th>
                    <th>Nombre completo del servidor</th>
                    <th>Institución anterior del servidor</th>
                    <th>Departamento anterior del servidor</th>
                    <th>Fecha de la baja</th>
                    <th>Descripción de la baja</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servidoresOmisosBaja as $servidor)
                    <tr>
                        <td>{{ $servidor->numero }}</td>
                        <td>{{ $servidor->nombreCompleto }}</td>
                        <td>{{ $servidor->institucion }}</td>
                        <td>{{ $servidor->departamento }}</td>
                        <td>{{ $servidor->fechaBaja }}</td>
                        <td>{{ $servidor->descrBaja }}</td>
                        <td>
                            <ul>
                                <li><span>Fecha límite para entregar el acuerdo:</span>{{ $servidor->fechaLimite }}</li>
                                <li><span>Días desde la omisión:</span>{{ $servidor->difDias }}</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

        <h2>Servidores omisos por falta del Acuerdo de Inicio</h2>
        <table>
            <thead>
                <tr>
                    <th>Número de expediente</th>
                    <th>Nombre completo del servidor</th>
                    <th>Institución actual del servidor</th>
                    <th>Departamento actual del servidor</th>
                    <th>Fecha de la alta (reingreso)</th>
                    <th>Descripción de la alta</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                @foreach($servidoresOmisosAlta as $servidor)
                    <tr>
                        <td>{{ $servidor->numero }}</td>
                        <td>{{ $servidor->nombreCompleto }}</td>
                        <td>{{ $servidor->institucion }}</td>
                        <td>{{ $servidor->departamento }}</td>
                        <td>{{ $servidor->fechaIngreso }}</td>
                        <td>{{ $servidor->descrAlta }}</td>
                        <td>
                            <ul>
                                <li><span>Fecha límite para entregar el acuerdo:</span>{{ $servidor->fechaLimite }}</li>
                                <li><span>Días desde la omisión:</span>{{ $servidor->difDias }}</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>