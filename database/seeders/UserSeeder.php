<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nombre' => 'Kevin',
            'apPaterno' => 'Trinidad',
            'apMaterno' => 'Medina',
            'email' => 'kevinyahirt@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('Administrador');

        $user = User::create([
            'nombre' => 'Camila',
            'apPaterno' => 'Alor',
            'apMaterno' => 'Contreras',
            'email' => 'acco220170@upemor.edu.mx',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('Administrador');

        $user = User::create([
            'nombre' => 'Kevin',
            'apPaterno' => 'Medina',
            'apMaterno' => 'Medina',
            'email' => 'tmko220776@upemor.edu.mx',
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('Empleado');
    }
}
