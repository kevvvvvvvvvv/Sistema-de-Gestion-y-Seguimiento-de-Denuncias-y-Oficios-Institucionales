<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticularRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Particular;
use Illuminate\Support\Facades\DB;

class ParticularController extends Controller
{
    public function index()
    {
        $particulares = Particular::withTrashed()->get();
        return Inertia::render('Particulares/Index',['particulares' => $particulares]);
    }

    public function create()
    {
        return Inertia::render('Particulares/Create');
    }

    public function store(ParticularRequest $request)
    {
        Particular::create($request->all());

        return redirect()->route('particulares.index');
    }

    public function edit($id)
    {
        $particulares = Particular::findOrFail($id);
        return Inertia::render('Particulares/Edit', ['particulares' => $particulares]);
    }

    public function update(ParticularRequest $request, $id)
    {
        $particular = Particular::findOrFail($id);

        $particular->update($request->all());

        return redirect()->route('particulares.index');
    }

    public function destroy($id)
    {
        Particular::findOrFail($id)->delete();
        return redirect()->route('particulares.index');
    }

    public function restore($id)
    {
        $particular = Particular::withTrashed()->find($id);
        $particular->restore();
        return redirect()->route('particulares.index');
    }

    public function forceDelete($id)
    {
        $consultaVal = DB::select('select 1 as existe from oficio 
            where idParticularRemitente = ?
            UNION
            select 1 as existe from oficio 
            where idParticularDestinatario = ?
            limit 1;', [$id, $id]);
        
        if (count($consultaVal) > 0) {
            return redirect()->route('particulares.index')
            ->with('error', 'No se puede eliminar el registro porque tiene registros asociados');
        }

        $particular = Particular::withTrashed()->find($id);
        $particular->forceDelete();
        return redirect()->route('particulares.index')
        ->with('success', 'El registro ha sido eliminado permanentemente');
    }
}
