<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
Use Illuminate\Support\Facades\DB;

class ReporteProgresoOficioController extends Controller
{
    // En tu controlador de Laravel
    public function showProgresoOficio(Request $request)
    {
        // 1. Validar y obtener el dato del filtro de forma segura
        $request->validate([
            'fecha_inicio' => 'nullable|date',
        ]);
        $fechaInicio = $request->input('fecha_inicio');

        // 2. Construir la consulta base como un string
        $query = '
            SELECT
                CASE
                    WHEN UPPER(TRIM(status)) = \'FINALIZADO\' THEN CAST(fechaEntrega AS CHAR)
                    ELSE \'Pendientes\'
                END AS Categoria,
                COUNT(*) AS Total
            FROM
                viajero
        ';

        $bindings = [];

        // 3. Si hay un filtro, añadir la cláusula WHERE y el valor a los bindings
        if ($fechaInicio) {
            // La condición WHERE va ANTES del GROUP BY
            $query .= ' WHERE fechaEntrega = ?';
            $bindings[] = $fechaInicio;
        }

        // 4. Añadir el resto de la consulta
        $query .= '
            GROUP BY
                Categoria
            ORDER BY
                Categoria DESC;
        ';
        
        // 5. Ejecutar la consulta UNA SOLA VEZ con los bindings
        $resultados = DB::select($query, $bindings);
        
        return Inertia::render('Reportes/ProgresoOficio', [
            'resultados' => $resultados,
            'filtro' => $fechaInicio // Cambié 'filtros' a 'filtro' para que coincida con tu componente
        ]);
    }
}
