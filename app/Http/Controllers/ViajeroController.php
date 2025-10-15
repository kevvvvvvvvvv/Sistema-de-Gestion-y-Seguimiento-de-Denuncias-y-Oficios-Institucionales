<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViajeroRequest;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Folio;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use App\Events\NewNotificationEvent;
use App\Models\User;
use App\Models\Institucion;
use App\Models\Departamento;
use App\Models\Destinatario;
use App\Models\Servidor;
use App\Models\Oficio;
use App\Models\Viajero;
use App\Models\Particular;
use App\Notifications\ViajeroCreadoNotification;
use Illuminate\Support\Facades\Auth;

class ViajeroController extends Controller
{

    public function index()
    {
        $viajeros = Viajero::with([
            'oficio.servidorRemitente',
            'oficio.departamentoRemitente',
            'oficio.particularRemitente',
            'oficio.institucionRemitente',

            'oficio.servidorDestinatario',
            'oficio.departamentoDestinatario',
            'oficio.particularDestinatario',
            'oficio.institucionDestinatario',
            
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
        $particular = Particular::all();
        $institucion = Institucion::all();
        $user = User::all();

        return Inertia::render('Viajeros/Create',
        ['servidor' => $servidor,
        'departamento' => $departamento,
        'particular' => $particular,
        'institucion' => $institucion,
        'user' => $user]);
    }

    public function store(ViajeroRequest $request)
    {
        $pdfPath = null;

        $fechaEntrega = $request->fechaEntrega;

        $fechaLlegada = preg_replace('/\s\(.*\)$/', '', $request->fechaLlegada);
        $fechaCreacion = preg_replace('/\s\(.*\)$/', '', $request->fechaCreacion);

        if ($fechaEntrega) {
            $fechaEntrega = preg_replace('/\s\(.*\)$/', '', $fechaEntrega);
            $fechaEntrega = \Carbon\Carbon::parse($fechaEntrega)->format('Y-m-d');
        } else {
            $fechaEntrega = null;
        }

        if ($request->hasFile('pdfFile')) {
            $pdfPath = $request->file('pdfFile')->store('pdfs', 'public');
        }

        //Validar que se reciba un remitente y un destinatario
        if ($request->idServidorRemitente == null && $request->idDepartamentoRemitente == null && $request->idParticularRemitente == null && $request->idInstitucionRemitente == null) {
            return back()->withErrors(['remitente' => 'Debe seleccionar un remitente']);
        }   

        if ($request->idServidorDestinatario == null && $request->idDepartamentoDestinatario == null && $request->idParticularDestinatario == null && $request->idInstitucionDestinatario == null) {
            return back()->withErrors(['destinatario' => 'Debe seleccionar un destinatario']);
        }

        if (Oficio::where('numOficio', $request->numOficio)->exists()) {
            return back()->withErrors(['numOficio' => 'El número de oficio ya existe.']);
        }

        $oficio = Oficio::create([
            'numOficio'      => $request->numOficio,
            'fechaLlegada'   => \Carbon\Carbon::parse($fechaLlegada)->format('Y-m-d'),
            'fechaCreacion'  => \Carbon\Carbon::parse($fechaCreacion)->format('Y-m-d'),
            'url'            => $pdfPath,

            'idServidorRemitente' => $request->idServidorRemitente,
            'idDepartamentoRemitente' => $request->idDepartamentoRemitente,
            'idParticularRemitente' => $request->idParticularRemitente,
            'idInstitucionRemitente' => $request->idInstitucionRemitente,

            'idServidorDestinatario' => $request->idServidorDestinatario,
            'idDepartamentoDestinatario' => $request->idDepartamentoDestinatario,
            'idParticularDestinatario' => $request->idParticularDestinatario,
            'idInstitucionDestinatario' => $request->idInstitucionDestinatario
        ]);

        $estado = 'Inicio';
        if ($request->resultado) { 
            $estado = 'Finalizado';
        } elseif ($request->instruccion) { 
            $estado = 'En progreso';
        }

        $viajero = Viajero::create([
            'asunto'      => $request->asunto,
            'resultado'   => $request->resultado,
            'instruccion' => $request->instruccion,
            'fechaEntrega'=> $fechaEntrega,
            'status'      => $estado,
            'numOficio'   => $oficio->numOficio,
            'idUsuario'   => $request->idUsuario,
        ]);

        $asuntoViajero = $viajero->asunto;
        $mensajeNotificacion = "Se creó el viajero con asunto: \"{$asuntoViajero}\"";

        $creador = Auth::user();
        $userToNotify = $creador;
        if ($request->filled('idUsuario')) {
            $encargado = User::find($request->idUsuario);
            
            if ($encargado) {
                $userToNotify = $encargado;
            }
        }

        $userToNotify->notify(new ViajeroCreadoNotification($viajero, $creador));
    
        sleep(2); 
        return redirect()->route('viajeros.index')
                         ->with('success', 'Viajero creado correctamente');

    }


    public function edit($id)
    {
        $servidor = Servidor::all();
        $departamento = Departamento::all();
        $particular = Particular::all();
        $user = User::all();

        $viajero = Viajero::with('oficio')->findOrFail($id);
        $oficio = Oficio::where('numOficio', $viajero->numOficio)->first();

        $departamentoDestinatario = Departamento::where('idDepartamento', $oficio->idDepartamentoRemitente)->first();
        $servidorDestinatario = Servidor::where('idServidor', $oficio->idServidorRemitente)->first();
        $particularDestinatario = Particular::where('idParticular', $oficio->idParticularRemitente)->first();

        $departamentoRemitente = Departamento::where('idDepartamento', $oficio->idDepartamentoDestinatario)->first();
        $servidorRemitente = Servidor::where('idServidor', $oficio->idServidorDestinatario)->first();
        $particularRemitente = Particular::where('idParticular', $oficio->idParticularDestinatario)->first();

        $remitente = null;
        if($departamentoRemitente){
            $remitente = [
                'type' => 'departamento',
                'id'   => $departamentoRemitente->idDepartamento
            ];
        }

        if($servidorRemitente){
            $remitente = [
                'type' => 'servidor',
                'id'   => $servidorRemitente->idServidor
            ];
        }

        if($particularRemitente){
            $remitente = [
                'type' => 'particular',
                'id'   => $particularRemitente->idParticular
            ];
        }

        $destinatario = null;
        if($departamentoDestinatario){
            $destinatario = [
                'type' => 'departamento',
                'id'   => $departamentoDestinatario->idDepartamento
            ];
        }

        if($servidorDestinatario){
            $destinatario = [
                'type' => 'servidor',
                'id'   => $servidorDestinatario->idServidor
            ];
        }

        if($particularDestinatario){
            $destinatario = [
                'type' => 'particular',
                'id'   => $particularDestinatario->idParticular
            ];
        }

        return Inertia::render('Viajeros/Edit', 
        ['viajero' => $viajero,
        'servidor' => $servidor,
        'departamento' => $departamento,
        'particular' => $particular,
        'oficio' => $oficio,

        'destinatario' => $destinatario,
        'remitente' => $remitente,

        'user' => $user]);
    }

    public function update(Request $request, $currentNumOficio)
    {
        $oficio = Oficio::where('numOficio', $currentNumOficio)->firstOrFail();
        $viajero = Viajero::where('numOficio', $currentNumOficio)->firstOrFail();

        // Validar que el nuevo numOficio no exista en otro registro
        if ($request->numOficio !== $currentNumOficio) {
            if (Oficio::where('numOficio', $request->numOficio)->exists()) {
                return back()->withErrors(['numOficio' => 'El número de oficio ya existe']);
            }
        }

        // Manejo de fechas
        $fechaCreacion = preg_replace('/\s\(.*\)$/', '', $request->fechaCreacion);
        $fechaLlegada  = preg_replace('/\s\(.*\)$/', '', $request->fechaLlegada);
        $fechaEntrega  = $request->fechaEntrega ? preg_replace('/\s\(.*\)$/', '', $request->fechaEntrega) : null;

        $fechaCreacion = \Carbon\Carbon::parse($fechaCreacion)->format('Y-m-d');
        $fechaLlegada  = \Carbon\Carbon::parse($fechaLlegada)->format('Y-m-d');
        $fechaEntrega  = $fechaEntrega ? \Carbon\Carbon::parse($fechaEntrega)->format('Y-m-d') : null;

        // Manejo de PDF
        if ($request->hasFile('pdfFile')) {
            $pdfPath = $request->file('pdfFile')->store('pdfs', 'public');
        } else {
            $pdfPath = $oficio->url; // conservar el PDF existente
        }

        // Actualizar oficio
        $oficio->update([
            'numOficio'                 => $request->numOficio,
            'fechaLlegada'              => $fechaLlegada,
            'fechaCreacion'             => $fechaCreacion,
            'url'                       => $pdfPath,
            'idServidorRemitente'       => $request->idServidorRemitente,
            'idDepartamentoRemitente'   => $request->idDepartamentoRemitente,
            'idParticularRemitente'     => $request->idParticularRemitente,
            'idServidorDestinatario'    => $request->idServidorDestinatario,
            'idDepartamentoDestinatario'=> $request->idDepartamentoDestinatario,
            'idParticularDestinatario'  => $request->idParticularDestinatario,
        ]);

        $estado = 'Inicio';
        if ($request->resultado) { 
            $estado = 'Finalizado';
        } elseif ($request->instruccion) { 
            $estado = 'En progreso';
        }

        // Actualizar viajero
        $viajero->update([
            'asunto'       => $request->asunto,
            'resultado'    => $request->resultado,
            'instruccion'  => $request->instruccion,
            'fechaEntrega' => $fechaEntrega,
            'idUsuario'    => $request->idUsuario,
            'status'       => $estado,
        ]);

        return redirect()->route('viajeros.index')
                        ->with('success', 'Viajero actualizado correctamente');
    }



    public function destroy($id)
    {
        $viajero = Viajero::findOrFail($id);
        $oficio = Oficio::where('numOficio', $viajero->numOficio)->first();

        if ($oficio) {

            $filePath = $oficio->url;
            $filePath = str_replace('public/', '', $filePath);

            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $oficio->delete();
        }

        $viajero->delete();

        return redirect()->route('viajeros.index')
                         ->with('success', 'Viajero eliminado correctamente');
    }


}
