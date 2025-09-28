<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReporteSeguimientoDenunciasController extends Controller
{
    public function showSeguimietoDenuncias(){
        $datosReporte = DB::select('
        SELECT
            exp.numero,
            srv.nombreCompleto AS nombreCompletoSer,
            inst.nombreCompleto AS nombreCompletoIns,
            exp.fechaRequerimiento,
            CASE
                -- Condición para "Fin": Todos los campos de control son "Si"
                WHEN (ctrl.acProrroga = "Si" AND ctrl.acAuxilio = "Si" AND ctrl.acRegularizacion = "Si" AND ctrl.acRequerimiento = "Si" AND ctrl.acOficioReque = "Si" AND ctrl.acInicio = "Si" AND ctrl.acModificacion = "Si" AND ctrl.acConclusion = "Si")
                    THEN "Finalizado"
                
                -- Condición para "Inicio": Todos los campos de control son "No"
                WHEN (ctrl.acProrroga = "No" AND ctrl.acAuxilio = "No" AND ctrl.acRegularizacion = "No" AND ctrl.acRequerimiento = "No" AND ctrl.acOficioReque = "No" AND ctrl.acInicio = "No" AND ctrl.acModificacion = "No" AND ctrl.acConclusion = "No")
                    THEN "Inicio"

                -- Condición para "En Proceso": El oficio de respuesta existe
                WHEN (exp.ofRespuesta IS NOT NULL AND exp.ofRespuesta != "")
                    THEN "En Proceso"

                -- Un estado por defecto si no se cumple ninguna de las anteriores
                ELSE "Indefinido"
            END AS "Estado"
        FROM
            expediente AS exp
        INNER JOIN
            servidor AS srv ON exp.idServidor = srv.idServidor
        INNER JOIN
            institucion AS inst ON srv.idInstitucion = inst.idInstitucion
        LEFT JOIN
            control AS ctrl ON exp.numero = ctrl.numero;
        ');

        return Inertia::render('Reportes/SeguimientoDenuncias', ['datosReporte' => $datosReporte]);

    }
}
