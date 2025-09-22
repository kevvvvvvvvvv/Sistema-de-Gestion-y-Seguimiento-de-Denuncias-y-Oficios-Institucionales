<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteExpedienteCompleto extends Controller
{
    public function showExpedientes(){
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

        $ofCompletos = [];

        foreach ($datos as $dato) {
            $nombreCompleto = $dato->nombreCompleto;
            $nomInstitucion = $dato->nomInstitucion;
            $departamento = $dato->nombre;

            if (is_null($dato->numero)) {
                $numero = 'Sin número de expediente asignado';
            }else{
                $numero = $dato->numero;
            }

            $bandera = 0;

            foreach ($dato as $campo => $valor) {
                //Ignorar campos que no son documentos
                if (in_array($campo, ['ofRespuesta', 'nombreCompleto', 'numero'])) {
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
                    'nombreCompleto' => $nombreCompleto,
                    'numero' => $numero,
                    'nomInstitucion' => $nomInstitucion,
                    'departamento' => $departamento
                ];
            }

            //Oficios completos
            $conteo = count($ofCompletos);

            //Oficios incompletos
            $exIncompletos = count($datos) - $conteo;
            
        }

        return Inertia::render('Reportes/ExpedientesCompletos', ['ofCompletos' => $ofCompletos, 'conteo' => $conteo, 'exIncompletos' => $exIncompletos]);
    }
}
