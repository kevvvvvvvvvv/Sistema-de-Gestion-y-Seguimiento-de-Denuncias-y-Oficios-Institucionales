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

        $roleEncargadoOficios->givePermissionTo('crear departamentos');
        $roleEncargadoOficios->givePermissionTo('editar departamentos');
        $roleEncargadoOficios->givePermissionTo('eliminar departamentos');
        $roleEncargadoOficios->givePermissionTo('consultar departamentos');

        $roleEncargadoDenuncias->givePermissionTo('crear departamentos');
        $roleEncargadoDenuncias->givePermissionTo('editar departamentos');
        $roleEncargadoDenuncias->givePermissionTo('eliminar departamentos');
        $roleEncargadoDenuncias->givePermissionTo('consultar departamentos');

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

        $roleEncargadoOficios->givePermissionTo('crear instituciones');
        $roleEncargadoOficios->givePermissionTo('editar instituciones');
        $roleEncargadoOficios->givePermissionTo('eliminar instituciones');
        $roleEncargadoOficios->givePermissionTo('consultar instituciones');

        $roleEncargadoDenuncias->givePermissionTo('crear instituciones');
        $roleEncargadoDenuncias->givePermissionTo('editar instituciones');
        $roleEncargadoDenuncias->givePermissionTo('eliminar instituciones');
        $roleEncargadoDenuncias->givePermissionTo('consultar instituciones');

        // Servidores
        Permission::firstOrCreate(['name' => 'crear servidores']);
        Permission::firstOrCreate(['name' => 'editar servidores']);
        Permission::firstOrCreate(['name' => 'eliminar servidores']);
        Permission::firstOrCreate(['name' => 'consultar servidores']);

        $roleEncargadoOficios->givePermissionTo('crear servidores');
        $roleEncargadoOficios->givePermissionTo('editar servidores');
        $roleEncargadoOficios->givePermissionTo('eliminar servidores');
        $roleEncargadoOficios->givePermissionTo('consultar servidores');

        $roleEncargadoDenuncias->givePermissionTo('crear servidores');
        $roleEncargadoDenuncias->givePermissionTo('editar servidores');
        $roleEncargadoDenuncias->givePermissionTo('eliminar servidores');
        $roleEncargadoDenuncias->givePermissionTo('consultar servidores');

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

        $roleEncargadoDenuncias->givePermissionTo('crear expedientes');
        $roleEncargadoDenuncias->givePermissionTo('editar expedientes');
        $roleEncargadoDenuncias->givePermissionTo('eliminar expedientes');
        $roleEncargadoDenuncias->givePermissionTo('consultar expedientes');

        // Oficios
        Permission::firstOrCreate(['name' => 'crear oficios']);
        Permission::firstOrCreate(['name' => 'editar oficios']);
        Permission::firstOrCreate(['name' => 'eliminar oficios']);
        Permission::firstOrCreate(['name' => 'consultar oficios']);

        $roleEncargadoOficios->givePermissionTo('crear oficios');
        $roleEncargadoOficios->givePermissionTo('editar oficios');
        $roleEncargadoOficios->givePermissionTo('eliminar oficios');
        $roleEncargadoOficios->givePermissionTo('consultar oficios');

        // Viajeros
        Permission::firstOrCreate(['name' => 'crear viajeros']);
        Permission::firstOrCreate(['name' => 'editar viajeros']);
        Permission::firstOrCreate(['name' => 'eliminar viajeros']);
        Permission::firstOrCreate(['name' => 'consultar viajeros']);

        $roleEncargadoOficios->givePermissionTo('crear viajeros');
        $roleEncargadoOficios->givePermissionTo('editar viajeros');
        $roleEncargadoOficios->givePermissionTo('eliminar viajeros');
        $roleEncargadoOficios->givePermissionTo('consultar viajeros');

        // Bajas
        Permission::firstOrCreate(['name' => 'crear bajas']);
        Permission::firstOrCreate(['name' => 'editar bajas']);
        Permission::firstOrCreate(['name' => 'eliminar bajas']);
        Permission::firstOrCreate(['name' => 'consultar bajas']);

        $roleEncargadoDenuncias->givePermissionTo('crear bajas');
        $roleEncargadoDenuncias->givePermissionTo('editar bajas');
        $roleEncargadoDenuncias->givePermissionTo('eliminar bajas');
        $roleEncargadoDenuncias->givePermissionTo('consultar bajas');

        //Controles
        Permission::firstOrCreate(['name' => 'crear controles']);
        Permission::firstOrCreate(['name' => 'editar controles']);
        Permission::firstOrCreate(['name' => 'eliminar controles']);
        Permission::firstOrCreate(['name' => 'consultar controles']);

        $roleEncargadoDenuncias->givePermissionTo('crear controles');
        $roleEncargadoDenuncias->givePermissionTo('editar controles');
        $roleEncargadoDenuncias->givePermissionTo('eliminar controles');
        $roleEncargadoDenuncias->givePermissionTo('consultar controles');

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

        //Reportes
        Permission::firstOrCreate(['name' => 'consultar reportes expedientes']);
        Permission::firstOrCreate(['name' => 'consultar reportes viajeros']);

        $roleAdministrador->givePermissionTo(Permission::all());


    }
}
