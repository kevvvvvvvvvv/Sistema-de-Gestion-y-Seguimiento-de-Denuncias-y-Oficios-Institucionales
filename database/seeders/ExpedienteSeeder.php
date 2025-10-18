<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expediente;
use App\Models\Control;
use App\Models\Servidor;

class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servidores = Servidor::all();

        foreach ($servidores as $index => $servidor) {
            $hasRespuesta = ($index + 1) % 3 !== 0;

            Expediente::create([
                'numero' => 'EXP-2025-' . str_pad($servidor->idServidor, 4, '0', STR_PAD_LEFT),
                'ofRequerimiento' => 'OF-REQ-' . str_pad($servidor->idServidor, 4, '0', STR_PAD_LEFT),
                'fechaRequerimiento' => now()->subDays(300)->format('Y-m-d'),
                'ofRespuesta' => $hasRespuesta ? 'OF-RESP-' . str_pad($servidor->idServidor, 4, '0', STR_PAD_LEFT) : null,
                'fechaRespuesta' => $hasRespuesta ? now()->subDays(295)->format('Y-m-d') : null,
                'fechaRecepcion' => $hasRespuesta ? now()->subDays(294)->format('Y-m-d') : null,
                'idServidor' => $servidor->idServidor,
            ]);
        }
    }
}
