<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteExpedienteCompleto extends Controller
{
    public function showExpedientes(){
        $datos = DB::select('select servidor.nombreCompleto, 
		institucion.nombreCompleto as nomInstitucion,
		departamento.nombre,
		expediente.numero, expediente.ofRequerimiento, expediente.ofRespuesta,
        expediente.fechaRequerimiento, expediente.fechaRespuesta, expediente.fechaRecepcion,
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

        $ofCompletos = [];
        $incompletosPorInstitucion = [];

        foreach ($datos as $dato) {

            $nomInstitucion = $dato->nomInstitucion;

            if (!isset($incompletosPorInstitucion[$nomInstitucion])) {
                $incompletosPorInstitucion[$nomInstitucion] = 0;
            }

            if (is_null($dato->numero)) {
                $numero = 'Sin número de expediente asignado';
            }else{
                $numero = $dato->numero;
            }

            $bandera = 0;

            foreach ($dato as $campo => $valor) {
                //Ignorar campos que no son documentos
                if (in_array($campo, ['ofRespuesta', 'nombreCompleto', 'numero', 
                'nomInstitucion', 'ofRequerimiento', 'fechaRequerimiento', 
                'fechaRespuesta', 'fechaRecepcion'])) {
                    continue;
                }

                if ($valor === 'No') {
                    $bandera = 1;
                    break;
                }
            }

            //Verficiar el oficio de respuesta
            if (is_null($dato->ofRespuesta)){
                $bandera = 1;
            }

            //Guardar los datos en el arreglo para el reporte, solo si están completos
            if($bandera == 0) {
                $ofCompletos[] = [
                    'nombreCompleto' => $dato->nombreCompleto,
                    'numero' => $numero,
                    'nomInstitucion' => $dato->nomInstitucion,
                    'departamento' => $dato->nombre,
                    'ofRequerimiento' => $dato->ofRequerimiento,
                    'fechaRequerimiento' => $dato->fechaRequerimiento,
                    'ofRespuesta' => $dato->ofRespuesta,
                    'fechaRespuesta' => $dato->fechaRespuesta,
                    'fechaRecepcion' => $dato->fechaRecepcion
                ];
            }else{
                $incompletosPorInstitucion[$nomInstitucion]++;
            }
        }

        //Oficios completos
        $conteo = count($ofCompletos);

        //Oficios incompletos
        $exIncompletos = array_sum($incompletosPorInstitucion);

        return Inertia::render('Reportes/ExpedientesCompletos', [
            'ofCompletos' => $ofCompletos, 
            'conteo' => $conteo, 
            'exIncompletos' => $exIncompletos,
            'incompletosPorInstitucion' => $incompletosPorInstitucion
        ]);
    }

    public function descargarReporteExpeComPdf(Request $request) {
        try {
            // DATOS PARA EL REPORTE
            $query = DB::table('institucion')
            ->join('departamento', 'institucion.idInstitucion', '=', 'departamento.idInstitucion')
            ->join('servidor', 'servidor.idDepartamento', '=', 'departamento.idDepartamento')
            ->join('expediente', 'servidor.idServidor', '=', 'expediente.idServidor')
            ->join('control', 'control.numero', '=', 'expediente.numero')
            ->select(
                'servidor.nombreCompleto', 
                'institucion.nombreCompleto as nomInstitucion',
                'departamento.nombre',
                'expediente.numero', 'expediente.ofRequerimiento', 'expediente.ofRespuesta',
                'expediente.fechaRequerimiento', 'expediente.fechaRespuesta', 'expediente.fechaRecepcion',
                'control.acProrroga as "Acuerdo de Prórroga"', 
                'control.acAuxilio as "Acuerdo de Auxilio para personal OR"',
                'control.acRegularizacion as "Acuerdo de Regularización"', 
                'control.acRequerimiento as "Acuerdo de Requerimiento de Declaración Patrimonial"',
                'control.acOficioReque as "Oficio de Requerimiento de Declaración Patrimonial"',
                'control.acInicio as "Acuerdo de Inicio"', 
                'control.acModificacion as "Acuerdo de Modificacion"', 
                'control.acConclusion as "Acuerdo de Conclusión y Archivo"'
            )->groupBy('expediente.numero');

            $query->when($request->institucion, function ($q, $institucion) {
                return $q->where('institucion.nombreCompleto', $institucion);
            });

            $datos = $query->get();

            $ofCompletos = [];
            $totalIncompletos = 0;

            foreach ($datos as $dato) {

                if (is_null($dato->numero)) {
                    $numero = 'Sin número de expediente asignado';
                }else{
                    $numero = $dato->numero;
                }

                $bandera = 0;

                foreach ($dato as $campo => $valor) {
                    //Ignorar campos que no son documentos
                    if (in_array($campo, ['ofRespuesta', 'nombreCompleto', 'numero', 
                    'nomInstitucion', 'ofRequerimiento', 'fechaRequerimiento', 
                    'fechaRespuesta', 'fechaRecepcion'])) {
                        continue;
                    }

                    if ($valor === 'No') {
                        $bandera = 1;
                        break;
                    }
                }

                //Verficiar el oficio de respuesta
                if (is_null($dato->ofRespuesta)){
                    $bandera = 1;
                }

                //Guardar los datos en el arreglo para el reporte, solo si están completos
                if($bandera == 0) {
                    $ofCompletos[] = (object)[
                        'nombreCompleto' => $dato->nombreCompleto,
                        'numero' => $numero,
                        'nomInstitucion' => $dato->nomInstitucion,
                        'departamento' => $dato->nombre,
                        'ofRequerimiento' => $dato->ofRequerimiento,
                        'fechaRequerimiento' => $dato->fechaRequerimiento,
                        'ofRespuesta' => $dato->ofRespuesta,
                        'fechaRespuesta' => $dato->fechaRespuesta,
                        'fechaRecepcion' => $dato->fechaRecepcion
                    ];
                }
            }

            $conteoCompletos = count($ofCompletos);
            $conteoIncompletos = count($datos) - $conteoCompletos;

            // GENERACIÓN DEL PDF
            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);

            $html = view('reports.expedientes-completos', [
                    'ofCompletos' => $ofCompletos,
                    'conteo' => $conteoCompletos,
                    'exIncompletos' => $conteoIncompletos,
                    'filtro' => $request->institucion,
                    'logoBase64' => $logoBase64 
                ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15) 
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_expedientes_completos.pdf"');
        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}
