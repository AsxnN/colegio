<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministradoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $administradores = Administrador::with('usuario.rol')->paginate(10);
        return view('colegio.administradores.index', compact('administradores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colegio.administradores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string|max:12|unique:users',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono_usuario' => 'nullable|string|max:30',
            'cargo' => 'required|string|max:100',
            'telefono_admin' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:150',
        ]);

        // Obtener el rol de administrador
        $adminRole = Role::where('nombre', 'Administrador')->first();

        // Crear el usuario
        $usuario = User::create([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $adminRole->id,
            'telefono' => $request->telefono_usuario,
            'creado_en' => now(),
        ]);

        // Crear el administrador
        Administrador::create([
            'usuario_id' => $usuario->id,
            'cargo' => $request->cargo,
            'telefono' => $request->telefono_admin,
            'direccion' => $request->direccion,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('administradores.index')->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Administrador $administradore)
    {
        return view('colegio.administradores.show', compact('administradore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Administrador $administradore)
    {
        return view('colegio.administradores.edit', compact('administradore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Administrador $administradore)
    {
        $request->validate([
            'dni' => 'required|string|max:12|unique:users,dni,' . $administradore->usuario->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $administradore->usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'telefono_usuario' => 'nullable|string|max:30',
            'cargo' => 'required|string|max:100',
            'telefono_admin' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:150',
        ]);

        // Actualizar datos del usuario
        $userData = [
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono_usuario,
            'actualizado_en' => now(),
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $administradore->usuario->update($userData);

        // Actualizar datos del administrador
        $administradore->update([
            'cargo' => $request->cargo,
            'telefono' => $request->telefono_admin,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('administradores.index')->with('success', 'Administrador actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Administrador $administradore)
    {
        // Eliminar el administrador y el usuario asociado
        $administradore->usuario->delete(); // Esto también eliminará el administrador por CASCADE
        
        return redirect()->route('administradores.index')->with('success', 'Administrador eliminado exitosamente.');
    }
}