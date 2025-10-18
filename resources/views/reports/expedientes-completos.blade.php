<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de expedientes completos</title>
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
        
        <h1>Reporte de Expedientes Completos</h1>

        <div>
            @if($filtro)
                <p><strong>Mostrando resultados para la institución:</strong> {{ $filtro }}</p>
            @else
                <p><strong>Mostrando resultados para todas las instituciones.</strong></p>
            @endif
        </div>

        <br>

        <p>Número de expedientes completos: {{ $conteo }}</p>
        <p>Número de expedientes incompletos: {{ $exIncompletos }}</p>

        <br>

        <h2>Comparación entre los expedientes completos e incompletos</h2>
        <canvas id="myChart"></canvas>

        <br>
        <hr>
        <br>

        <h2>Expedientes completos</h2>
        <table>
            <thead>
                <tr>
                    <th>Número de expediente</th>
                    <th>Nombre completo del servidor</th>
                    <th>Institución del servidor</th>
                    <th>Departamento del servidor</th>
                    <th>Oficio de requerimiento</th>
                    <th>Fecha del oficio de requerimiento</th>
                    <th>Oficio de respuesta</th>
                    <th>Fecha del oficio de respuesta</th>
                    <th>Fecha de recepción del oficio de respuesta</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ofCompletos as $ofCompleto)
                    <tr>
                        <td>{{ $ofCompleto->numero }}</td>
                        <td>{{ $ofCompleto->nombreCompleto }}</td>
                        <td>{{ $ofCompleto->nomInstitucion }}</td>
                        <td>{{ $ofCompleto->departamento }}</td>
                        <td>{{ $ofCompleto->ofRequerimiento }}</td>
                        <td>{{ $ofCompleto->fechaRequerimiento }}</td>
                        <td>{{ $ofCompleto->ofRespuesta }}</td>
                        <td>{{ $ofCompleto->fechaRespuesta }}</td>
                        <td>{{ $ofCompleto->fechaRecepcion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const conteo = @json($conteo);
        const exIncompletos = @json($exIncompletos);

        const data = {
            labels: ['Completos', 'Incompletos'],
            datasets: [{
                data: [conteo, exIncompletos],
                backgroundColor: ['#90ed7d', '#f45b5b']
            }]
        };

        const config = {
            type: 'bar', 
            data: data,
            options: {
                responsive: true,
                animation: false,
                plugins: {
                    legend: {
                        display: false 
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Número de expedientes'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tipo de expediente'
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('myChart'), config);
    </script>
</body>
</html>