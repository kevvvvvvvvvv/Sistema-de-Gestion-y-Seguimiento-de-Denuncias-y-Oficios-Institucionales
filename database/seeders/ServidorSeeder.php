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
        Servidor::create([
            'nombreCompleto' => 'Juan Pérez',
            'genero' => 'Masculino',
            'grado' => 'Licenciado',
            'fechaIngreso' => '2015-06-15',
            'puesto' => 'Analista',
            'estatus' => 'Alta',
            'idInstitucion' => 1,
            'idDepartamento' => 1,
            'nivel' => 'Básico'
        ]);

        Servidor::create([
            'nombreCompleto' => 'María López',
            'genero' => 'Femenino',
            'grado' => 'Ingeniera',
            'fechaIngreso' => '2018-03-22',
            'puesto' => 'Desarrolladora',
            'estatus' => 'Alta',
            'idInstitucion' => 1,
            'idDepartamento' => 2,
            'nivel' => 'Intermedio'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Carlos Sánchez',
            'genero' => 'Masculino',
            'grado' => 'Contador',
            'fechaIngreso' => '2012-11-05',
            'puesto' => 'Contador',
            'estatus' => 'Alta',
            'idInstitucion' => 2,
            'idDepartamento' => 3,
            'nivel' => 'Avanzado'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Ana Gómez',
            'genero' => 'Femenino',
            'grado' => 'Administradora',
            'fechaIngreso' => '2020-01-10',
            'puesto' => 'Coordinadora',
            'estatus' => 'Alta',
            'idInstitucion' => 2,
            'idDepartamento' => 2,
            'nivel' => 'Intermedio'
        ]);

        // Nuevos para llegar a 12
        Servidor::create([
            'nombreCompleto' => 'Luis Hernández',
            'genero' => 'Masculino',
            'grado' => 'Licenciado',
            'fechaIngreso' => '2022-01-10',
            'puesto' => 'Abogado',
            'estatus' => 'Alta',
            'idInstitucion' => 1,
            'idDepartamento' => 1,
            'nivel' => 'Avanzado'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Patricia Ramírez',
            'genero' => 'Femenino',
            'grado' => 'Ingeniera',
            'fechaIngreso' => '2023-05-01',
            'puesto' => 'Coordinadora',
            'estatus' => 'Alta',
            'idInstitucion' => 1,
            'idDepartamento' => 2,
            'nivel' => 'Intermedio'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Jorge Martínez',
            'genero' => 'Masculino',
            'grado' => 'Contador',
            'fechaIngreso' => '2022-09-01',
            'puesto' => 'Analista',
            'estatus' => 'Alta',
            'idInstitucion' => 2,
            'idDepartamento' => 3,
            'nivel' => 'Básico'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Elena Torres',
            'genero' => 'Femenino',
            'grado' => 'Administradora',
            'fechaIngreso' => '2022-03-10',
            'puesto' => 'Supervisora',
            'estatus' => 'Alta',
            'idInstitucion' => 2,
            'idDepartamento' => 1,
            'nivel' => 'Intermedio'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Roberto Díaz',
            'genero' => 'Masculino',
            'grado' => 'Ingeniero',
            'fechaIngreso' => '2021-07-12',
            'puesto' => 'Soporte Técnico',
            'estatus' => 'Alta',
            'idInstitucion' => 1,
            'idDepartamento' => 3,
            'nivel' => 'Básico'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Gabriela Soto',
            'genero' => 'Femenino',
            'grado' => 'Licenciada',
            'fechaIngreso' => '2019-11-25',
            'puesto' => 'Secretaria',
            'estatus' => 'Alta',
            'idInstitucion' => 2,
            'idDepartamento' => 2,
            'nivel' => 'Básico'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Fernando Morales',
            'genero' => 'Masculino',
            'grado' => 'Doctor',
            'fechaIngreso' => '2021-02-18',
            'puesto' => 'Investigador',
            'estatus' => 'Alta',
            'idInstitucion' => 1,
            'idDepartamento' => 1,
            'nivel' => 'Avanzado'
        ]);

        Servidor::create([
            'nombreCompleto' => 'Claudia Reyes',
            'genero' => 'Femenino',
            'grado' => 'Ingeniera',
            'fechaIngreso' => '2020-08-05',
            'puesto' => 'Analista de Datos',
            'estatus' => 'Alta',
            'idInstitucion' => 2,
            'idDepartamento' => 3,
            'nivel' => 'Intermedio'
        ]);
    }
}
