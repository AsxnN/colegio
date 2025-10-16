<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $docentes = Docente::with('usuario.rol')->paginate(10);
        return view('colegio.docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colegio.docentes.create');
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
            'especialidad' => 'required|string|max:100',
            'grado_academico' => 'nullable|string|max:100',
            'telefono_docente' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:150',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo,Licencia',
        ]);

        // Obtener el rol de docente
        $docenteRole = Role::where('nombre', 'Docente')->first();

        // Crear el usuario
        $usuario = User::create([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $docenteRole->id,
            'telefono' => $request->telefono_usuario,
            'creado_en' => now(),
        ]);

        // Crear el docente
        Docente::create([
            'usuario_id' => $usuario->id,
            'especialidad' => $request->especialidad,
            'grado_academico' => $request->grado_academico,
            'telefono' => $request->telefono_docente,
            'direccion' => $request->direccion,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado' => $request->estado,
        ]);

        return redirect()->route('docentes.index')->with('success', 'Docente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Docente $docente)
    {
        return view('colegio.docentes.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Docente $docente)
    {
        return view('colegio.docentes.edit', compact('docente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            'dni' => 'required|string|max:12|unique:users,dni,' . $docente->usuario->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:users,email,' . $docente->usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'telefono_usuario' => 'nullable|string|max:30',
            'especialidad' => 'required|string|max:100',
            'grado_academico' => 'nullable|string|max:100',
            'telefono_docente' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:150',
            'fecha_ingreso' => 'required|date',
            'estado' => 'required|in:Activo,Inactivo,Licencia',
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

        $docente->usuario->update($userData);

        // Actualizar datos del docente
        $docente->update([
            'especialidad' => $request->especialidad,
            'grado_academico' => $request->grado_academico,
            'telefono' => $request->telefono_docente,
            'direccion' => $request->direccion,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado' => $request->estado,
        ]);

        return redirect()->route('docentes.index')->with('success', 'Docente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Docente $docente)
    {
        // Eliminar el docente y el usuario asociado
        $docente->usuario->delete(); // Esto también eliminará el docente por CASCADE
        
        return redirect()->route('docentes.index')->with('success', 'Docente eliminado exitosamente.');
    }
}