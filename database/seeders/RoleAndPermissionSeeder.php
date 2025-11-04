<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Roles
        $roleAdministrador = Role::firstOrCreate(['name' => 'Administrador']);
        $roleEncargadoOficios = Role::firstOrCreate(['name' => 'Encargado oficios']);
        $roleEncargadoDenuncias = Role::firstOrCreate(['name' => 'Encargado denuncias']);
        $roleEmpleado = Role::firstOrCreate(['name' => 'Empleado']);
        
        //Permisos

        //Departamentos
        Permission::firstOrCreate(['name' => 'crear departamentos']);
        Permission::firstOrCreate(['name' => 'editar departamentos']);
        Permission::firstOrCreate(['name' => 'eliminar departamentos']);
        Permission::firstOrCreate(['name' => 'consultar departamentos']);

        // Users
        Permission::firstOrCreate(['name' => 'crear users']);
        Permission::firstOrCreate(['name' => 'editar users']);
        Permission::firstOrCreate(['name' => 'eliminar users']);
        Permission::firstOrCreate(['name' => 'consultar users']);

        // Instituciones
        Permission::firstOrCreate(['name' => 'crear instituciones']);
        Permission::firstOrCreate(['name' => 'editar instituciones']);
        Permission::firstOrCreate(['name' => 'eliminar instituciones']);
        Permission::firstOrCreate(['name' => 'consultar instituciones']);

        // Servidores
        Permission::firstOrCreate(['name' => 'crear servidores']);
        Permission::firstOrCreate(['name' => 'editar servidores']);
        Permission::firstOrCreate(['name' => 'eliminar servidores']);
        Permission::firstOrCreate(['name' => 'consultar servidores']);

        // Remitentes
        Permission::firstOrCreate(['name' => 'crear remitentes']);
        Permission::firstOrCreate(['name' => 'editar remitentes']);
        Permission::firstOrCreate(['name' => 'eliminar remitentes']);
        Permission::firstOrCreate(['name' => 'consultar remitentes']);

        // Destinatarios
        Permission::firstOrCreate(['name' => 'crear destinatarios']);
        Permission::firstOrCreate(['name' => 'editar destinatarios']);
        Permission::firstOrCreate(['name' => 'eliminar destinatarios']);
        Permission::firstOrCreate(['name' => 'consultar destinatarios']);

        // Expedientes
        Permission::firstOrCreate(['name' => 'crear expedientes']);
        Permission::firstOrCreate(['name' => 'editar expedientes']);
        Permission::firstOrCreate(['name' => 'eliminar expedientes']);
        Permission::firstOrCreate(['name' => 'consultar expedientes']);

        // Oficios
        Permission::firstOrCreate(['name' => 'crear oficios']);
        Permission::firstOrCreate(['name' => 'editar oficios']);
        Permission::firstOrCreate(['name' => 'eliminar oficios']);
        Permission::firstOrCreate(['name' => 'consultar oficios']);

        // Viajeros
        Permission::firstOrCreate(['name' => 'crear viajeros']);
        Permission::firstOrCreate(['name' => 'editar viajeros']);
        Permission::firstOrCreate(['name' => 'eliminar viajeros']);
        Permission::firstOrCreate(['name' => 'consultar viajeros']);

        // Bajas
        Permission::firstOrCreate(['name' => 'crear bajas']);
        Permission::firstOrCreate(['name' => 'editar bajas']);
        Permission::firstOrCreate(['name' => 'eliminar bajas']);
        Permission::firstOrCreate(['name' => 'consultar bajas']);

        //Controles
        Permission::firstOrCreate(['name' => 'crear controles']);
        Permission::firstOrCreate(['name' => 'editar controles']);
        Permission::firstOrCreate(['name' => 'eliminar controles']);
        Permission::firstOrCreate(['name' => 'consultar controles']);

        // Roles
        Permission::firstOrCreate(['name' => 'crear roles']);
        Permission::firstOrCreate(['name' => 'editar roles']);
        Permission::firstOrCreate(['name' => 'eliminar roles']);
        Permission::firstOrCreate(['name' => 'consultar roles']);
        
        // Base de datos
        Permission::firstOrCreate(['name' => 'descargar respaldo']);
        Permission::firstOrCreate(['name' => 'restaurar base de datos']);

        //Historial
        Permission::firstOrCreate(['name' => 'consultar historial']);

        $roleAdministrador->givePermissionTo(Permission::all());

    }
}
