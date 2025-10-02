{{-- resources/views/reports/viajeros-imprimible.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Seguimiento de Viajeros</title>
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

        h1, h2 {
            text-align: center;
            color: #333;
        }

        .date-range {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-top: -15px;
            margin-bottom: 30px;
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
        
        <h1>Reporte de Seguimiento de Viajeros</h1>

        @if($fechaInicio && $fechaFin)
            <p class="date-range">
                Periodo del {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
            </p>
        @endif

        <h2>Resumen por Estado</h2>
        <table>
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Total de Viajeros</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datos as $item)
                <tr>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No hay datos de resumen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <h2>Gráfico por Estado</h2>
        <div style="margin-bottom: 30px;">
            <canvas id="myChart"></canvas>
        </div>

        <h2>Detalle de Viajeros</h2>
        <table>
            <thead>
                <tr>
                    <th>No. Oficio</th>
                    <th>Fecha Llegada</th>
                    <th>Estado</th>
                    <th>Asunto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datosTabla as $fila)
                    <tr>
                        <td>{{ $fila->numOficio }}</td>
                        <td>{{ \Carbon\Carbon::parse($fila->fechaLlegada)->format('d/m/Y') }}</td>
                        <td>{{ $fila->status }}</td>
                        <td>{{ $fila->asunto }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No se encontraron registros detallados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <script>

        const resumenData = @json($datos);
        const labels = resumenData.map(item => item.status);
        const data = resumenData.map(item => item.total);
        const config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Viajeros por Estado',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)' 
                }]
            },
            options: {
                responsive: true,
                animation: false, 
                scales: { 
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 
                        }
                    } 
                }
            }
        };
        new Chart( document.getElementById('myChart'), config );
    </script>
</body>
</html>