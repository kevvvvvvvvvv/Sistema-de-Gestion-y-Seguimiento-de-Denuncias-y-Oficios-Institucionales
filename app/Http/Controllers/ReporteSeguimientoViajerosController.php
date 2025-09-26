<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ReporteSeguimientoViajerosController extends Controller
{

    /*
        Recibe:
        fecha_inicio
        fecha_fin
    */
    public function showSeguimientoViajeros(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $queryDatos = "
            SELECT
                viajero.status,
                count(viajero.status) as total
            FROM
                oficio
            INNER JOIN
                viajero
            ON 
                viajero.numOficio = oficio.numOficio
        ";

        $queryDatosTabla = "
            SELECT
                oficio.numOficio, 
                oficio.fechaLlegada,
                viajero.status,
                viajero.asunto,
                viajero.instruccion,
                viajero.resultado
            FROM
                oficio
            INNER JOIN
                viajero
            ON 
                viajero.numOficio = oficio.numOficio
        ";

        $bindings = [];

        if ($fechaInicio && $fechaFin) {
            $queryDatos .= " WHERE oficio.fechaLlegada BETWEEN ? AND ? ";
            $queryDatosTabla .= " WHERE oficio.fechaLlegada BETWEEN ? AND ? ";
            $bindings = [$fechaInicio, $fechaFin];
        }


        $queryDatos .= " GROUP BY viajero.status";

        $datos = DB::select($queryDatos, $bindings);
        $datosTabla = DB::select($queryDatosTabla, $bindings);

        return Inertia::render('Reportes/SeguimientoViajeros', [
            'datos' => $datos,
            'datosTabla' => $datosTabla,
            'filtros' => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
            ]
        ]);
    }

}
