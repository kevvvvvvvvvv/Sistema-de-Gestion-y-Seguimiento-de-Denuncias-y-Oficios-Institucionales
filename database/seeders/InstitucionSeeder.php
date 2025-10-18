<?php

namespace Database\Seeders;

use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstitucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institucion::create([
            'nombreCompleto' => 'Comisión Federal de Electricidad',
            'siglas' => 'CFE'
        ]);

        Institucion::create([
            'nombreCompleto' => 'Petróleos Mexicanos',
            'siglas' => 'PEMEX'
        ]);
    }
}
