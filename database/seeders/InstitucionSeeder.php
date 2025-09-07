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
        $departamento = Institucion::create(
            [
                'nombreCompleto' => 'Comisión Federal de Electricidad',
                'siglas' => 'CFE'
            ]
        );

        $departamento = Institucion::create(
            [
                'nombreCompleto' => 'Petróleos Mexicanos',
                'siglas' => 'PEMEX'
            ]
        );

        $departamento = Institucion::create(
            [
                'nombreCompleto' => 'Instituto Mexicano del Seguro Social',
                'siglas' => 'IMSS'
            ]
        );

        $departamento = Institucion::create(
            [
                'nombreCompleto' => 'Secretaría de Educación Pública',
                'siglas' => 'SEP'
            ]
        );
    }
}
