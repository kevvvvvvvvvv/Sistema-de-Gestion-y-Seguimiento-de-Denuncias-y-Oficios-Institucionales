<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Denuncias por Institución</title>
    <style>
        /* Traducción simple de tus clases de Tailwind a CSS plano */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .text-center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }
        .w-full {
            width: 100%;
        }
        .mt-8 {
            margin-top: 2rem; /* 32px */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }
        thead {
            background-color: #f2f2f2;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

    <h2 class="w-full text-center font-bold">Total de expedientes por institución</h2>

    <img src="{{ $chartUrl }}" alt="Gráfico de denuncias" style="width: 100%;">

    <div class="mt-8">
        <table class="w-full">
            <thead>
                <tr>
                    <th>Institución</th>
                    <th>Total de expedientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($denuncias as $denuncia)
                    <tr>
                        <td>{{ $denuncia->nombre }}</td>
                        <td class="text-center">{{ $denuncia->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>