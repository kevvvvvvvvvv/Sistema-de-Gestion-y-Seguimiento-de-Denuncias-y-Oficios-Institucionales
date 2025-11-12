<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios.
     *
     * @param  ninguno
     * @return \Inertia\Response Renderiza la vista de Inertia 'Users/Index' con la lista de usuarios.
     */
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users/Index', ['users' => $users]);
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @param  ninguno
     * @return \Inertia\Response Renderiza la vista 'Users/Create' pasándole los roles disponibles.
     */
    public function create()
    {
        $roles = Role::all();
        return Inertia::render('Users/Create', [
            'roles' => $roles
        ]);
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     *
     * @param  \App\Http\Requests\UserRequest $request La solicitud validada con los datos del usuario.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios (index).
     */
    public function store(UserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'nombre' => $request->nombre,
            'apPaterno' => $request->apPaterno,
            'apMaterno' => $request->apMaterno,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($data['role']);

        return redirect()->route('users.index');
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     *
     * @param  int $id El ID del usuario a editar.
     * @return \Inertia\Response Renderiza la vista 'Users/Edit' con los datos del usuario y los roles.
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $roles = Role::all();
        return Inertia::render('Users/Edit', ['user' => $user,'roles'=>$roles]);
    }

    /**
     * Actualiza un usuario existente en la base de datos.
     *
     * @param  \App\Http\Requests\UserRequest $request La solicitud validada.
     * @param  int $id El ID del usuario a actualizar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios (index).
     */
    public function update(UserRequest  $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validated();

        // Lógica para actualizar la contraseña solo si se proporciona una nueva
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update($data);

        // Sincroniza el rol del usuario si se proporcionó uno nuevo.
        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return redirect()->route('users.index');
    }

    /**
     * Elimina un usuario de la base de datos.
     *
     * @param  int $id El ID del usuario a eliminar.
     * @return \Illuminate\Http\RedirectResponse Redirige al listado de usuarios (index).
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index');
    }
}
