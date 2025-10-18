<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPUnit\Framework\isNull;

class ReporteDocumentosFaltantes extends Controller
{
    public function showDocumentosFaltantes()
    {
        $datos = DB::select('select servidor.nombreCompleto, 
		institucion.nombreCompleto as nomInstitucion,
		departamento.nombre,
		expediente.numero, expediente.ofRespuesta,
        control.acProrroga as "Acuerdo de Prórroga", 
        control.acAuxilio as "Acuerdo de Auxilio para personal OR",
        control.acRegularizacion as "Acuerdo de Regularización", 
        control.acRequerimiento as "Acuerdo de Requerimiento de Declaración Patrimonial",
        control.acOficioReque as "Oficio de Requerimiento de Declaración Patrimonial",
        control.acInicio as "Acuerdo de Inicio",   
        control.acModificacion as "Acuerdo de Modificacion",   
        control.acConclusion as "Acuerdo de Conclusión y Archivo"
        from institucion inner join departamento on institucion.idInstitucion = departamento.idInstitucion
		inner join servidor on servidor.idDepartamento = departamento.idDepartamento
        inner join expediente on servidor.idServidor = expediente.idServidor
        inner join control on control.numero = expediente.numero;');

        $datosReporte = [];

        foreach ($datos as $dato) {
            $nombreCompleto = $dato->nombreCompleto;
            $nomInstitucion = $dato->nomInstitucion;
            $departamento = $dato->nombre;

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
                    'nomInstitucion' => $nomInstitucion,
                    'departamento' => $departamento,
                    'ofFaltantes' => $ofFaltantes,
                    'totalFaltantes' => $totalFaltantes
                ];
            }
        }

        return Inertia::render('Reportes/DocumentosFaltantes', ['datosReporte' => $datosReporte]);
    }

    public function descargarReporteDocFaltPdf(Request $request) {

        try {
            $oficiosMap = [
                'Acuerdo de Prórroga' => ['control', 'acProrroga', 'No'],
                'Acuerdo de Auxilio para personal OR' => ['control', 'acAuxilio', 'No'],
                'Acuerdo de Regularización' => ['control', 'acRegularizacion', 'No'],
                'Acuerdo de Requerimiento de Declaración Patrimonial' => ['control', 'acRequerimiento', 'No'],
                'Oficio de Requerimiento de Declaración Patrimonial' => ['control', 'acOficioReque', 'No'],
                'Acuerdo de Inicio' => ['control', 'acInicio', 'No'],
                'Acuerdo de Modificacion' => ['control', 'acModificacion', 'No'],
                'Acuerdo de Conclusión y Archivo' => ['control', 'acConclusion', 'No'],
                'Oficio de Respuesta' => ['expediente', 'ofRespuesta', null],
            ];

            $query = DB::table('institucion')
                ->join('departamento', 'institucion.idInstitucion', '=', 'departamento.idInstitucion')
                ->join('servidor', 'servidor.idDepartamento', '=', 'departamento.idDepartamento')
                ->join('expediente', 'servidor.idServidor', '=', 'expediente.idServidor')
                ->join('control', 'control.numero', '=', 'expediente.numero')
                ->select(
                    'servidor.nombreCompleto', 
                    'institucion.nombreCompleto as nomInstitucion',
                    'departamento.nombre as departamento',
                    'expediente.numero', 'expediente.ofRespuesta',
                    'control.acProrroga as "Acuerdo de Prórroga"', 
                    'control.acAuxilio as "Acuerdo de Auxilio para personal OR"',
                    'control.acRegularizacion as "Acuerdo de Regularización"', 
                    'control.acRequerimiento as "Acuerdo de Requerimiento de Declaración Patrimonial"',
                    'control.acOficioReque as "Oficio de Requerimiento de Declaración Patrimonial"',
                    'control.acInicio as "Acuerdo de Inicio"', 
                    'control.acModificacion as "Acuerdo de Modificacion"', 
                    'control.acConclusion as "Acuerdo de Conclusión y Archivo"'
                );

            $query->when($request->institucion, function ($q, $institucion) {
                return $q->where('institucion.nombreCompleto', $institucion);
            });

            $query->when($request->oficio, function ($q, $oficio) use ($oficiosMap) {
                if (isset($oficiosMap[$oficio])) {
                    $config = $oficiosMap[$oficio];
                    list($table, $column, $value) = $config;

                    return is_null($value)
                        ? $q->whereNull("{$table}.{$column}")
                        : $q->where("{$table}.{$column}", $value);
                }
            });

            $datos = $query->get();

            $datosReporte = [];
            foreach ($datos as $dato) {
                $nombreCompleto = $dato->nombreCompleto;
                $nomInstitucion = $dato->nomInstitucion;
                $departamento = $dato->departamento;

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
                    $datosReporte[] = (object)[
                        'nombreCompleto' => $nombreCompleto,
                        'numero' => $numero,
                        'nomInstitucion' => $nomInstitucion,
                        'departamento' => $departamento,
                        'ofFaltantes' => $ofFaltantes,
                        'totalFaltantes' => $totalFaltantes
                    ];
                }
            }
            $conteo = count($datosReporte);

            $filtrosAplicados = [
                'institucion' => $request->institucion,
                'oficio' => $request->oficio,
            ];

            // GENERACIÓN DEL PDF
            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);

            $html = view('reports.documentos-faltantes', [
                    'datosReporte' => $datosReporte,
                    'conteo' => $conteo,
                    'filtros' => $filtrosAplicados,
                    'logoBase64' => $logoBase64 
                ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15) 
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_documentos_faltantes.pdf"');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}
