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
                <p>Departamento de Representación</p>
                <p>Blvd. Paseo Cuauhnáhuac 8532, Progreso, 62550 Jiutepec, Mor.</p>
            </div>
        </header>
        
        <h1>Reporte de Servidores Omisos</h1>

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