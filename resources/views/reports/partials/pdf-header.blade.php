{{-- resources/views/reports/partials/pdf-header.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
            color: #333;
            width: 100%;
        }
        .header-container {
            display: flex;
            align-items: center; 
            justify-content: space-between; 
            width: 100%;
            padding: 0 10mm; 
            box-sizing: border-box; 
        }
        .logo {
            width: 150px; 
            height: auto;
        }
        .address {
            text-align: right;
        }
        .address p {
            margin: 2px 0; 
        }
    </style>
</head>
<body>
    <div class="header-container">
        <img src="{{ $logo }}" alt="Logo IMTA" class="logo">

        <div class="address">
            <p><strong>Instituto Mexicano de Tecnología del Agua</strong></p>
            <p>Departamento de Representación</p>
            <p>Blvd. Paseo Cuauhnáhuac 8532, Progreso, 62550 Jiutepec, Mor.</p>
        </div>
    </div>
</body>
</html>