<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

class ReporteSeguimientoDenunciasController extends Controller
{
    public function showSeguimietoDenuncias(){
        $datosReporte = DB::select('
            SELECT
                exp.numero,
                srv.nombreCompleto AS nombreCompletoSer,
                inst.nombreCompleto AS nombreCompletoIns,
                exp.fechaRequerimiento,
                CASE
                    -- Condición para "Fin": Todos los campos de control son "Si", y el expediente tiene el oficio de respuesta
                    WHEN ((exp.ofRespuesta IS NOT NULL OR exp.ofRespuesta != "") AND ctrl.acProrroga = "Si" AND ctrl.acAuxilio = "Si" AND ctrl.acRegularizacion = "Si" AND ctrl.acRequerimiento = "Si" AND ctrl.acOficioReque = "Si" AND ctrl.acInicio = "Si" AND ctrl.acModificacion = "Si" AND ctrl.acConclusion = "Si")
                        THEN "Finalizado"
                    
                    -- Condición para "Inicio": Todos los campos de control son "No"
                    WHEN ((exp.ofRespuesta IS NOT NULL OR exp.ofRespuesta != "") AND ctrl.acProrroga = "No" AND ctrl.acAuxilio = "No" AND ctrl.acRegularizacion = "No" AND ctrl.acRequerimiento = "No" AND ctrl.acOficioReque = "No" AND ctrl.acInicio = "No" AND ctrl.acModificacion = "No" AND ctrl.acConclusion = "No")
                        THEN "Inicio"

                    -- Condición para "En Proceso": El oficio de respuesta existe
                    WHEN (exp.ofRespuesta IS NOT NULL AND exp.ofRespuesta != "")
                        THEN "En Proceso"

                    -- Un estado por defecto si no se cumple ninguna de las anteriores
                    ELSE "En espera del oficio de respuesta"
                END AS "Estado"
            FROM
                expediente AS exp
            INNER JOIN
                servidor AS srv ON exp.idServidor = srv.idServidor
            INNER JOIN
                institucion AS inst ON srv.idInstitucion = inst.idInstitucion
            LEFT JOIN
                control AS ctrl ON exp.numero = ctrl.numero;
        ');

        return Inertia::render('Reportes/SeguimientoDenuncias', ['datosReporte' => $datosReporte]);
    }

    public function descargarReporteSegDenuPdf() {
        try {
            // DATOS PARA EL REPORTE
            $datosReporte = DB::select('
                SELECT
                    exp.numero,
                    srv.nombreCompleto AS nombreCompletoSer,
                    inst.nombreCompleto AS nombreCompletoIns,
                    exp.fechaRequerimiento,
                    CASE
                        -- Condición para "Fin": Todos los campos de control son "Si", y el expediente tiene el oficio de respuesta
                        WHEN ((exp.ofRespuesta IS NOT NULL OR exp.ofRespuesta != "") AND ctrl.acProrroga = "Si" AND ctrl.acAuxilio = "Si" AND ctrl.acRegularizacion = "Si" AND ctrl.acRequerimiento = "Si" AND ctrl.acOficioReque = "Si" AND ctrl.acInicio = "Si" AND ctrl.acModificacion = "Si" AND ctrl.acConclusion = "Si")
                            THEN "Finalizado"
                        
                        -- Condición para "Inicio": Todos los campos de control son "No"
                        WHEN ((exp.ofRespuesta IS NOT NULL OR exp.ofRespuesta != "") AND ctrl.acProrroga = "No" AND ctrl.acAuxilio = "No" AND ctrl.acRegularizacion = "No" AND ctrl.acRequerimiento = "No" AND ctrl.acOficioReque = "No" AND ctrl.acInicio = "No" AND ctrl.acModificacion = "No" AND ctrl.acConclusion = "No")
                            THEN "Inicio"

                        -- Condición para "En Proceso": El oficio de respuesta existe
                        WHEN (exp.ofRespuesta IS NOT NULL AND exp.ofRespuesta != "")
                            THEN "En Proceso"

                        -- Un estado por defecto si no se cumple ninguna de las anteriores
                        ELSE "En espera del oficio de respuesta"
                    END AS "Estado"
                FROM
                    expediente AS exp
                INNER JOIN
                    servidor AS srv ON exp.idServidor = srv.idServidor
                INNER JOIN
                    institucion AS inst ON srv.idInstitucion = inst.idInstitucion
                LEFT JOIN
                    control AS ctrl ON exp.numero = ctrl.numero;
            ');

            // GENERACIÓN DEL PDF
            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);

            $html = view('reports.seguimiento-denuncias', [
                    'datosReporte' => $datosReporte,
                    'logoBase64' => $logoBase64 
                ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15) 
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_seguimiento_denuncias.pdf"');
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}
