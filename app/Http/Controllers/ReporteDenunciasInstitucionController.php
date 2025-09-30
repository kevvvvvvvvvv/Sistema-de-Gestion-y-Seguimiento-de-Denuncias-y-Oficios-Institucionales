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

    /*
    public function descargarReporteDenunciasPdf()
    {
        try {
            // 1. Obtener datos (sin cambios)
            $datos = DB::select('
                SELECT
                    institucion.nombreCompleto AS nombre,
                    COUNT(expediente.numero) AS total
                FROM expediente
                INNER JOIN servidor ON expediente.idServidor = servidor.idServidor
                INNER JOIN institucion ON servidor.idInstitucion = institucion.idInstitucion
                GROUP BY institucion.nombreCompleto
            ');

            // 2. Preparar configuración para CHART.JS (formato diferente a Highcharts)
            $chartConfig = [
                'type' => 'bar', // 'bar' suele verse mejor en reportes
                'data' => [
                    'labels' => array_column($datos, 'nombre'),
                    'datasets' => [[
                        'label' => 'Total de Expedientes',
                        'data' => array_map('intval', array_column($datos, 'total')),
                        'backgroundColor' => 'rgba(54, 162, 235, 0.6)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'borderWidth' => 1
                    ]]
                ],
                'options' => [
                    'plugins' => ['title' => ['display' => true, 'text' => 'Total de expedientes por institución']],
                    'scales' => ['y' => ['beginAtZero' => true]]
                ]
            ];

            // 3. Generar la imagen del gráfico localmente con Node.js
            $imagePath = storage_path('app/public/chart.png');
            $process = new Process(
                ['node', base_path('scripts/generate-chart.cjs')],
                base_path() // <-- AÑADE ESTO
            );
                
            // Pasamos la configuración del gráfico al script a través de stdin
            $process->setInput(json_encode($chartConfig));
            
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            // 4. Preparar imagen y vista HTML (leemos la imagen recién creada)
            $imageData = file_get_contents($imagePath);
            $chartBase64 = 'data:image/png;base64,' . base64_encode($imageData);
            
            $html = view('reports.denuncias-institucion', [
                'denuncias' => $datos,
                'chartUrl' => $chartBase64 
            ])->render();

            // 5. Generar el PDF con Browsershot (sin cambios)
            $pdf = Browsershot::html($html)->format('A4')->pdf();

            // 6. Devolver la respuesta (sin cambios)
            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_denuncias_con_grafico.pdf"');

        } catch (ProcessFailedException $exception) {
            // Captura específica para el fallo del script de Node
            Log::error('Falló el script de generación de gráfico: ' . $exception->getMessage());
            Log::error('Error output: ' . $exception->getProcess()->getErrorOutput());
            return response('Error interno al generar el gráfico del reporte.', 500);
            
        } catch (\Exception $e) {
            // Captura para cualquier otro error
            Log::error('Error al generar PDF de denuncias: ' . $e->getMessage());
            return response('Error al generar el reporte. Por favor, intente más tarde.', 500);
        }
    }*/



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