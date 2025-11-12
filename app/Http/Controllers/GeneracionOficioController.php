<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Plantilla;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class GeneracionOficioController extends Controller
{
    public function verPlantillas() 
    {
        $plantillas  = Plantilla::withTrashed()->get();
        $servidores = Servidor::with(['institucion', 'departamento'])->get();
        $expedientes = Expediente::all();
        return Inertia::render('Modulos/GeneracionOficio/Index', [
            'plantillas' =>  $plantillas,
            'servidores' => $servidores,
            'expedientes' => $expedientes
        ]);
    }

    public function showEditor()
    {
        return Inertia::render('Modulos/GeneracionOficio/Editor');
    }

    public function guardarPlantilla(Request $request){
        $request->validate([
            'titulo' => 'required|string|max:300',
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
            'titulo' => 'required|string|max:300',
            'contenido' => 'required|string',
        ]);

        $plantilla = Plantilla::findOrFail($id);
        $plantilla->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        return redirect()->route('modulo.oficios.index');
    }

    public function destroy($id)
    {
        Plantilla::findOrFail($id)->delete();
        return redirect()->route('modulo.oficios.index');
    }

    public function restore($id)
    {
        $plantilla = Plantilla::withTrashed()->find($id);
        $plantilla->restore();
        return redirect()->route('modulo.oficios.index');
    }

    public function forceDelete($id)
    {
        $plantilla = Plantilla::withTrashed()->find($id);
        $plantilla->forceDelete();
        return redirect()->route('modulo.oficios.index')
        ->with('success', 'El registro ha sido eliminado permanentemente');
    }
}
