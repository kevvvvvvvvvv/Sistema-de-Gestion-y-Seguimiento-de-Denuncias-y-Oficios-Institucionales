<?php

namespace Database\Seeders;

use App\Models\Control;
use App\Models\Expediente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $expedientes = Expediente::all();
        $i = 1;

        foreach ($expedientes as $exp) {
            switch ($i) {
                case 1: // Solo inicio
                    Control::create([
                        'acInicio' => 'Si',
                        'feEntregaInicio' => now()->subDays(290),
                        'acModificacion' => 'No',
                        'acConclusion' => 'No',
                        'comentarios' => 'Solo entregó acuerdo de inicio.',
                        'acProrroga' => 'No',
                        'acAuxilio' => 'No',
                        'acRegularizacion' => 'No',
                        'acRequerimiento' => 'No',
                        'acOficioReque' => 'No',
                        'numero' => $exp->numero,
                    ]);
                    break;

                case 2: // Inicio + Modificación
                    Control::create([
                        'acInicio' => 'Si',
                        'feEntregaInicio' => now()->subDays(280),
                        'acModificacion' => 'Si',
                        'feEntregaModif' => now()->subDays(260),
                        'acConclusion' => 'No',
                        'comentarios' => 'Falta acuerdo de conclusión.',
                        'acProrroga' => 'No',
                        'acAuxilio' => 'No',
                        'acRegularizacion' => 'No',
                        'acRequerimiento' => 'No',
                        'acOficioReque' => 'No',
                        'numero' => $exp->numero,
                    ]);
                    break;

                case 3: // Todos los acuerdos
                    Control::create([
                        'acInicio' => 'Si',
                        'feEntregaInicio' => now()->subDays(200),
                        'acModificacion' => 'Si',
                        'feEntregaModif' => now()->subDays(180),
                        'acConclusion' => 'Si',
                        'feEntregaCon' => now()->subDays(160), // ✅ agregado
                        'comentarios' => 'Servidor cumplió con todos los acuerdos.',
                        'acProrroga' => 'No',
                        'acAuxilio' => 'No',
                        'acRegularizacion' => 'No',
                        'acRequerimiento' => 'No',
                        'acOficioReque' => 'No',
                        'numero' => $exp->numero,
                    ]);
                    break;

                case 4: // Ninguno
                    Control::create([
                        'acInicio' => 'No',
                        'acModificacion' => 'No',
                        'acConclusion' => 'No',
                        'comentarios' => 'Servidor omiso, ningún acuerdo entregado.',
                        'acProrroga' => 'No',
                        'acAuxilio' => 'No',
                        'acRegularizacion' => 'No',
                        'acRequerimiento' => 'No',
                        'acOficioReque' => 'No',
                        'numero' => $exp->numero,
                    ]);
                    break;

                default: // Mezcla aleatoria
                    $hasConclusion = $i % 4 == 0;

                    Control::create([
                        'acInicio' => $i % 2 == 0 ? 'Si' : 'No',
                        'feEntregaInicio' => $i % 2 == 0 ? now()->subDays(150) : null,
                        'acModificacion' => $i % 3 == 0 ? 'Si' : 'No',
                        'feEntregaModif' => $i % 3 == 0 ? now()->subDays(120) : null,
                        'acConclusion' => $hasConclusion ? 'Si' : 'No',
                        'feEntregaCon' => $hasConclusion ? now()->subDays(100) : null, // ✅ agregado solo si aplica
                        'comentarios' => 'Caso de prueba número ' . $i,
                        'acProrroga' => 'No',
                        'acAuxilio' => 'No',
                        'acRegularizacion' => 'No',
                        'acRequerimiento' => 'No',
                        'acOficioReque' => 'No',
                        'numero' => $exp->numero,
                    ]);
                    break;
            }

            $i++;
        }
    }
}
