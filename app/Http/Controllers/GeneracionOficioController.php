<?php

namespace App\Http\Controllers;

use App\Models\Plantilla;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneracionOficioController extends Controller
{
    public function verPlantillas() 
    {
        return Inertia::render('Modulos/GeneracionOficio/Index');
    }

    public function showEditor()
    {
        return Inertia::render('Modulos/GeneracionOficio/Editor');
    }

    public function guardarPlantilla(Request $request){
        $request->validate([
            'titulo' => 'required|string|max:45',
            'contenido' => 'required|string',
        ]);

        Plantilla::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('modulo.oficios.index');
    }
}
