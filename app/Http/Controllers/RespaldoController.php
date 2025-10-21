<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Backup;
use App\Jobs\GenerarBackupJob;
use Illuminate\Support\Facades\Storage;

class RespaldoController extends Controller
{
    public function index()
    {
        $backups = Auth::user()->backups()
                        ->latest() 
                        ->get();

        return Inertia::render('BaseDeDatos/Respaldo', [
            'backups' => $backups,
            'success' => session('success'),
            'error' => session('error'),
        ]);
    }

    public function store(Request $request)
    {
        GenerarBackupJob::dispatch(Auth::user()->idUsuario);
        return to_route('bd.respaldo.index')
            ->with('success', 'Tu respaldo se está generando. Estará listo en la lista en unos momentos.');
    }

    public function download(Backup $backup)
    {
        if ($backup->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        if ($backup->status !== 'completed') {
            return to_route('bd.respaldo.index')
                ->with('error', 'Este respaldo aún no está listo o ha fallado.');
        }
        $fullPath = storage_path('app/' . $backup->path);

        if (!Storage::disk('local')->exists($backup->path)) {
             return to_route('bd.respaldo.index')
                ->with('error', 'El archivo del respaldo no se ha encontrado en el servidor.');
        }

        return response()->download($fullPath, $backup->file_name);
    }
}
