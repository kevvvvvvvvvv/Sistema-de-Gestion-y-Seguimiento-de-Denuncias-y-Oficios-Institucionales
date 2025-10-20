<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Ingresos</title>
    <style>

        @page {
            size: letter;
            margin: 0.5in;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px; 
            background-color: #f0f0f0; 
        }
        .ticket-container {

            width: 4.5in;  
            height: 5.75in; 
            border: 1px solid #666; 
            background-color: #fff;
            box-sizing: border-box; 
            padding: 10px;
            display: flex;
            flex-direction: column;
            margin: auto; 
        }

        * {
            box-sizing: border-box;
        }
        .bordered {
            border: 1px solid #000;
        }
        .header-bar {
            background-color: #e0e0e0; 
            font-weight: bold;
            text-align: center;
            padding: 4px;
            font-size: 11pt;
        }
        .label {
            font-weight: bold;
            font-size: 10pt;
        }

        .ingreso{
            font-size: 13px;
        }


        .light-gray-bg {
            background-color: #e0e0e0; 
        }

        .flex-row {
            display: flex;
            flex-direction: row;
        }
        .flex-col {
            display: flex;
            flex-direction: column;
        }
        .flex-grow {
            flex-grow: 1;
        }

        .buen-gobierno-cell {
            padding: 5px;
            text-align: center;
            border-left: 1px solid black;
            width: 60%; 
        }
        .buen-gobierno-cell img {
            max-width: 100%;
            height: auto;
            display: block; 
            margin: 0 auto 3px auto; 
        }
        .buen-gobierno-cell .sub-text {
            font-size: 6pt;
        }
        .control-ingresos {
            background-color: #e0e0e0;
            padding: 10px;
            font-weight: bold;
            font-size: 11pt;
            display: flex;
            align-items: center;
            width: 40%; 
        }
        .full-width-cell {
            padding: 4px;
        }
        .turnado-grid {
            display: grid;
            grid-template-columns: 50px repeat(6, 1fr);
            text-align: center;
        }
        .turnado-grid > div {
            border-right: 1px solid black;
            border-top: 1px solid black;
            padding: 4px;
            font-size: 9pt;
        }
        .turnado-grid > div:last-child {
            border-right: none;
        }
        .turnado-label {
             border-top: 1px solid black;
             padding: 4px 8px;
             width: 120px; 
             flex-shrink: 0;
        }
        .large-section {
            border-top: 1px solid black;
            padding-top: 10px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1.5fr 1fr;
            border-top: 1px solid black;
        }
        .footer-cell {
            border-right: 1px solid black;
            padding: 4px;
        }
        .footer-cell:last-child {
            border-right: none;
        }
        .empty-box {
            height: 25px; 
        }
        .asunto-box-content {
            font-size: 12px;
             height: 60px;
        }
         .instruccion-box-content {
             height: 60px;
             font-size: 12px;
        }
        .resultados-box-content {
             height: 60px;
            font-size: 12px;
        }

    </style>
</head>
<body>
    <div class="ticket-container">
        
        <div class="header-bar bordered">Oficina de Representación IMTA</div>

        <div class="flex-row bordered" style="border-top: none;">
            <div class="control-ingresos">
                Control de Ingresos de Documentos
            </div>
            <div class="buen-gobierno-cell">
                
                <img src="{{ $imagenGobierno }}" alt="Logo Buen Gobierno">
            </div>
        </div>

        <div class="flex-row bordered" style="border-top: none;">
            <div class="full-width-cell light-gray-bg" style="width: 120px; border-right: 1px solid black;"><span class="label ingreso">Fecha de ingreso</span></div>
            <div class="full-width-cell flex-grow">{{$viajero->oficio['fechaLlegada']}}</div>
        </div>

        <div class="flex-row bordered" style="border-top: none;">
            <div class="turnado-label light-gray-bg"><span class="label">Turnado a:</span></div>
            <div class="flex-grow">
                <div class="turnado-grid" style="border-top: none;">
                    <div>JFT</div> <div>OGB</div> <div>PARP</div> <div>ACG</div> <div>ACM</div> <div>AMAN</div> <div>JAST</div>
                </div>
                <div class="turnado-grid" style="height: 25px;">
                    <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div>
                </div>
            </div>
        </div>
        
        <div class="bordered" style="border-top: none; padding: 4px;">
            <span class="label light-gray-bg" style="padding: 4px; display: inline-block;">ASUNTO</span>
            <div class="asunto-box-content">{{$viajero['asunto']}}</div> 
        </div>

        <div class="flex-col flex-grow bordered" style="border-top: none;">
            <div class="large-section flex-grow">
                <div class="header-bar">INSTRUCCIÓN</div>
                <div class="instruccion-box-content">{{$viajero['instruccion']}}</div> 
            </div>
            <div class="large-section flex-grow">
                <div class="header-bar">RESULTADOS</div>
                <div class="resultados-box-content">{{$viajero['resultado']}}</div>
            </div>
        </div>

        <div class="bordered" style="border-top: none;">
             <div class="footer-grid">
                <div class="footer-cell light-gray-bg"><span class="label">Fecha de descarga</span></div>
                <div class="footer-cell light-gray-bg"><span class="label">Rubrica</span></div>
                <div class="footer-cell light-gray-bg"><span class="label">Folio</span></div>
            </div>
             <div class="footer-grid empty-box">
                <div class="footer-cell">{{now()->format('Y-m-d')}}</div>
                <div class="footer-cell"></div>
                <div class="footer-cell">{{$viajero['folio']}}</div>
            </div>
        </div>

    </div>
</body>
</html>