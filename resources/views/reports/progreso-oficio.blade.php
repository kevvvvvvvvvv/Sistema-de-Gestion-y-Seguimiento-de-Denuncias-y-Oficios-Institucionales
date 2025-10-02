<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Progreso de Oficios</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; }
        .report-container { max-width: 800px; margin: auto; }
        .header { display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #ccc; padding-bottom: 10px; margin-bottom: 30px; }
        .header img { width: 200px; }
        .header .address { text-align: right; font-size: 11px; color: #555; }
        .header .address p { margin: 0; }
        h1, h2 { text-align: center; color: #333; }
        .filter-date { text-align: center; font-size: 14px; color: #555; margin-top: -15px; margin-bottom: 30px; }
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
        
        <h1>Reporte de Progreso de Oficios</h1>
        @if($filtro)
            <p class="filter-date">
                Datos filtrados para la fecha de entrega: {{ \Carbon\Carbon::parse($filtro)->format('d/m/Y') }}
            </p>
        @endif

        <h2>Resultados</h2>
        <table>
            <thead>
                <tr>
                    <th>Categoría / Fecha de Entrega</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resultados as $item)
                <tr>
                    <td>{{ $item->Categoria }}</td>
                    <td>{{ $item->Total }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2">No se encontraron resultados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <h2>Gráfico de Distribución</h2>
        <div style="margin: 0 auto 30px auto;">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <script>
        const resultadosData = @json($resultados);
        const labels = resultadosData.map(item => item.Categoria);
        const data = resultadosData.map(item => item.Total);
        
        const config = {
            type: 'bar', 
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Oficios',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
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
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        };
        new Chart(document.getElementById('myChart'), config);
    </script>
</body>
</html>