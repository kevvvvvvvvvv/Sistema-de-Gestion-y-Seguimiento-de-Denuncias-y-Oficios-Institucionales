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


        Expediente::create([
            'numero' => '123456',
            'ofRequerimiento' => 'OHC/10',
            'fechaRequerimiento' => '2025-10-01',
            'ofRespuesta' => 'OHC/20',
            'fechaRespuesta' => '2025-10-15',
            'fechaRecepcion' => '2025-10-05',
            'idServidor' => 1,
        ]);

        Control::create([
            'acProrroga' => 1,
            'acAuxilio' => 1,
            'acRegularizacion' => 1,
            'acRequerimiento' => 1,
            'acOficioReque' => 1,
            'acConclusion' => 1,
            'acInicio' => 1,
            'acModificacion' => 1,
            'numero' =>'123456',
        ]);

        Expediente::create([
            'numero' => '12',
            'ofRequerimiento' => 'OHC/10',
            'fechaRequerimiento' => '2025-10-01',
            'idServidor' => 2,
        ]);

        Control::create([
            'acProrroga' => 1,
            'acAuxilio' => 1,
            'acRegularizacion' => 1,
            'acRequerimiento' => 2,
            'acOficioReque' => 2,
            'acConclusion' => 2,
            'acInicio' => 1,
            'acModificacion' => 2,
            'numero' =>'12',
        ]);


        Expediente::create([
            'numero' => '13',
            'ofRequerimiento' => 'HHH/10',
            'fechaRequerimiento' => '2025-10-01',
            'ofRespuesta' => 'OHC/30',
            'idServidor' => 3,
        ]);

        Control::create([
            'acProrroga' => 2,
            'acAuxilio' => 2,
            'acRegularizacion' => 2,
            'acRequerimiento' => 2,
            'acOficioReque' => 2,
            'acConclusion' => 2,
            'acInicio' => 2,
            'acModificacion' => 2,
            'numero' =>'13',
        ]);


        Expediente::create([
            'numero' => '14',
            'ofRequerimiento' => 'OZZ/10',
            'fechaRequerimiento' => '2025-10-01',
            'ofRespuesta' => 'OHC/30',
            'idServidor' => 4,
        ]);


        Control::create([
            'acProrroga' => 1,
            'acAuxilio' => 1,
            'acRegularizacion' => 1,
            'acRequerimiento' => 1,
            'acOficioReque' => 2,
            'acConclusion' => 2,
            'acInicio' => 1,
            'acModificacion' => 2,
            'numero' =>'14',
        ]);

    }
}
