<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use App\Http\Requests\RoleRequest;

class RolesController extends Controller
{
    public function index()
    {
        $roles =  Role::all();
        return Inertia::render('Roles/Index', ['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::select('id', 'name')->get();
    
        return Inertia::render('Roles/Create', [
            'permissions' => $permissions
        ]);
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }
    
        return redirect()->route('roles.index')
            ->with('success', 'Rol creado correctamente');
    }

    public function edit($id)
    {
        $role = Role::with('permissions')->find($id);
        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'permissions' => Permission::all(),
        ]);
        
    }

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);
    
        return redirect()->route('roles.index')
            ->with('success', 'Rol actualizado correctamente');
    }


    public function destroy($id)
    {
        $role = Role::findOrFail($id);
    
        if ($role->name === 'admin') {
            return redirect()->route('roles.index')
                ->with('error', 'No puedes eliminar el rol administrador');
        }
    
        $role->delete();
    
        return redirect()->route('roles.index')
            ->with('success', 'Rol eliminado correctamente');
    }
    
}
