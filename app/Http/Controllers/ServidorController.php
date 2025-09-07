<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServidorRequest;
use App\Models\Baja;
use App\Models\Departamento;
use App\Models\Expediente;
use App\Models\Institucion;
use App\Models\Servidor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServidorController extends Controller
{
    public function index()
    {
        $servidores = Servidor::with(['institucion', 'departamento'])->get();

        return Inertia::render('Servidores/Index', ['servidores' => $servidores]);
    }

    public function create()
    {
        $instituciones = Institucion::select('idInstitucion', 'nombreCompleto')->get();
        $departamentos = Departamento::select('idDepartamento', 'nombre', 'idInstitucion')->get();
        return Inertia::render('Servidores/Create', 
        ['instituciones' => $instituciones, 'departamentos' => $departamentos]);
    }

    public function store(ServidorRequest $request)
    {
        $data = $request->all();

        if(isset($data['fechaIngreso'])){
            $data['fechaIngreso'] = \Carbon\Carbon::parse($data['fechaIngreso'])->format('Y-m-d');
        }
        
        Servidor::create($data);

        return redirect()->route('servidores.index');
    }

    public function edit($id)
    {
        $instituciones = Institucion::select('idInstitucion', 'nombreCompleto')->get();
        $departamentos = Departamento::select('idDepartamento', 'nombre', 'idInstitucion')->get();
        $servidor = Servidor::findOrFail($id);

        return Inertia::render('Servidores/Edit', 
        ['servidor' => $servidor, 
        'departamentos' => $departamentos, 'instituciones' => $instituciones]);
    }

    public function update(ServidorRequest $request, $id)
    {
        $servidor = Servidor::findOrFail($id);

        $data = $request->validated();

        if(isset($data['fechaIngreso'])){
            $data['fechaIngreso'] = \Carbon\Carbon::parse($data['fechaIngreso'])->format('Y-m-d');
        }
        
        $servidor->update($data);

        if($data['estatus'] === 'Baja'){

            $baja = Baja::where('idServidor', $servidor['idServidor'])->first();

            if($baja == null){
                $fechaBaja = \Carbon\Carbon::now()->format('Y-m-d');
                $descripcion = 'Servidor dado de baja desde el módulo de Servidores.';
                $expediente = Expediente::where('idServidor', $servidor['idServidor'])->first();

                Baja::Create([
                    'puestoAnt' => $servidor['puesto'],
                    'nivelAnt' => $servidor['nivel'],
                    'adscripcionAnt' => $servidor->departamento->nombre,
                    'fechaIngresoAnt' => $servidor['fechaIngreso'],
                    'fechaBaja' => $fechaBaja,
                    'descripcion' => $descripcion,
                    'numero' => $expediente ? $expediente->numero : null,
                    'idServidor' => $servidor['idServidor'] 
                ]);

                $baja = Baja::where('idServidor', $servidor['idServidor'])->first();
            }

            return redirect()->route('bajas.edit', $baja->idBaja);
            
        }

        return redirect()->route('servidores.index');
    }

    public function destroy($id)
    {
        Servidor::findOrFail($id)->delete();
        return redirect()->route('servidores.index');
    }
}
