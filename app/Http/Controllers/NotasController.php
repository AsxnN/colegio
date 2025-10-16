<?php
namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Estudiante;
use App\Models\Curso;
use Illuminate\Http\Request;

class NotasController extends Controller
{
    /**
     * Mostrar listado de notas
     */
    public function index(Request $request)
    {
        $query = Nota::with(['estudiante.usuario', 'curso']);

        // Filtro por estudiante
        if ($request->filled('estudiante_id')) {
            $query->where('estudiante_id', $request->estudiante_id);
        }

        // Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            if ($request->estado == 'aprobado') {
                $query->where('promedio_final', '>=', 14);
            } elseif ($request->estado == 'desaprobado') {
                $query->where('promedio_final', '<', 14)->whereNotNull('promedio_final');
            } elseif ($request->estado == 'sin_calificar') {
                $query->whereNull('promedio_final');
            }
        }

        $notas = $query->latest()->paginate(15);
        $estudiantes = Estudiante::with('usuario')->get();
        $cursos = Curso::all();

        return view('colegio.notas.index', compact('notas', 'estudiantes', 'cursos'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $estudiantes = Estudiante::with('usuario')->get();
        $cursos = Curso::all();
        
        return view('colegio.notas.create', compact('estudiantes', 'cursos'));
    }

    /**
     * Guardar nueva nota
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id' => 'required|exists:cursos,id|unique:notas,curso_id,NULL,id,estudiante_id,' . $request->estudiante_id,
            'bimestre1' => 'nullable|numeric|min:0|max:20',
            'bimestre2' => 'nullable|numeric|min:0|max:20',
            'bimestre3' => 'nullable|numeric|min:0|max:20',
            'bimestre4' => 'nullable|numeric|min:0|max:20',
        ], [
            'curso_id.unique' => 'Ya existe un registro de notas para este estudiante y curso.'
        ]);

        $nota = Nota::create($validated);
        $nota->calcularPromedio();

        return redirect()->route('notas.index')
            ->with('success', 'Nota registrada exitosamente');
    }

    /**
     * Mostrar detalles de la nota
     */
    public function show(Nota $nota)
    {
        $nota->load(['estudiante.usuario', 'curso.docente.usuario']);
        
        return view('colegio.notas.show', compact('nota'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Nota $nota)
    {
        $estudiantes = Estudiante::with('usuario')->get();
        $cursos = Curso::all();
        
        return view('colegio.notas.edit', compact('nota', 'estudiantes', 'cursos'));
    }

    /**
     * Actualizar nota
     */
    public function update(Request $request, Nota $nota)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id' => 'required|exists:cursos,id|unique:notas,curso_id,' . $nota->id . ',id,estudiante_id,' . $request->estudiante_id,
            'bimestre1' => 'nullable|numeric|min:0|max:20',
            'bimestre2' => 'nullable|numeric|min:0|max:20',
            'bimestre3' => 'nullable|numeric|min:0|max:20',
            'bimestre4' => 'nullable|numeric|min:0|max:20',
        ]);

        $nota->update($validated);
        $nota->calcularPromedio();

        return redirect()->route('notas.index')
            ->with('success', 'Nota actualizada exitosamente');
    }

    /**
     * Eliminar nota
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();

        return redirect()->route('notas.index')
            ->with('success', 'Nota eliminada exitosamente');
    }

    /**
     * Ver notas por estudiante
     */
    public function porEstudiante($estudianteId)
    {
        $estudiante = Estudiante::with('usuario')->findOrFail($estudianteId);
        $notas = Nota::with('curso')->where('estudiante_id', $estudianteId)->get();
        
        return view('colegio.notas.por-estudiante', compact('estudiante', 'notas'));
    }

    /**
     * Ver notas por curso
     */
    public function porCurso($cursoId)
    {
        $curso = Curso::with('docente.usuario')->findOrFail($cursoId);
        $notas = Nota::with('estudiante.usuario')->where('curso_id', $cursoId)->get();
        
        return view('colegio.notas.por-curso', compact('curso', 'notas'));
    }
}