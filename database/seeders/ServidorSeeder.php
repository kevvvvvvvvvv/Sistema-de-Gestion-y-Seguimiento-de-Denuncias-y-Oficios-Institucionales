<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Institucion;
use App\Models\Servidor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ServidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        $instituciones = Institucion::all();

        foreach ($instituciones as $institucion) {
            $departamentosDeLaInstitucion = Departamento::where('idInstitucion', $institucion->idInstitucion)
            ->pluck('idDepartamento')
            ->toArray();

            for ($i = 0; $i < 6; $i++) {
                Servidor::create([
                    'nombreCompleto' => $faker->name,
                    'genero' => $faker->randomElement(['Masculino', 'Femenino']),
                    'grado' => $faker->randomElement(['Lic.', 'Ing.', 'C.']),
                    'fechaIngreso' => $faker->date(),
                    'puesto' => $faker->jobTitle,
                    'estatus' => 'Alta',
                    'idInstitucion' => $institucion->idInstitucion,
                    'idDepartamento' => $faker->randomElement($departamentosDeLaInstitucion), 
                    'nivel' => $faker->randomElement(['O31', 'O29', 'O21'])
                ]);
            }
        }
    }
}
