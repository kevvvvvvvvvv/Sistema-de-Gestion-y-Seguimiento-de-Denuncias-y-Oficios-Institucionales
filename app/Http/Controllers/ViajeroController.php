<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViajeroRequest;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Folio;
use Inertia\Inertia;

use App\Models\User;
use App\Models\Institucion;
use App\Models\Departamento;
use App\Models\Destinatario;
use App\Models\Servidor;
use App\Models\Oficio;
use App\Models\Viajero;

class ViajeroController extends Controller
{

    public function index()
    {
        $viajeros = Viajero::with([
            'oficio.servidor',
            'oficio.destinatario',
            'oficio.departamentoD',
            'usuario'
        ])->get()
          ->map(function ($v) {
              $v->url = $v->oficio?->url ? asset('storage/' . $v->oficio->url) : null;
              return $v;
          });
        
        return Inertia::render('Viajeros/Index', ['viajeros' => $viajeros]);
    }
    

    public function create()
    {
        $servidor = Servidor::all();
        $departamento = Departamento::all();
        $institucion = Institucion::all();
        $user = User::all();

        return Inertia::render('Viajeros/Create',
        ['servidor' => $servidor,
        'departamento' => $departamento,
        'institucion' => $institucion,
        'user' => $user]);
    }

    public function store(Request $request)
    {
        if($request->hasFile('pdfFile')) {
            $pdfPath = $request->file('pdfFile')->store('pdfs', 'public'); // se guarda en storage/app/public/pdfs
        }

        $destinatario = Destinatario::create([
            'tipo'          => 1,
            'idServidor'   => $request->idServidorD,
            'idDepartamento'=> $request->idDepartamentoD,
        ]);

        $oficio = Oficio::create([
            'numOficio'      => $request->numOficio,
            'fechaLlegada'   => \Carbon\Carbon::parse(date('Y-m-d', strtotime($request->fechaLlegada))),
            'fechaCreacion'  => \Carbon\Carbon::parse(date('Y-m-d', strtotime($request->fechaCreacion))),
            'url'            => $pdfPath,
            'idRemitente'     => $request->idServidor,
            'idDestinatario' => $destinatario->idDestinatario,
        ]);

        $viajero = Viajero::create([
            'asunto'     => $request->asunto,
            'resultado'  => $request->resultado,
            'instruccion'=> $request->instruccion,
            'fechaEntrega'=> \Carbon\Carbon::parse(date('Y-m-d', strtotime($request->fechaEntrega))),
            'status'     => 'En Proceso',
            'numOficio'   => $oficio->numOficio,
            'idUsuario'  => $request->idUsuario,
        ]);
    
        return redirect()->route('viajeros.index')
                         ->with('success', 'Viajero creado correctamente');

    }
}
