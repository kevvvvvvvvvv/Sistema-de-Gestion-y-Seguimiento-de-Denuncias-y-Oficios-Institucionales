<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Oficio;
use App\Models\Viajero;

class ViajeroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Oficio::create([
            'numOficio' => 'OF-001',
            'fechaLlegada' => '2025-09-24',
            'fechaCreacion' => '2025-09-01',
            'idServidorRemitente' => 1,
            'idServidorDestinatario' => 2,
        ]);

        Viajero::create([
            'asunto' => 'Revisión de contrato',
            'instruccion' => '',
            'resultado' => '',
            'fechaEntrega' => null,
            'status' => 'Inicio',
            'numOficio' => 'OF-001',
        ]);

        Oficio::create([
            'numOficio' => 'OF-002',
            'fechaLlegada' => '2025-09-25',
            'fechaCreacion' => '2025-09-02',
            'idServidorRemitente' => 2,
            'idServidorDestinatario' => 3,
        ]);

        Viajero::create([
            'asunto' => 'Solicitud de material de oficina',
            'instruccion' => '',
            'resultado' => '',
            'fechaEntrega' => null,
            'status' => 'Inicio',
            'numOficio' => 'OF-002',
        ]);


        Oficio::create([
            'numOficio' => 'OF-003',
            'fechaLlegada' => '2025-09-20',
            'fechaCreacion' => '2025-09-05',
            'idServidorRemitente' => 3,
            'idServidorDestinatario' => 1,
        ]);

        Viajero::create([
            'asunto' => 'Elaborar informe financiero',
            'instruccion' => 'Preparar un reporte trimestral',
            'resultado' => '',
            'fechaEntrega' => null,
            'status' => 'En progreso',
            'numOficio' => 'OF-003',
        ]);

        Oficio::create([
            'numOficio' => 'OF-004',
            'fechaLlegada' => '2025-09-21',
            'fechaCreacion' => '2025-09-06',
            'idServidorRemitente' => 1,
            'idServidorDestinatario' => 4,
        ]);

        Viajero::create([
            'asunto' => 'Plan de capacitación',
            'instruccion' => 'Diseñar temario de curso técnico',
            'resultado' => '',
            'fechaEntrega' => null,
            'status' => 'En progreso',
            'numOficio' => 'OF-004',
        ]);


        Oficio::create([
            'numOficio' => 'OF-005',
            'fechaLlegada' => '2025-09-18',
            'fechaCreacion' => '2025-09-10',
            'idServidorRemitente' => 4,
            'idServidorDestinatario' => 2,
        ]);

        Viajero::create([
            'asunto' => 'Actualización de base de datos',
            'instruccion' => 'Migrar información al nuevo servidor',
            'resultado' => 'Migración realizada exitosamente',
            'fechaEntrega' => '2025-09-22',
            'status' => 'Finalizado',
            'numOficio' => 'OF-005',
            'idUsuario' => 2
        ]);

        Oficio::create([
            'numOficio' => 'OF-006',
            'fechaLlegada' => '2025-09-15',
            'fechaCreacion' => '2025-09-08',
            'idServidorRemitente' => 1,
            'idServidorDestinatario' => 3,
        ]);

        Viajero::create([
            'asunto' => 'Revisión de reglamento interno',
            'instruccion' => 'Analizar propuestas y redactar documento final',
            'resultado' => 'Documento aprobado por dirección',
            'fechaEntrega' => '2025-09-19',
            'status' => 'Finalizado',
            'numOficio' => 'OF-006',
            'idUsuario' => 1
        ]);


    }
}
