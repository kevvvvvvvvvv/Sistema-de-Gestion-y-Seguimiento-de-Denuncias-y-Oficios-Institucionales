<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
Use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Carbon\Carbon;

class ReporteProgresoOficioController extends Controller
{

    public function showProgresoOficio(Request $request)
    {

         $fechaRecibida = $request->input('fecha_inicio');

        $fechaParaConsulta = null; 

        if ($fechaRecibida) {
            $fechaParaConsulta = Carbon::parse($fechaRecibida)->format('Y-m-d');
        }

        $query = '
            SELECT
                CASE
                    WHEN UPPER(TRIM(status)) = \'FINALIZADO\' THEN CAST(fechaEntrega AS CHAR)
                    ELSE \'Pendientes\'
                END AS Categoria,
                COUNT(*) AS Total
            FROM
                viajero
        ';

        $bindings = [];

        if ($fechaParaConsulta) {
            $query .= ' WHERE DATE(fechaEntrega) = ?';
            $bindings[] = $fechaParaConsulta;
        }

        $query .= '
            GROUP BY
                Categoria
            ORDER BY
                Categoria DESC;
        ';
        
        $resultados = DB::select($query, $bindings);
        
        return Inertia::render('Reportes/ProgresoOficio', [
            'resultados' => $resultados,
            'filtro' => $fechaRecibida
        ]);
    }

    public function descargarProgresoOficioPdf(Request $request)
    {
        try {
  
            $fechaRecibida = $request->input('fecha_inicio');
            $fechaParaConsulta = null;

            if ($fechaRecibida) {
                $fechaParaConsulta = Carbon::parse($fechaRecibida)->format('Y-m-d');
            }

            $query = '
                SELECT
                    CASE
                        WHEN UPPER(TRIM(status)) = \'FINALIZADO\' THEN CAST(fechaEntrega AS CHAR)
                        ELSE \'Pendientes\'
                    END AS Categoria,
                    COUNT(*) AS Total
                FROM
                    viajero
            ';

            $bindings = [];

            if ($fechaParaConsulta) {
                $query .= ' WHERE DATE(fechaEntrega) = ?';
                $bindings[] = $fechaParaConsulta;
            }

            $query .= '
                GROUP BY
                    Categoria
                ORDER BY
                    Categoria DESC;
            ';
            
            $resultados = DB::select($query, $bindings);

            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
            

            $html = view('reports.progreso-oficio', [
                'resultados' => $resultados,
                'logoBase64' => $logoBase64,
                'filtro' => $fechaRecibida, 
            ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15)
                ->waitUntilNetworkIdle() 
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_progreso_oficios.pdf"');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF de progreso de oficios: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}
