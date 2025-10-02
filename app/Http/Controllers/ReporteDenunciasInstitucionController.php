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

    public function showDenunciasInstitucion()
    {
        $datos = DB::select('
            SELECT
                institucion.nombreCompleto AS nombre,
                COUNT(expediente.numero) AS total
            FROM expediente
            INNER JOIN servidor ON expediente.idServidor = servidor.idServidor
            INNER JOIN institucion ON servidor.idInstitucion = institucion.idInstitucion
            GROUP BY institucion.nombreCompleto
        ');
        
        return Inertia::render('Reportes/DenunciasInstitucion', ['denuncias' => $datos]);
    }


    public function descargarReporteDenunciasPdf()
    {
        try {
            $datos = DB::select('
                SELECT
                    institucion.nombreCompleto AS nombre,
                    COUNT(expediente.numero) AS total
                FROM expediente
                INNER JOIN servidor ON expediente.idServidor = servidor.idServidor
                INNER JOIN institucion ON servidor.idInstitucion = institucion.idInstitucion
                GROUP BY institucion.nombreCompleto
            ');

            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);
            

            $html = view('reports.denuncias-imprimible', [
                'denuncias' => $datos,
                'logoBase64' => $logoBase64 
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
            return response('Error al generar el reporte.', 500);
        }
    }
    

}