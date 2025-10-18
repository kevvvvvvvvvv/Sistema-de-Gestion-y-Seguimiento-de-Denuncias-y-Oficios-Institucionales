<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viajero Finalizado</title>
    <style>
        /* Estilos generales para el cuerpo del correo */
        body {
            margin: 0;
            padding: 0;
            width: 100% !important;
            background-color: #F9F7F5;
            font-family: Arial, sans-serif;
            color: #333;
        }
        /* Contenedor principal */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }
        /* Contenido del correo */
        .content {
            padding: 40px;
        }
        /* Títulos y párrafos */
        h1 {
            font-size: 24px;
            margin-top: 0;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
            margin: 16px 0;
        }
        /* Lista de datos */
        ul {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            border-left: 3px solid #22509C; 
            padding-left: 20px;
        }
        li {
            font-size: 16px;
            margin-bottom: 10px;
        }
        /* Box de instrucciones */
        .instruccion {
            background-color: #D9D9D9;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        /* Botón de acción */
        .button {
            display: inline-block;
            background-color: #22509C; 
            color: #ffffff !important; 
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }
        /* Pie de página */
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <table class="container" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="content">
                <h1>¡Hola!</h1>

                <p>Se ha actualizado un viajero en el sistema con los siguientes datos de identificación:</p>

                <ul>
                    <li><strong>Folio del viajero:</strong> {{ $viajero->folio }}</li>
                    <li><strong>Número del oficio:</strong> {{ $oficio->numOficio }}</li>
                    <li><strong>Asunto:</strong> {{ $viajero->asunto }}</li>
                </ul>

                <p>Los resultados reportados son las siguientes:</p>
                <p class="instruccion">{{ $viajero->resultado }}</p>

                <p>Puedes revisar los detalles completos y gestionar el viajero haciendo clic en el siguiente botón:</p>

                <p style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
                    <a href="{{ route('viajeros.edit', $viajero->folio) }}" class="button">Ver viajero en el sistema</a>
                </p>

                <p>Si no esperabas esta notificación, puedes omitir este mensaje.</p>
                <p>Saludos,<br>Sistema-de-Gestión-de-Denuncias-y-Oficios-Institucionales</p>
            </td>
        </tr>
    </table>
    <div class="footer">
        © {{ date('Y') }} Sistema-de-Gestión-de-Denuncias-y-Oficios-Institucionales.
    </div>
</body>