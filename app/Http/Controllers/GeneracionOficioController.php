<?php

namespace App\Http\Controllers;

use App\Models\Plantilla;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GeneracionOficioController extends Controller
{
    public function verPlantillas() 
    {
        $plantillas  = Plantilla::all();
        return Inertia::render('Modulos/GeneracionOficio/Index', ['plantillas' =>  $plantillas]);
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

    public function editarPlantilla($id)
    {
        $plantilla = Plantilla::findOrFail($id);
        return Inertia::render('Modulos/GeneracionOficio/EditorActualizar', ['plantilla' => $plantilla]);
    }

    public function actualizarPlantilla(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:45',
            'contenido' => 'required|string',
        ]);

        $plantilla = Plantilla::findOrFail($id);
        $plantilla->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('modulo.oficios.index');
    }
}
