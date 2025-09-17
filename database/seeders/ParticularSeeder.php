<?php

namespace Database\Seeders;

use App\Models\Particular;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParticularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Particular::create([
            'nombreCompleto' => 'Alfonso Pérez',
            'grado' => 'Lic.',
            'genero' => 1
        ]);

        Particular::create([
            'nombreCompleto' => 'María López',
            'grado' => 'Doc.',
            'genero' => 2
        ]);
    }
}
