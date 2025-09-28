<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; 
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;

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
        
        $datos = DB::select('
            SELECT
                institucion.nombreCompleto AS nombre,
                COUNT(expediente.numero) AS total
            FROM expediente
            INNER JOIN servidor ON expediente.idServidor = servidor.idServidor
            INNER JOIN institucion ON servidor.idInstitucion = institucion.idInstitucion
            GROUP BY institucion.nombreCompleto
        ');

        
        $chartConfig = [
            'infile' => [
                'chart' => ['type' => 'column'],
                'title' => ['text' => 'Total de expedientes por institución'],
                'xAxis' => ['categories' => array_column($datos, 'nombre')],
                'series' => [[
                    'name' => 'Expedientes',
                    'data' => array_map('intval', array_column($datos, 'total'))
                ]]
            ]
        ];

        $response = Http::withHeaders([
            'User-Agent' => 'MiAplicacionLaravel/1.0',
            'Referer' => config('app.url'),
        ])->post('https://export.highcharts.com/', $chartConfig);

        $chartBase64 = 'data:image/png;base64,' . base64_encode($response->body());

        $html = view('reports.denuncias-institucion', [
            'denuncias' => $datos,
            'chartUrl' => $chartBase64 
        ])->render();


        $pdf = Browsershot::html($html)->format('A4')->pdf();

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="reporte_denuncias_con_grafico.pdf"');
            
    }
}