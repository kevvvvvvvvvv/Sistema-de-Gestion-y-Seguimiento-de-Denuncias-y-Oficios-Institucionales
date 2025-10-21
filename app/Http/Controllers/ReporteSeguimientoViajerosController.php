<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReporteSeguimientoViajeroRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;

class ReporteSeguimientoViajerosController extends Controller
{

    /*
        Recibe:
        fecha_inicio
        fecha_fin
    */
    public function showSeguimientoViajeros(ReporteSeguimientoViajeroRequest $request)
    {
    
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $queryDatos = "
            SELECT
                viajero.status,
                count(viajero.status) as total
            FROM
                oficio
            INNER JOIN
                viajero
            ON 
                viajero.numOficio = oficio.numOficio
        ";

        $queryDatosTabla = "
            SELECT
                oficio.numOficio, 
                oficio.fechaLlegada,
                viajero.status,
                viajero.asunto,
                viajero.instruccion,
                viajero.resultado
            FROM
                oficio
            INNER JOIN
                viajero
            ON 
                viajero.numOficio = oficio.numOficio
        ";

        $bindings = [];

        if ($fechaInicio && $fechaFin) {
            $queryDatos .= " WHERE oficio.fechaLlegada BETWEEN ? AND ? ";
            $queryDatosTabla .= " WHERE oficio.fechaLlegada BETWEEN ? AND ? ";
            $bindings = [$fechaInicio, $fechaFin];
        }


        $queryDatos .= " GROUP BY viajero.status";

        $datos = DB::select($queryDatos, $bindings);
        $datosTabla = DB::select($queryDatosTabla, $bindings);

        return Inertia::render('Reportes/SeguimientoViajeros', [
            'datos' => $datos,
            'datosTabla' => $datosTabla,
            'filtros' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ]
        ]);
    }

    public function descargarReporteSeguimientoViajeroPdf(ReporteSeguimientoViajeroRequest $request)
    {
        try {
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');

            $queryDatos = "
                SELECT
                    viajero.status,
                    count(viajero.status) as total
                FROM
                    oficio
                INNER JOIN
                    viajero
                ON 
                    viajero.numOficio = oficio.numOficio
            ";

            $queryDatosTabla = "
                SELECT
                    oficio.numOficio, 
                    oficio.fechaLlegada,
                    viajero.status,
                    viajero.asunto,
                    viajero.instruccion,
                    viajero.resultado
                FROM
                    oficio
                INNER JOIN
                    viajero
                ON 
                    viajero.numOficio = oficio.numOficio
            ";

            $bindings = [];

            if ($fechaInicio && $fechaFin) {
                $queryDatos .= " WHERE oficio.fechaLlegada BETWEEN ? AND ? ";
                $queryDatosTabla .= " WHERE oficio.fechaLlegada BETWEEN ? AND ? ";
                $bindings = [$fechaInicio, $fechaFin];
            }

            $queryDatos .= " GROUP BY viajero.status";

            $datos = DB::select($queryDatos, $bindings);
            $datosTabla = DB::select($queryDatosTabla, $bindings);

            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
            
            $html = view('reports.seguimiento-viajeros', [
                'datos' => $datos,
                'datosTabla' => $datosTabla,
                'logoBase64' => $logoBase64,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
            ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15) 
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_seguimiento_viajeros.pdf"');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF de seguimiento de viajeros: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }

}
