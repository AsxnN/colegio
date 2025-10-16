<?php

namespace App\Http\Controllers;

use App\Models\Seccion;
use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Seccion::withCount('estudiantes');

        // Filtros
        if ($request->filled('grado')) {
            $query->where('grado', $request->grado);
        }

        $secciones = $query->orderBy('grado')
                          ->orderBy('nombre')
                          ->paginate(10);

        // Obtener todos los grados únicos para el filtro
        $grados = Seccion::whereNotNull('grado')
                         ->distinct()
                         ->orderBy('grado')
                         ->pluck('grado');

        return view('colegio.secciones.index', compact('secciones', 'grados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colegio.secciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'grado' => 'nullable|string|max:50',
        ]);

        Seccion::create([
            'nombre' => $request->nombre,
            'grado' => $request->grado,
        ]);

        return redirect()->route('secciones.index')->with('success', 'Sección creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Seccion $seccione)
    {
        $seccion = $seccione;
        $seccion->load('estudiantes.usuario');
        return view('colegio.secciones.show', compact('seccion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Seccion $seccione)
    {
        $seccion = $seccione;
        return view('colegio.secciones.edit', compact('seccion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seccion $seccione)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'grado' => 'nullable|string|max:50',
        ]);

        $seccione->update([
            'nombre' => $request->nombre,
            'grado' => $request->grado,
        ]);

        return redirect()->route('secciones.index')->with('success', 'Sección actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seccion $seccione)
    {
        if (!$seccione->puedeEliminar()) {
            return redirect()->route('secciones.index')->with('error', 'No se puede eliminar la sección porque tiene estudiantes asignados.');
        }

        $seccione->delete();
        return redirect()->route('secciones.index')->with('success', 'Sección eliminada exitosamente.');
    }

    /**
     * Mostrar estudiantes de una sección
     */
    public function estudiantes(Seccion $seccione)
    {
        $seccion = $seccione;
        $seccion->load('estudiantes.usuario');
        
        // Obtener estudiantes sin sección asignada
        $estudiantesSinSeccion = Estudiante::whereNull('seccion_id')
                                          ->with('usuario')
                                          ->get();

        return view('colegio.secciones.estudiantes', compact('seccion', 'estudiantesSinSeccion'));
    }

    /**
     * Asignar estudiante a sección
     */
    public function asignarEstudiante(Request $request, Seccion $seccione)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
        ]);

        $estudiante = Estudiante::find($request->estudiante_id);
        
        if ($estudiante->seccion_id) {
            return redirect()->back()->with('error', 'El estudiante ya tiene una sección asignada.');
        }

        $estudiante->update([
            'seccion_id' => $seccione->id,
        ]);

        return redirect()->back()->with('success', 'Estudiante asignado a la sección exitosamente.');
    }

    /**
     * Remover estudiante de sección
     */
    public function removerEstudiante(Request $request, Seccion $seccione)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
        ]);

        $estudiante = Estudiante::find($request->estudiante_id);
        
        if ($estudiante->seccion_id != $seccione->id) {
            return redirect()->back()->with('error', 'El estudiante no pertenece a esta sección.');
        }

        $estudiante->update([
            'seccion_id' => null,
        ]);

        return redirect()->back()->with('success', 'Estudiante removido de la sección exitosamente.');
    }

    /**
     * Transferir estudiante a otra sección
     */
    public function transferirEstudiante(Request $request, Seccion $seccione)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'nueva_seccion_id' => 'required|exists:secciones,id',
        ]);

        $estudiante = Estudiante::find($request->estudiante_id);
        $nuevaSeccion = Seccion::find($request->nueva_seccion_id);

        if ($estudiante->seccion_id != $seccione->id) {
            return redirect()->back()->with('error', 'El estudiante no pertenece a esta sección.');
        }

        $estudiante->update([
            'seccion_id' => $request->nueva_seccion_id,
        ]);

        return redirect()->back()->with('success', 
            "Estudiante transferido a {$nuevaSeccion->nombre_completo} exitosamente."
        );
    }
}