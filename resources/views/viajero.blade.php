<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Ingresos</title>
    <style>
        @page {
            margin-top: 20mm;
            margin-right: 15mm;
            margin-bottom: 15mm;
            margin-left: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px; 
            background-color: #fff; 
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        
        td {
            padding: 4px;
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .text-xs { font-size: 10px; }
        .text-sm { font-size: 12px; }
        .bg-gray { background-color: #e0e0e0; }
        
        .border-all { border: 1px solid #000; }
        .border-bottom { border-bottom: 1px solid #000; }
        .border-right { border-right: 1px solid #000; }
        .border-top { border-top: 1px solid #000; }
        .no-border-top { border-top: none; }
        .no-border-bottom { border-bottom: none; }

        .ticket-container {
            width: 4.5in;  
            height: 5.75in; 
            margin: 0 auto;
            border: 1px solid #000;
        }

        .header-bar {
            background-color: #e0e0e0;
            font-weight: bold;
            text-align: center;
            padding: 5px;
            font-size: 11pt;
            border-bottom: 1px solid #000;
        }

        .section-title {
            font-weight: bold;
            font-size: 11pt;
        }

        .label {
            font-weight: bold;
            font-size: 10pt;
        }

        .content-box {
            min-height: 60px;
            font-size: 12px;
            padding: 5px;
            vertical-align: top;
        }

        .img-cell {
            text-align: center;
            vertical-align: middle;
            padding: 5px;
        }
        .img-cell img {
            max-height: 60px; 
            width: auto;
            max-width: 3in;
        }

        .turnado-table td {
            border-right: 1px solid #000;
            text-align: center;
            font-size: 9pt;
            width: 14%; 
            padding: 2px;
        }
        .turnado-table td:last-child {
            border-right: none;
        }
    </style>
</head>
<body>

    <div class="ticket-container">
        
        <div class="header-bar">Oficina de Representación IMTA</div>

        <table class="no-border-top">
            <tr>
                <td class="bg-gray section-title border-right border-bottom" style="width: 40%;">
                    Control de Ingresos de Documentos
                </td>
                <td class="img-cell border-bottom" style="width: 60%;">
                    <img src="{{ $imagenGobierno }}" alt="Logo Buen Gobierno">
                </td>
            </tr>
        </table>

        <table class="no-border-top">
            <tr>
                <td class="bg-gray label border-right border-bottom" style="width: 120px;">
                    Fecha de ingreso
                </td>
                <td class="border-bottom">
                    {{ $viajero->oficio['fechaLlegada'] ?? 'Sin fecha' }}
                </td>
            </tr>
        </table>

        <table class="no-border-top">
            <tr>
                <td class="bg-gray label border-right border-bottom" style="width: 120px;">
                    Turnado a:
                </td>
                <td class="border-bottom" style="padding: 0;">
                    <table class="turnado-table">
                        <tr>
                            <td class="border-bottom">JFT</td>
                            <td class="border-bottom">OGB</td>
                            <td class="border-bottom">PARP</td>
                            <td class="border-bottom">ACG</td>
                            <td class="border-bottom">ACM</td>
                            <td class="border-bottom">AMAN</td>
                            <td class="border-bottom">JAST</td>
                        </tr>
                        <tr style="height: 25px;">
                            <td>&nbsp;</td> <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="border-bottom" style="padding: 0;">
            <div class="bg-gray label" style="padding: 4px; display: inline-block; border-right: 1px solid #000; border-bottom: 1px solid #000;">
                ASUNTO
            </div>
            <div class="content-box">
                {{ $viajero['asunto'] }}
            </div>
        </div>

        <div class="header-bar border-bottom no-border-top">INSTRUCCIÓN</div>
        <div class="content-box border-bottom">
            {{ $viajero['instruccion'] }}
        </div>

        <div class="header-bar border-bottom no-border-top">RESULTADOS</div>
        <div class="content-box border-bottom">
            {{ $viajero['resultado'] }}
        </div>

        <table class="no-border-top">
            <tr>
                <td class="bg-gray label text-center border-right border-bottom" style="width: 37%;">Fecha de descarga</td>
                <td class="bg-gray label text-center border-right border-bottom" style="width: 37%;">Rubrica</td>
                <td class="bg-gray label text-center border-bottom" style="width: 26%;">Folio</td>
            </tr>
            <tr>
                <td class="text-center border-right" style="height: 30px;">{{ now()->format('Y-m-d') }}</td>
                <td class="text-center border-right"></td>
                <td class="text-center font-bold">{{ $viajero['folio'] }}</td>
            </tr>
        </table>

    </div>

</body>
</html>