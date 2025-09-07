<?php

namespace Database\Seeders;

use App\Models\Servidor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServidorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servidor = Servidor::class::create(
            [
                'nombreCompleto' => 'Juan Pérez',
                'genero' => 'Masculino',
                'grado' => 'Licenciado',
                'fechaIngreso' => '2015-06-15',
                'puesto' => 'Analista',
                'estatus' => '1',
                'idInstitucion' => '1',
                'idDepartamento' => '1'
            ]
        );

        $servidor = Servidor::class::create(
            [
                'nombreCompleto' => 'María López',
                'genero' => 'Femenino',
                'grado' => 'Ingeniera',
                'fechaIngreso' => '2018-03-22',
                'puesto' => 'Desarrolladora',
                'estatus' => '1',
                'idInstitucion' => '1',
                'idDepartamento' => '2'
            ]
        );


        $servidor = Servidor::class::create(
            [
                'nombreCompleto' => 'Carlos Sánchez',
                'genero' => 'Masculino',
                'grado' => 'Contador',
                'fechaIngreso' => '2012-11-05',
                'puesto' => 'Contador',
                'estatus' => '1',
                'idInstitucion' => '2',
                'idDepartamento' => '3'
            ]
        );

        $servidor = Servidor::class::create(
            [
                'nombreCompleto' => 'Ana Gómez',
                'genero' => 'Femenino',
                'grado' => 'Administradora',
                'fechaIngreso' => '2020-01-10',
                'puesto' => 'Coordinadora',
                'estatus' => '1',
                'idInstitucion' => '2',
                'idDepartamento' => '2'
            ]
        );
    }
}
