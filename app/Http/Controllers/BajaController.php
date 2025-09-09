<?php

namespace App\Http\Controllers;

use App\Http\Requests\BajaRequest;
use App\Models\Baja;
use App\Models\Expediente;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BajaController extends Controller
{
    public function index()
    {
        $bajas = Baja::with(['servidor', 'expediente'])->get();

        return Inertia::render('Bajas/Index', ['bajas' => $bajas]);
    }

    public function create()
    {
        $expedientes = Expediente::select('numero', 'idServidor')->get();
        $servidores = Servidor::select('idServidor', 'nombreCompleto')->get();
        return Inertia::render('Bajas/Create', 
        ['expedientes' => $expedientes, 'servidores' => $servidores]);
    }

    public function store(BajaRequest $request)
    {
        $data = $request->validated();
        $servidor = Servidor::findOrFail($data['idServidor']);

        $data['fechaBaja'] = \Carbon\Carbon::parse($data['fechaBaja'])->format('Y-m-d');
        if($data['numero'] == 'Sin expediente registrado'){
            $data['numero'] = null;
        }

        Baja::Create([
            'puestoAnt' => $servidor['puesto'],
            'nivelAnt' => $servidor['nivel'],
            'adscripcionAnt' => $servidor->departamento->nombre,
            'fechaIngresoAnt' => $servidor['fechaIngreso'],
            'fechaBaja' => $data['fechaBaja'],
            'descripcion' => $data['descripcion'],
            'numero' => $data['numero'],
            'idServidor' => $data['idServidor'] 
        ]);

        $servidor->update(['estatus' => 'Baja']);

        return redirect()->route('bajas.index');
    }

    public function edit($id)
    {
        $expedientes = Expediente::select('numero')->get();
        $servidores = Servidor::select('idServidor', 'nombreCompleto')->get();
        $baja = Baja::findOrFail($id);

        return Inertia::render('Bajas/Edit', 
        ['baja' => $baja, 
        'expedientes' => $expedientes, 'servidores' => $servidores]);
    }

    public function update(BajaRequest $request, $id)
    {
        $baja = Baja::findOrFail($id);

        $data = $request->validated();
        $data['fechaBaja'] = \Carbon\Carbon::parse($data['fechaBaja'])->format('Y-m-d');
        
        $baja->update($data);

        return redirect()->route('bajas.index');
    }

    public function destroy($id)
    {
        $baja = Baja::findOrFail($id);
        $servidor = Servidor::findOrFail($baja->idServidor);
        $servidor->update(['estatus' => 'Alta']);
        $baja->delete();
        return redirect()->route('bajas.index');
    }
}
