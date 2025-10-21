{{-- resources/views/reports/denuncias-imprimible.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Denuncias por Institución</title>
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
        
        <h1>Reporte de Denuncias por Institución</h1>

        <table>
            <thead>
                <tr>
                    <th>Institución</th>
                    <th>Total de Expedientes</th>
                    <th>Fecha de requerimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($denuncias as $denuncia)
                <tr>
                    <td>{{ $denuncia->nombre }}</td>
                    <td>{{ $denuncia->total }}</td>
                    <td>{{ $denuncia->fechaRequerimiento}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Gráfico de Expedientes</h2>
        <canvas id="myChart"></canvas>
    </div>

    <script>
        const denunciasData = @json($denuncias);
        const labels = denunciasData.map(item => item.nombre);
        const data = denunciasData.map(item => item.total);
        const config = {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Expedientes',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)'
                }]
            },
            options: {
                responsive: true,
                animation: false,
                scales: { y: { beginAtZero: true } }
            }
        };
        new Chart( document.getElementById('myChart'), config );
    </script>
</body>
</html>