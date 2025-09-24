<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Expediente;

class ReporteDenunciasInstitucionController extends Controller
{

    public function showDenunciasInstitucion(){
       
        
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


    public function showDenunciasInstitucionResult(Request $request)
    {
        // Valida que las fechas sean en el formato correcto (opcional pero recomendado)
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $query = Expediente::query();

        // 1. Aplicar el filtro de rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            
            // Usamos whereBetween para buscar en el rango. Es inclusivo.
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        $denuncias = $query->get();

        return Inertia::render('Reportes/DenunciasInstitucion', [
            'denuncias' => $denuncias,
            // 2. Devolvemos los filtros para que los inputs no se borren
            'filtros' => $request->only(['fecha_inicio', 'fecha_fin']),
        ]);
    }
}
