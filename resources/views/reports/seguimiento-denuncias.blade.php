<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de seguimiento de denuncias</title>
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
        
        <h1>Reporte de Seguimiento de Denuncias</h1>

        <br>

        <table>
            <thead>
                <tr>
                    <th>Número de expediente</th>
                    <th>Nombre completo del servidor</th>
                    <th>Institución del servidor</th>
                    <th>Fecha del oficio de requerimiento</th>
                    <th>Estado actual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datosReporte as $datoReporte)
                    <tr>
                        <td>{{ $datoReporte->numero }}</td>
                        <td>{{ $datoReporte->nombreCompletoSer }}</td>
                        <td>{{ $datoReporte->nombreCompletoIns }}</td>
                        <td>{{ $datoReporte->fechaRequerimiento }}</td>
                        <td>{{ $datoReporte->Estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>