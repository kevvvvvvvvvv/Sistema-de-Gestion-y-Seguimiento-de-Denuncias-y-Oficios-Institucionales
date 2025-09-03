<?php

namespace App\Http\Controllers;

use App\Http\Requests\ControlRequest;
use App\Models\Control;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ControlController extends Controller
{
    public function index()
    {
        $controles = Control::all();
        return Inertia::render('Controles/Index', ['controles' => $controles]);
    }

    public function create()
    {
        return Inertia::render('Controles/Create');
    }

    public function store(ControlRequest $request)
    {
        $data = $request->validated();
        Control::create($data);

        return redirect()->route('controles.index');
    }

    public function edit($id)
    {
        $control = Control::findOrFail($id);
        return Inertia::render('Controles/Edit', ['control' => $control]);
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
