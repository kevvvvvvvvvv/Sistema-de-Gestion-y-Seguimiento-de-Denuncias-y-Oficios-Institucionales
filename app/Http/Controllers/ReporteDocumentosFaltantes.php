<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

class ReporteDocumentosFaltantes extends Controller
{
    public function showDocumentosFaltantes()
    {
        $datos = DB::select('select servidor.nombreCompleto, expediente.numero, 
        control.acProrroga as "Acuerdo de Prórroga", 
        control.acAuxilio as "Acuerdo de Auxilio para personal OR",
        control.acRegularizacion as "Acuerdo de Regularización", 
        control.acRequerimiento as "Acuerdo de Requerimiento de Declaración Patrimonial",
        control.acOficioReque as "Oficio de Requerimiento de Declaración Patrimonial",
        control.acInicio as "Acuerdo de Inicio",   
        control.acModificacion as "Acuerdo de Modificacion",   
        control.acConclusion as "Acuerdo de Conclusión y Archivo",   
        expediente.ofRespuesta
        from servidor inner join expediente on servidor.idServidor = expediente.idServidor
        inner join control on control.numero = expediente.numero;');

        $datosReporte = [];

        foreach ($datos as $dato) {
            $nombreCompleto = $dato->nombreCompleto;

            if (is_null($dato->numero)) {
                $numero = 'Sin número de expediente asignado';
            }else{
                $numero = $dato->numero;
            }

            //Conteo de los documentos faltantes
            $totalFaltantes = 0;
            $ofFaltantes = [];

            foreach ($dato as $campo => $valor) {
                //Ignorar campos que no son documentos
                if (in_array($campo, ['ofRespuesta', 'nombreCompleto', 'numero'])) {
                    continue;
                }

                if ($valor === 'No') {
                    $ofFaltantes[] = $campo;
                    $totalFaltantes++;
                }
            }

            //Verficiar el oficio de respuesta
            if (is_null($dato->ofRespuesta)){
                $ofFaltantes[] = 'Oficio de Respuesta';
                $totalFaltantes++;
            }

            //Guardar los datos en el arreglo para el reporte, solo si existen documentos faltantes
            if($totalFaltantes != 0) {
                $datosReporte[] = [
                    'nombreCompleto' => $nombreCompleto,
                    'numero' => $numero,
                    'ofFaltantes' => $ofFaltantes,
                    'totalFaltantes' => $totalFaltantes
                ];
            }

            $conteo = count($datosReporte);
            
        }

        return Inertia::render('Reportes/DocumentosFaltantes', ['datosReporte' => $datosReporte, 'conteo' => $conteo]);
    }
}
