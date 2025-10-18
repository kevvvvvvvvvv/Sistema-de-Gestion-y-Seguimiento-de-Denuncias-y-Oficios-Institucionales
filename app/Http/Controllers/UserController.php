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
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users/Index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();
        return Inertia::render('Users/Create', [
            'roles' => $roles
        ]);
    }

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

    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);

        $roles = Role::all();
        return Inertia::render('Users/Edit', ['user' => $user,'roles'=>$roles]);
    }

    public function update(UserRequest  $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        
        $user->update($data);
        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('users.index');
    }
}
