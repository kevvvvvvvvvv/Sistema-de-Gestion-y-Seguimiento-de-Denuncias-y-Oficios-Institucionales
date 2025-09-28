<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReporteProgresoOficio extends Controller
{
    public function showProgresoOficio(Request $request)
    {
        
        
        return Inertia::render('Reportes/ProgresoOficio');
    }
}
