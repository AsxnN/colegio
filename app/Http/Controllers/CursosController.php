<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente;
use Illuminate\Http\Request;

class CursosController extends Controller
{
    /**
     * Mostrar listado de cursos
     */
    public function index(Request $request)
    {
        $query = Curso::with(['docente.usuario']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        $cursos = $query->latest()->paginate(10);

        return view('colegio.cursos.index', compact('cursos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $docentes = Docente::with('usuario')->get();
        
        return view('colegio.cursos.create', compact('docentes'));
    }

    /**
     * Guardar nuevo curso
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'nullable|string|max:50|unique:cursos,codigo',
            'descripcion' => 'nullable|string',
            'docente_id' => 'nullable|exists:docentes,id',
        ]);

        Curso::create($validated);

        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado exitosamente');
    }

    /**
     * Mostrar detalles del curso
     */
    public function show(Curso $curso)
    {
        $curso->load(['docente.usuario']);
        
        return view('colegio.cursos.show', compact('curso'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Curso $curso)
    {
        $docentes = Docente::with('usuario')->get();
        
        return view('colegio.cursos.edit', compact('curso', 'docentes'));
    }

    /**
     * Actualizar curso
     */
    public function update(Request $request, Curso $curso)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'nullable|string|max:50|unique:cursos,codigo,' . $curso->id,
            'descripcion' => 'nullable|string',
            'docente_id' => 'nullable|exists:docentes,id',
        ]);

        $curso->update($validated);

        return redirect()->route('colegio.cursos.index')
            ->with('success', 'Curso actualizado exitosamente');
    }

    /**
     * Eliminar curso
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()->route('colegio.cursos.index')
            ->with('success', 'Curso eliminado exitosamente');
    }
}