<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartamentoRequest;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Institucion;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::with('institucion')->get();

        return Inertia::render('Departamentos/Index', ['departamentos' => $departamentos]);
    }

    public function create()
    {
        $instituciones = Institucion::select('idInstitucion', 'nombreCompleto')->get();
        return Inertia::render('Departamentos/Create', ['instituciones' => $instituciones]);
    }

    public function store(DepartamentoRequest $request)
    {
        Departamento::create($request->validated());
        return redirect()->route('departamentos.index');
    }

    public function edit($id)
    {
        $instituciones = Institucion::select('idInstitucion', 'nombreCompleto')->get();
        $departamento = Departamento::findOrFail($id);
        return Inertia::render('Departamentos/Edit', 
        ['departamento' => $departamento, 'instituciones' => $instituciones]);
    }

    public function update(DepartamentoRequest  $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $data = $request->validated();
        
        $departamento->update($data);

        return redirect()->route('departamentos.index');
    }

    public function destroy($id)
    {
        Departamento::findOrFail($id)->delete();
        return redirect()->route('departamentos.index');
    }
}
