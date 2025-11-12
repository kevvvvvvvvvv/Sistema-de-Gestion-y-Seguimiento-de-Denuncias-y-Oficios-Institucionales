<?php

namespace App\Http\Controllers;

use App\Http\Requests\ControlRequest;
use App\Models\Control;
use App\Models\Expediente;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ControlController extends Controller
{
    public function index()
    {
        $controles = Control::with('expediente.servidor')->withTrashed()->get();
        return Inertia::render('Controles/Index', ['controles' => $controles]);
    }

    public function create()
    {
        $expedientes = Expediente::select('numero')->get();
        return Inertia::render('Controles/Create', ['expedientes' => $expedientes]);
    }

    public function store(ControlRequest $request)
    {
        $data = $request->all();

        if(isset($data['feEntregaInicio'])){
            $data['feEntregaInicio'] = \Carbon\Carbon::parse($data['feEntregaInicio'])->format('Y-m-d');
        }
        if(isset($data['feEntregaModif'])){
            $data['feEntregaModif'] = \Carbon\Carbon::parse($data['feEntregaModif'])->format('Y-m-d');
        }
        if(isset($data['feEntregaCon'])){
            $data['feEntregaCon'] = \Carbon\Carbon::parse($data['feEntregaCon'])->format('Y-m-d');
        }

        Control::create($data);
        return redirect()->route('controles.index');
    }

    public function edit($id)
    {
        $expedientes = Expediente::select('numero')->get();
        $control = Control::findOrFail($id);
        return Inertia::render('Controles/Edit', 
        ['control' => $control, 'expedientes' => $expedientes]);
    }

    public function update(ControlRequest  $request, $id)
    {
        $control = Control::findOrFail($id);

        $data = $request->validated();

        if(isset($data['feEntregaInicio'])){
            $data['feEntregaInicio'] = \Carbon\Carbon::parse($data['feEntregaInicio'])->format('Y-m-d');
        }
        if(isset($data['feEntregaModif'])){
            $data['feEntregaModif'] = \Carbon\Carbon::parse($data['feEntregaModif'])->format('Y-m-d');
        }
        if(isset($data['feEntregaCon'])){
            $data['feEntregaCon'] = \Carbon\Carbon::parse($data['feEntregaCon'])->format('Y-m-d');
        }
        
        $control->update($data);

        return redirect()->route('controles.index');
    }

    public function destroy($id)
    {
        Control::findOrFail($id)->delete();
        return redirect()->route('controles.index');
    }

    public function restore($id)
    {
        $control = Control::withTrashed()->find($id);
        $control->restore();
        return redirect()->route('controles.index');
    }

    public function forceDelete($id)
    {
        $control = Control::withTrashed()->find($id);
        $control->forceDelete();

        return redirect()->route('controles.index')
        ->with('success', 'El registro ha sido eliminado permanentemente');
    }
}
