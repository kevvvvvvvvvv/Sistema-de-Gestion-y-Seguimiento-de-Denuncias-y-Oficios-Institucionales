<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Institucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cfe = Institucion::where('siglas', 'CFE')->first();
        $pemex = Institucion::where('siglas', 'PEMEX')->first();

        // Departamentos para CFE
        Departamento::create(['nombre' => 'Recursos Humanos', 'idInstitucion' => $cfe->idInstitucion]);
        Departamento::create(['nombre' => 'Tecnologías de la Información', 'idInstitucion' => $cfe->idInstitucion]);
        Departamento::create(['nombre' => 'Distribución', 'idInstitucion' => $cfe->idInstitucion]);

        // Departamentos para PEMEX
        Departamento::create(['nombre' => 'Finanzas', 'idInstitucion' => $pemex->idInstitucion]);
        Departamento::create(['nombre' => 'Operaciones', 'idInstitucion' => $pemex->idInstitucion]);
        Departamento::create(['nombre' => 'Exploración', 'idInstitucion' => $pemex->idInstitucion]);
    }
}
