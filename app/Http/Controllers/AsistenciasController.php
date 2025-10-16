<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Estudiante;
use App\Models\Curso;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciasController extends Controller
{
    /**
     * Mostrar listado de asistencias
     */
    public function index(Request $request)
    {
        $query = Asistencia::with(['estudiante.usuario', 'curso']);

        // Filtro por fecha
        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        } else {
            // Por defecto mostrar la fecha de hoy
            $query->whereDate('fecha', today());
        }

        // Filtro por curso
        if ($request->filled('curso_id')) {
            $query->where('curso_id', $request->curso_id);
        }

        // Filtro por estudiante
        if ($request->filled('estudiante_id')) {
            $query->where('estudiante_id', $request->estudiante_id);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            if ($request->estado == 'presente') {
                $query->where('presente', true);
            } elseif ($request->estado == 'ausente') {
                $query->where('presente', false);
            }
        }

        $asistencias = $query->orderBy('fecha', 'desc')
                             ->orderBy('id', 'desc')
                             ->paginate(20);

        $cursos = Curso::all();
        $estudiantes = Estudiante::with('usuario')->get();

        return view('colegio.asistencias.index', compact('asistencias', 'cursos', 'estudiantes'));
    }

    /**
     * Vista para registrar asistencia masiva
     */
    public function registrar(Request $request)
    {
        $fecha = $request->get('fecha', today()->format('Y-m-d'));
        $cursoId = $request->get('curso_id');
        $seccionId = $request->get('seccion_id');

        $cursos = Curso::all();
        $secciones = Seccion::all();

        // Si hay curso y sección seleccionados, obtener estudiantes
        $estudiantes = null;
        if ($seccionId) {
            $estudiantes = Estudiante::with(['usuario', 'asistencias' => function($query) use ($fecha, $cursoId) {
                $query->whereDate('fecha', $fecha);
                if ($cursoId) {
                    $query->where('curso_id', $cursoId);
                }
            }])->where('seccion_id', $seccionId)->get();
        }

        return view('colegio.asistencias.registrar', compact(
            'fecha', 
            'cursoId', 
            'seccionId', 
            'cursos', 
            'secciones', 
            'estudiantes'
        ));
    }

    /**
     * Guardar asistencia masiva
     */
    public function guardarMasivo(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'curso_id' => 'nullable|exists:cursos,id',
            'asistencias' => 'required|array',
            'asistencias.*.estudiante_id' => 'required|exists:estudiantes,id',
            'asistencias.*.presente' => 'required|boolean',
            'asistencias.*.observacion' => 'nullable|string|max:255',
        ]);

        $registrados = 0;
        $actualizados = 0;

        foreach ($validated['asistencias'] as $asistenciaData) {
            $existe = Asistencia::where('estudiante_id', $asistenciaData['estudiante_id'])
                ->whereDate('fecha', $validated['fecha'])
                ->when($validated['curso_id'], function($q) use ($validated) {
                    return $q->where('curso_id', $validated['curso_id']);
                })
                ->first();

            if ($existe) {
                $existe->update([
                    'presente' => $asistenciaData['presente'],
                    'observacion' => $asistenciaData['observacion'] ?? null,
                ]);
                $actualizados++;
            } else {
                Asistencia::create([
                    'estudiante_id' => $asistenciaData['estudiante_id'],
                    'curso_id' => $validated['curso_id'],
                    'fecha' => $validated['fecha'],
                    'presente' => $asistenciaData['presente'],
                    'observacion' => $asistenciaData['observacion'] ?? null,
                ]);
                $registrados++;
            }
        }

        return redirect()->route('asistencias.registrar', [
            'fecha' => $validated['fecha'],
            'curso_id' => $validated['curso_id'],
            'seccion_id' => $request->seccion_id
        ])->with('success', "Asistencias guardadas: {$registrados} nuevas, {$actualizados} actualizadas");
    }

    /**
     * Formulario de creación individual
     */
    public function create()
    {
        $estudiantes = Estudiante::with('usuario')->get();
        $cursos = Curso::all();
        
        return view('colegio.asistencias.create', compact('estudiantes', 'cursos'));
    }

    /**
     * Guardar asistencia individual
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id' => 'nullable|exists:cursos,id',
            'fecha' => 'required|date',
            'presente' => 'required|boolean',
            'observacion' => 'nullable|string|max:255',
        ]);

        Asistencia::create($validated);

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia registrada exitosamente');
    }

    /**
     * Editar asistencia
     */
    public function edit(Asistencia $asistencia)
    {
        $estudiantes = Estudiante::with('usuario')->get();
        $cursos = Curso::all();
        
        return view('colegio.asistencias.edit', compact('asistencia', 'estudiantes', 'cursos'));
    }

    /**
     * Actualizar asistencia
     */
    public function update(Request $request, Asistencia $asistencia)
    {
        $validated = $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'curso_id' => 'nullable|exists:cursos,id',
            'fecha' => 'required|date',
            'presente' => 'required|boolean',
            'observacion' => 'nullable|string|max:255',
        ]);

        $asistencia->update($validated);

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia actualizada exitosamente');
    }

    /**
     * Eliminar asistencia
     */
    public function destroy(Asistencia $asistencia)
    {
        $asistencia->delete();

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia eliminada exitosamente');
    }

    /**
     * Reporte de asistencias por estudiante
     */
    public function porEstudiante($estudianteId)
    {
        $estudiante = Estudiante::with('usuario')->findOrFail($estudianteId);
        
        $asistencias = Asistencia::with('curso')
            ->where('estudiante_id', $estudianteId)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalAsistencias = $asistencias->count();
        $presentes = $asistencias->where('presente', true)->count();
        $ausentes = $asistencias->where('presente', false)->count();
        $porcentajeAsistencia = $totalAsistencias > 0 
            ? round(($presentes / $totalAsistencias) * 100, 2) 
            : 0;

        return view('colegio.asistencias.por-estudiante', compact(
            'estudiante',
            'asistencias',
            'totalAsistencias',
            'presentes',
            'ausentes',
            'porcentajeAsistencia'
        ));
    }

    /**
     * Reporte de asistencias por curso
     */
    public function porCurso(Request $request, $cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        
        $fecha = $request->get('fecha', today()->format('Y-m-d'));
        
        $asistencias = Asistencia::with('estudiante.usuario')
            ->where('curso_id', $cursoId)
            ->whereDate('fecha', $fecha)
            ->get();

        return view('colegio.asistencias.por-curso', compact('curso', 'asistencias', 'fecha'));
    }

    /**
     * Reporte mensual
     */
    public function reporteMensual(Request $request)
    {
        $mes = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);

        $asistencias = Asistencia::with(['estudiante.usuario', 'curso'])
            ->whereMonth('fecha', $mes)
            ->whereYear('fecha', $anio)
            ->get();

        $totalRegistros = $asistencias->count();
        $presentes = $asistencias->where('presente', true)->count();
        $ausentes = $asistencias->where('presente', false)->count();
        $porcentajeAsistencia = $totalRegistros > 0 
            ? round(($presentes / $totalRegistros) * 100, 2) 
            : 0;

        return view('colegio.asistencias.reporte-mensual', compact(
            'mes',
            'anio',
            'asistencias',
            'totalRegistros',
            'presentes',
            'ausentes',
            'porcentajeAsistencia'
        ));
    }
}