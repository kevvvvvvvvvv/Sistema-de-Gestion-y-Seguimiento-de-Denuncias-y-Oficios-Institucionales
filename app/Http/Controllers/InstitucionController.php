<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstitucionRequest;
use App\Models\Institucion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitucionController extends Controller
{
    public function index()
    {
        $instituciones = Institucion::withTrashed()->get();
        return Inertia::render('Instituciones/Index', ['instituciones' => $instituciones]);
    }

    public function create()
    {
        return Inertia::render('Instituciones/Create');
    }

    public function store(InstitucionRequest $request)
    {
        $data = $request->validated();

        Institucion::create([
            'nombreCompleto' => $request->nombreCompleto,
            'siglas' => $request->siglas
        ]);

        return redirect()->route('instituciones.index');
    }

    public function edit($id)
    {
        $institucion = Institucion::findOrFail($id);
        return Inertia::render('Instituciones/Edit', ['institucion' => $institucion]);
    }

    public function update(InstitucionRequest  $request, $id)
    {
        $institucion = Institucion::findOrFail($id);

        $data = $request->validated();
        
        $institucion->update($data);

        return redirect()->route('instituciones.index');
    }

    public function destroy($id)
    {
        Institucion::findOrFail($id)->delete();
        return redirect()->route('instituciones.index');
    }

    public function restore($id)
    {
        $institucion = Institucion::withTrashed()->find($id);
        $institucion->restore();
        return redirect()->route('instituciones.index');
    }

    public function forceDelete($id)
    {
        $institucion = Institucion::withTrashed()->find($id);
        $institucion->forceDelete();
        return redirect()->route('instituciones.index');
    }
}
