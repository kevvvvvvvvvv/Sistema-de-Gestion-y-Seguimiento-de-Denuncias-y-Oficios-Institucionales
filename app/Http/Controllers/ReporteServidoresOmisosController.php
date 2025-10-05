<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReporteServidoresOmisosController extends Controller
{
    public function showServidoresOmisos() 
    {
        $servidoresBaja = DB::select('select servidor.nombreCompleto,
            institucion.nombreCompleto as institucion, departamento.nombre as departamento, 
            expediente.numero,
            baja.fechaBaja, baja.descripcion as descrBaja,
            control.acConclusion
            from servidor inner join institucion on  servidor.idInstitucion = institucion.idInstitucion
            inner join departamento on servidor.idDepartamento = departamento.idDepartamento
            inner join baja on baja.idServidor = servidor.idServidor
            inner join expediente on expediente.idServidor = servidor.idServidor
            inner join control on expediente.numero = control.numero
            where servidor.estatus = "Baja";');

        $servidoresAlta = DB::select('select servidor.nombreCompleto, servidor.fechaIngreso, servidor.descripcion as descrAlta,
            institucion.nombreCompleto as institucion, departamento.nombre as departamento, 
            expediente.numero,
            control.acInicio
            from servidor inner join institucion on  servidor.idInstitucion = institucion.idInstitucion
            inner join departamento on servidor.idDepartamento = departamento.idDepartamento
            inner join baja on baja.idServidor = servidor.idServidor
            inner join expediente on expediente.idServidor = servidor.idServidor
            inner join control on expediente.numero = control.numero
            where servidor.estatus = "Alta"
            group by servidor.nombreCompleto
            having count(baja.idServidor) = 1;');

        //No se tiene acuerdo de conclusión después de la baja
        $servidoresOmisosBaja = [];
        foreach($servidoresBaja as $servidor) {
            if($servidor->acConclusion === 'No') {
                $diasDif = Carbon::parse($servidor->fechaBaja)->diffInDays(now());
                if($diasDif > 60) {
                    $fechaLimite = Carbon::parse($servidor->fechaBaja)->addDays(60);
                    $difDias = floor($fechaLimite->diffInDays(now()));

                    $servidor->fechaLimite = Carbon::parse($servidor->fechaBaja)->addDays(60)->format('d/m/Y');
                    $servidor->difDias = $difDias;

                    $servidoresOmisosBaja[] = $servidor;
                }
            }
        }

        $numOmisosBaja = count($servidoresOmisosBaja);

        //No se tiene acuerdo de inicio después de un reingreso
        $servidoresOmisosAlta = [];
        foreach($servidoresAlta as $servidor) {
            if($servidor->acInicio === 'No') {
                $diasDif = Carbon::parse($servidor->fechaIngreso)->diffInDays(now());
                if($diasDif > 60) {
                    $fechaLimite = Carbon::parse($servidor->fechaIngreso)->addDays(60);
                    $difDias = floor($fechaLimite->diffInDays(now()));

                    $servidor->fechaLimite = Carbon::parse($servidor->fechaIngreso)->addDays(60)->format('d/m/Y');
                    $servidor->difDias = $difDias;

                    $servidoresOmisosAlta[] = $servidor;
                }
            }
        }

        $numOmisosAlta = count($servidoresOmisosAlta);

        return Inertia::render('Reportes/ServidoresOmisos', [
            'servidoresOmisosBaja' => $servidoresOmisosBaja,
            'servidoresOmisosAlta' => $servidoresOmisosAlta,
            'numOmisosBaja' => $numOmisosBaja,
            'numOmisosAlta' => $numOmisosAlta,
        ]);
    }

    public function descargarReporteServOmisoPdf()
    {
        try {
            // DATOS PARA EL REPORTE
            $servidoresBaja = DB::select('select servidor.nombreCompleto,
                institucion.nombreCompleto as institucion, departamento.nombre as departamento, 
                expediente.numero,
                baja.fechaBaja, baja.descripcion as descrBaja,
                control.acConclusion
                from servidor inner join institucion on  servidor.idInstitucion = institucion.idInstitucion
                inner join departamento on servidor.idDepartamento = departamento.idDepartamento
                inner join baja on baja.idServidor = servidor.idServidor
                inner join expediente on expediente.idServidor = servidor.idServidor
                inner join control on expediente.numero = control.numero
                where servidor.estatus = "Baja";');

            $servidoresAlta = DB::select('select servidor.nombreCompleto, servidor.fechaIngreso, servidor.descripcion as descrAlta,
                institucion.nombreCompleto as institucion, departamento.nombre as departamento, 
                expediente.numero,
                control.acInicio
                from servidor inner join institucion on  servidor.idInstitucion = institucion.idInstitucion
                inner join departamento on servidor.idDepartamento = departamento.idDepartamento
                inner join baja on baja.idServidor = servidor.idServidor
                inner join expediente on expediente.idServidor = servidor.idServidor
                inner join control on expediente.numero = control.numero
                where servidor.estatus = "Alta"
                group by servidor.nombreCompleto
                having count(baja.idServidor) = 1;');

            //No se tiene acuerdo de conclusión después de la baja
            $servidoresOmisosBaja = [];
            foreach($servidoresBaja as $servidor) {
                if($servidor->acConclusion === 'No') {
                    $diasDif = Carbon::parse($servidor->fechaBaja)->diffInDays(now());
                    if($diasDif > 60) {
                        $fechaLimite = Carbon::parse($servidor->fechaBaja)->addDays(60);
                        $difDias = floor($fechaLimite->diffInDays(now()));

                        $servidor->fechaLimite = Carbon::parse($servidor->fechaBaja)->addDays(60)->format('d/m/Y');
                        $servidor->difDias = $difDias;

                        $servidoresOmisosBaja[] = (object)$servidor;
                    }
                }
            }

            $numOmisosBaja = count($servidoresOmisosBaja);

            //No se tiene acuerdo de inicio después de un reingreso
            $servidoresOmisosAlta = [];
            foreach($servidoresAlta as $servidor) {
                if($servidor->acInicio === 'No') {
                    $diasDif = Carbon::parse($servidor->fechaIngreso)->diffInDays(now());
                    if($diasDif > 60) {
                        $fechaLimite = Carbon::parse($servidor->fechaIngreso)->addDays(60);
                        $difDias = floor($fechaLimite->diffInDays(now()));

                        $servidor->fechaLimite = Carbon::parse($servidor->fechaIngreso)->addDays(60)->format('d/m/Y');
                        $servidor->difDias = $difDias;

                        $servidoresOmisosAlta[] = (object)$servidor;
                    }
                }
            }

            $numOmisosAlta = count($servidoresOmisosAlta);

            // GENERACIÓN DEL PDF
            $logoPath = public_path('images/imta-logo.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);

            $html = view('reports.servidores-omisos', [
                    'servidoresOmisosBaja' => $servidoresOmisosBaja,
                    'servidoresOmisosAlta' => $servidoresOmisosAlta,
                    'numOmisosBaja' => $numOmisosBaja,
                    'numOmisosAlta' => $numOmisosAlta,
                    'logoBase64' => $logoBase64 
                ])->render();

            $pdf = Browsershot::html($html)
                ->format('A4')
                ->margins(20, 15, 15, 15) 
                ->waitUntilNetworkIdle()
                ->pdf();

            return response($pdf)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="reporte_servidores_omisos.pdf"');

        } catch (\Exception $e) {
            Log::error('Error al generar PDF: ' . $e->getMessage());
            return response('Error al generar el reporte.', 500);
        }
    }
}
