<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticularRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Particular;

class ParticularController extends Controller
{
    public function index()
    {
        $particulares = Particular::all();
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
        $particular = Particular::findOrFail($id);
        $particular->delete();

        return redirect()->route('particulares.index');
    }
}
