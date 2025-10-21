<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class RestauracionController extends Controller
{

    public function showView()
    {
        return Inertia::render('BaseDeDatos/Restauracion', [

            'success' => session('success'),
            'error'   => session('error'),
        ]);
    }


    public function restore(Request $request)
    {

        $request->validate([

            'sql_file' => 'required|file|mimetypes:text/plain,application/sql,text/x-sql|max:102400',
        ], [
            'sql_file.required' => 'Debes seleccionar un archivo .sql.',
            'sql_file.mimetypes' => 'El archivo debe ser de tipo .sql (texto plano).',
            'sql_file.max' => 'El archivo es demasiado grande (máx 100MB).',
        ]);

        try {

            $dbConfig = config('database.connections.mysql');
            $dbName = $dbConfig['database'];
            $dbUser = $dbConfig['username'];
            $dbPass = $dbConfig['password'];
            $dbHost = $dbConfig['host'];
            $dbPort = $dbConfig['port'];


            $filePath = $request->file('sql_file')->getRealPath();

 
            $command = sprintf(
                'mariadb --user="%s" --password="%s" --host="%s" --port="%s" "%s"',
                $dbUser,
                $dbPass,
                $dbHost,
                $dbPort,
                $dbName
            );

            $sqlContent = File::get($filePath);
            
            $process = Process::input($sqlContent)->run($command);


            if ($process->successful()) {
                Log::info("Restauración de BD completada por usuario: " . Auth::id());
                return to_route('bd.restauracion')
                    ->with('success', '¡Restauración completada exitosamente!');
            } else {
                $error = $process->errorOutput();
                Log::error("Error en restauración de BD: " . $error);
                return to_route('bd.restauracion')
                    ->with('error', 'Error al restaurar: ' . $error);
            }

        } catch (\Exception $e) {
            Log::error("Excepción en restauración de BD: " . $e->getMessage());
            return to_route('bd.restauracion')
                ->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}
