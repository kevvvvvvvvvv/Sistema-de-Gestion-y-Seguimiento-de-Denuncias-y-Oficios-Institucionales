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

        foreach ($expedientes as $index => $exp) {
            $caso = ($index % 5) + 1; 

            $data = [
                'acInicio' => 'No', 'feEntregaInicio' => null,
                'acModificacion' => 'No', 'feEntregaModif' => null,
                'acConclusion' => 'No', 'feEntregaCon' => null,
                'acProrroga' => 'No',
                'acAuxilio' => 'No',
                'acRegularizacion' => 'No',
                'acRequerimiento' => 'No',
                'acOficioReque' => 'No',
                'comentarios' => '',
                'numero' => $exp->numero,
            ];

            switch ($caso) {
                case 1: // Expediente perfecto (todos los acuerdos principales)
                    $data['acInicio'] = 'Si'; $data['feEntregaInicio'] = now()->subDays(200);
                    $data['acModificacion'] = 'Si'; $data['feEntregaModif'] = now()->subDays(180);
                    $data['acConclusion'] = 'Si'; $data['feEntregaCon'] = now()->subDays(160);
                    $data['comentarios'] = 'Caso 1: Expediente completo.';
                    break;
                case 2: // Solo inicio
                    $data['acInicio'] = 'Si'; $data['feEntregaInicio'] = now()->subDays(290);
                    $data['comentarios'] = 'Caso 2: Solo entregó acuerdo de inicio.';
                    break;
                case 3: // Inicio y Modificación, falta conclusión
                    $data['acInicio'] = 'Si'; $data['feEntregaInicio'] = now()->subDays(280);
                    $data['acModificacion'] = 'Si'; $data['feEntregaModif'] = now()->subDays(260);
                    $data['comentarios'] = 'Caso 3: Falta acuerdo de conclusión.';
                    break;
                case 4: // Omiso total, ningún acuerdo
                    $data['comentarios'] = 'Caso 4: Omiso, ningún acuerdo entregado.';
                    break;
                case 5: // Inicio y Conclusión, pero no modificación
                    $data['acInicio'] = 'Si'; $data['feEntregaInicio'] = now()->subDays(150);
                    $data['acConclusion'] = 'Si'; $data['feEntregaCon'] = now()->subDays(100);
                    $data['comentarios'] = 'Caso 5: Entregó inicio y conclusión, pero omitió modificación.';
                    break;
            }
            Control::create($data);
        }
    }
}
