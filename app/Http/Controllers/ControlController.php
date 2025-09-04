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
        $controles = Control::with('expediente')->get();
        return Inertia::render('Controles/Index', ['controles' => $controles]);
    }

    public function create()
    {
        $expedientes = Expediente::select('numero')->get();
        return Inertia::render('Controles/Create', ['expedientes' => $expedientes]);
    }

    public function store(ControlRequest $request)
    {
        Control::create($request->validated());
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
        $control->update($data);

        return redirect()->route('controles.index');
    }

    public function destroy($id)
    {
        Control::findOrFail($id)->delete();
        return redirect()->route('controles.index');
    }
}
