<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; 
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException;

class ReporteDenunciasInstitucionController extends Controller
{

    public function showDenunciasInstitucion(Request $request)
    {

        $filtros = $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
        ]);
        

        $datos = DB::table('expediente')
            ->join('servidor', 'expediente.idServidor', '=', 'servidor.idServidor')
            ->join('institucion', 'servidor.idInstitucion', '=', 'institucion.idInstitucion')
            ->select('institucion.nombreCompleto AS nombre','fechaRequerimiento', DB::raw('COUNT(expediente.numero) AS total'))
            ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
 
                return $query->whereDate('expediente.fechaRequerimiento', '>=', $filtros['fecha_inicio']);
            })
            ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                return $query->whereDate('expediente.fechaRequerimiento', '<=', $filtros['fecha_fin']);
            })
            
            ->groupBy('institucion.nombreCompleto')
            ->orderBy('total', 'desc') 
            ->get();

        return Inertia::render('Reportes/DenunciasInstitucion', [
            'denuncias' => $datos,
            'filtros'   => $filtros 
        ]);
    }


    public function descargarReporteDenunciasPdf(Request $request) // 1. Añadir Request
    {
        try {
            $filtros = $request->validate([
                'fecha_inicio' => 'nullable|date',
                'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            ]);

            $datos = DB::table('expediente')
                ->join('servidor', 'expediente.idServidor', '=', 'servidor.idServidor')
                ->join('institucion', 'servidor.idInstitucion', '=', 'institucion.idInstitucion')
                ->select('institucion.nombreCompleto AS nombre','fechaRequerimiento', DB::raw('COUNT(expediente.numero) AS total'))
                ->when(isset($filtros['fecha_inicio']), function ($query) use ($filtros) {
                    return $query->whereDate('expediente.fechaRequerimiento', '>=', $filtros['fecha_inicio']);
                })
                ->when(isset($filtros['fecha_fin']), function ($query) use ($filtros) {
                    return $query->whereDate('expediente.fechaRequerimiento', '<=', $filtros['fecha_fin']);
                })
                
                ->groupBy('institucion.nombreCompleto')
                ->orderBy('total', 'desc')
                ->get();

            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
            
            $html = view('reports.denuncias-imprimible', [
                'denuncias' => $datos,
                'logoBase64' => $logoBase64,
                'filtros' => $filtros 
            ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15) 
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_denuncias.pdf"');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF de denuncias: ' . $e->getMessage());
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                Log::error('Errores de validación PDF: ' . json_encode($e->errors()));
            }
            return response('Error al generar el reporte.', 500);
        }
    }

}