<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Backup;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GenerarBackupJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $userId;

    /**
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }


 public function handle(): void
    {
        try {
            $user = User::findOrFail($this->userId);
        } catch (\Exception $e) {
            Log::error("Job de backup falló: No se pudo encontrar al usuario con ID {$this->userId}");
            return; 
        }

        $backupDir = storage_path('app/backups');
        $fileName = 'backup-' . $user->idUsuario . '-' . now()->format('Y-m-d-His') . '.sql';
        $storagePath = 'backups/' . $fileName;

        $backupRecord = Backup::create([
            'user_id' => $user->idUsuario,
            'file_name' => $fileName,
            'path' => $storagePath,
            'status' => 'pending',
        ]);

        try {
            File::ensureDirectoryExists($backupDir);

            $dbConfig = config('database.connections.mysql');
            $dbName = $dbConfig['database'];
            $dbUser = $dbConfig['username'];
            $dbPass = $dbConfig['password'];
            $dbHost = $dbConfig['host'];
            $dbPort = $dbConfig['port'];

            $command = sprintf(
                'mariadb-dump --user="%s" --password="%s" --host="%s" --port="%s" "%s"',
                $dbUser,
                $dbPass, 
                $dbHost,
                $dbPort,
                $dbName
            );

            $process = Process::run($command);
            if ($process->successful()) {
                File::put(storage_path('app/' . $storagePath), $process->output());
                $backupRecord->update(['status' => 'completed']);
                Log::info("Backup completado para usuario {$user->idUsuario}: {$fileName}");

            } else {
                $error = $process->errorOutput();
                Log::error("Error en backup (mysqldump) para usuario {$user->idUsuario}: " . $error);
                $backupRecord->update(['status' => 'failed']);
            }

        } catch (\Exception $e) {
            Log::error("Excepción en Job de backup (Usuario: {$user->idUsuario}): " . $e->getMessage());
            $backupRecord->update(['status' => 'failed']);
        }
    }
}