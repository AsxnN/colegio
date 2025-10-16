<?php

namespace App\Http\Controllers;

use App\Models\RecursoEducativo;
use App\Models\Curso;
use Illuminate\Http\Request;

class RecursosEducativosController extends Controller
{
    /**
     * Mostrar listado de recursos educativos
     */
    public function index(Request $request)
    {
        $query = RecursoEducativo::with('curso');

        // Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Búsqueda por título
        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        $recursos = $query->orderBy('created_at', 'desc')
                          ->paginate(15);

        $cursos = Curso::all();
        $tipos = ['video', 'pdf', 'link', 'otro'];

        return view('colegio.recursos.index', compact('recursos', 'cursos', 'tipos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $cursos = Curso::all();
        $tipos = [
            'video' => 'Video',
            'pdf' => 'PDF',
            'link' => 'Enlace',
            'otro' => 'Otro',
        ];

        return view('colegio.recursos.create', compact('cursos', 'tipos'));
    }

    /**
     * Guardar nuevo recurso
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'titulo' => 'required|string|max:200',
            'tipo' => 'required|in:video,pdf,link,otro',
            'url' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        RecursoEducativo::create($validated);

        return redirect()->route('recursos.index')
            ->with('success', 'Recurso educativo creado exitosamente');
    }

    /**
     * Mostrar un recurso específico
     */
    public function show(RecursoEducativo $recurso)
    {
        $recurso->load('curso');
        return view('colegio.recursos.show', compact('recurso'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(RecursoEducativo $recurso)
    {
        $cursos = Curso::all();
        $tipos = [
            'video' => 'Video',
            'pdf' => 'PDF',
            'link' => 'Enlace',
            'otro' => 'Otro',
        ];

        return view('colegio.recursos.edit', compact('recurso', 'cursos', 'tipos'));
    }

    /**
     * Actualizar recurso
     */
    public function update(Request $request, RecursoEducativo $recurso)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'titulo' => 'required|string|max:200',
            'tipo' => 'required|in:video,pdf,link,otro',
            'url' => 'nullable|string',
            'descripcion' => 'nullable|string',
        ]);

        $recurso->update($validated);

        return redirect()->route('recursos.index')
            ->with('success', 'Recurso educativo actualizado exitosamente');
    }

    /**
     * Eliminar recurso
     */
    public function destroy(RecursoEducativo $recurso)
    {
        $recurso->delete();

        return redirect()->route('recursos.index')
            ->with('success', 'Recurso educativo eliminado exitosamente');
    }

    /**
     * Recursos por curso
     */
    public function porCurso($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $recursos = RecursoEducativo::where('curso_id', $cursoId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('colegio.recursos.por-curso', compact('curso', 'recursos'));
    }
}