<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpedienteRequest;
use App\Models\Expediente;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExpedienteController extends Controller
{
    public function index()
    {
        $expedientes = Expediente::with('servidor')->get();
        return Inertia::render('Expedientes/Index', ['expedientes' => $expedientes]);
    }

    public function create()
    {
        $servidores = Servidor::select('idServidor', 'nombreCompleto')->get();
        return Inertia::render('Expedientes/Create', ['servidores' => $servidores]);
    }

    public function store(ExpedienteRequest $request)
    {
        
        $data = $request->all();

        $data['fechaRequerimiento'] = \Carbon\Carbon::parse($data['fechaRequerimiento'])->format('Y-m-d');
        if(isset($data['fechaRespuesta'])){
            $data['fechaRespuesta'] = \Carbon\Carbon::parse($data['fechaRespuesta'])->format('Y-m-d');
        }
        if(isset($data['fechaRecepcion'])){
            $data['fechaRecepcion'] = \Carbon\Carbon::parse($data['fechaRecepcion'])->format('Y-m-d');
        }

        Expediente::create($data);

        return redirect()->route('expedientes.index');
    }

    public function edit($id)
    {
        $servidores = Servidor::select('idServidor', 'nombreCompleto')->get();
        $expediente = Expediente::findOrFail($id);
        return Inertia::render('Expedientes/Edit', 
        ['expediente' => $expediente, 'servidores' => $servidores]);
    }

    public function update(ExpedienteRequest  $request, $id)
    {
        $expediente = Expediente::findOrFail($id);

        $data = $request->validated();

        $data['fechaRequerimiento'] = \Carbon\Carbon::parse($data['fechaRequerimiento'])->format('Y-m-d');
        if(isset($data['fechaRespuesta'])){
            $data['fechaRespuesta'] = \Carbon\Carbon::parse($data['fechaRespuesta'])->format('Y-m-d');
        }
        if(isset($data['fechaRecepcion'])){
            $data['fechaRecepcion'] = \Carbon\Carbon::parse($data['fechaRecepcion'])->format('Y-m-d');
        }
        
        $expediente->update($data);

        return redirect()->route('expedientes.index');
    }

    public function destroy($id)
    {
        Expediente::findOrFail($id)->delete();
        return redirect()->route('expedientes.index');
    }
}
