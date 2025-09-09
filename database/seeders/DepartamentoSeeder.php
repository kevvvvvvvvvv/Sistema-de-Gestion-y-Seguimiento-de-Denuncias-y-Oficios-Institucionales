<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamento = Departamento::create(
            [
                'nombre' => 'Recursos Humanos',
                'idInstitucion' => '1'
            ]
        );

        $departamento = Departamento::create(
            [
                'nombre' => 'Tecnologías de la Información',
                'idInstitucion' => '1'
            ]
        );

        $departamento = Departamento::create(
            [
                'nombre' => 'Finanzas',
                'idInstitucion' => '2'
            ]
        );

        $departamento = Departamento::create(
            [
                'nombre' => 'Operaciones',
                'idInstitucion' => '2'
            ]
        );
    }
}
