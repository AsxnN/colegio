<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('rol')->paginate(10);
        return view('colegio.usuarios.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('colegio.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:12|unique:users',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'telefono' => 'nullable|string|max:30',
        ]);

        User::create([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $request->rol_id,
            'telefono' => $request->telefono,
            'creado_en' => now(),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $usuario)
    {
        return view('colegio.usuarios.show', compact('usuario'));
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('colegio.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'dni' => ['required', 'string', 'max:12', Rule::unique('users')->ignore($usuario->id)],
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'rol_id' => 'required|exists:roles,id',
            'telefono' => 'nullable|string|max:30',
        ]);

        $data = [
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'telefono' => $request->telefono,
            'actualizado_en' => now(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}