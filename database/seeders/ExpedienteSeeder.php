<?php

namespace Database\Seeders;

use App\Models\Expediente;
use App\Models\Servidor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpedienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servidores = Servidor::all();

        $i = 1;
        foreach ($servidores as $servidor) {
            Expediente::create([
                'numero' => 'EXP-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'ofRequerimiento' => 'OF-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'fechaRequerimiento' => now()->subDays(300)->format('Y-m-d'),
                'ofRespuesta' => 'RESP-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'fechaRespuesta' => now()->subDays(295)->format('Y-m-d'),
                'fechaRecepcion' => now()->subDays(294)->format('Y-m-d'),
                'idServidor' => $servidor->idServidor,
            ]);
            $i++;
        }
    }
}
