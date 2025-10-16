<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use App\Models\Role;
use App\Models\Seccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EstudiantesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function perfil($id)
    {
        $user = Auth::user();

    Log::info('Accediendo al perfil del estudiante.', [
        'user_id' => $user->id,
        'user_name' => $user->name,
        'user_role' => $user->role->nombre ?? 'Sin rol',
        'requested_id' => $id,
    ]);
        // Buscar el estudiante con sus relaciones
        $estudiante = Estudiante::with(['usuario', 'seccion'])->findOrFail($id);

        // Retornar la vista con los datos del estudiante
        return view('colegio.estudiante.perfil', compact('estudiante'));
    }
    public function index(Request $request)
    {
        $query = Estudiante::with(['usuario', 'seccion'])->paginate(20); // 20 estudiantes por página
        // Filtros
        if ($request->filled('seccion_id')) {
            $query->where('seccion_id', $request->seccion_id);
        }

        if ($request->filled('nivel_socioeconomico')) {
            $query->where('nivel_socioeconomico', $request->nivel_socioeconomico);
        }

        if ($request->filled('motivacion')) {
            $query->where('motivacion', $request->motivacion);
        }

        if ($request->filled('vive_con')) {
            $query->where('vive_con', $request->vive_con);
        }

        $estudiantes = $query->paginate(10);

        // Para los filtros en la vista - Sin usar scope activas()
        $secciones = Seccion::orderBy('grado')->orderBy('nombre')->get();

        return view('colegio.estudiantes.index', compact('estudiantes', 'secciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secciones = Seccion::orderBy('grado')->orderBy('nombre')->get();
        return view('colegio.estudiantes.create', compact('secciones'));
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
            'email' => 'nullable|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'telefono_usuario' => 'nullable|string|max:30',
            'seccion_id' => 'nullable|exists:secciones,id',
            'padres_divorciados' => 'boolean',
            'promedio_anterior' => 'nullable|numeric|min:0|max:20',
            'faltas' => 'integer|min:0',
            'horas_estudio_semanal' => 'integer|min:0|max:168',
            'participacion_clases' => 'nullable|integer|min:1|max:10',
            'nivel_socioeconomico' => 'required|in:bajo,medio,alto',
            'vive_con' => 'required|in:padres,madre,padre,otros',
            'internet_en_casa' => 'boolean',
            'dispositivo_propio' => 'boolean',
            'motivacion' => 'required|in:Alta,Media,Baja',
        ]);

        // Obtener el rol de estudiante
        $estudianteRole = Role::where('nombre', 'Estudiante')->first();

        // Crear el usuario
        $usuario = User::create([
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol_id' => $estudianteRole->id,
            'telefono' => $request->telefono_usuario,
            'creado_en' => now(),
        ]);

        // Crear el estudiante
        Estudiante::create([
            'usuario_id' => $usuario->id,
            'seccion_id' => $request->seccion_id,
            'padres_divorciados' => $request->boolean('padres_divorciados'),
            'promedio_anterior' => $request->promedio_anterior,
            'faltas' => $request->faltas ?? 0,
            'horas_estudio_semanal' => $request->horas_estudio_semanal ?? 0,
            'participacion_clases' => $request->participacion_clases,
            'nivel_socioeconomico' => $request->nivel_socioeconomico,
            'vive_con' => $request->vive_con,
            'internet_en_casa' => $request->boolean('internet_en_casa'),
            'dispositivo_propio' => $request->boolean('dispositivo_propio'),
            'motivacion' => $request->motivacion,
        ]);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estudiante $estudiante)
    {
        return view('colegio.estudiantes.show', compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estudiante $estudiante)
    {
        $secciones = Seccion::orderBy('grado')->orderBy('nombre')->get();
        return view('colegio.estudiantes.edit', compact('estudiante', 'secciones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'dni' => 'required|string|max:12|unique:users,dni,' . $estudiante->usuario->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'email' => 'nullable|email|max:255|unique:users,email,' . $estudiante->usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'telefono_usuario' => 'nullable|string|max:30',
            'seccion_id' => 'nullable|exists:secciones,id',
            'padres_divorciados' => 'boolean',
            'promedio_anterior' => 'nullable|numeric|min:0|max:20',
            'faltas' => 'integer|min:0',
            'horas_estudio_semanal' => 'integer|min:0|max:168',
            'participacion_clases' => 'nullable|integer|min:1|max:10',
            'nivel_socioeconomico' => 'required|in:bajo,medio,alto',
            'vive_con' => 'required|in:padres,madre,padre,otros',
            'internet_en_casa' => 'boolean',
            'dispositivo_propio' => 'boolean',
            'motivacion' => 'required|in:Alta,Media,Baja',
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

        $estudiante->usuario->update($userData);

        // Actualizar datos del estudiante
        $estudiante->update([
            'seccion_id' => $request->seccion_id,
            'padres_divorciados' => $request->boolean('padres_divorciados'),
            'promedio_anterior' => $request->promedio_anterior,
            'faltas' => $request->faltas ?? 0,
            'horas_estudio_semanal' => $request->horas_estudio_semanal ?? 0,
            'participacion_clases' => $request->participacion_clases,
            'nivel_socioeconomico' => $request->nivel_socioeconomico,
            'vive_con' => $request->vive_con,
            'internet_en_casa' => $request->boolean('internet_en_casa'),
            'dispositivo_propio' => $request->boolean('dispositivo_propio'),
            'motivacion' => $request->motivacion,
        ]);

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estudiante $estudiante)
    {
        // Eliminar el estudiante y el usuario asociado
        $estudiante->usuario->delete(); // Esto también eliminará el estudiante por CASCADE

        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado exitosamente.');
    }

    /**
     * Mostrar estadísticas de estudiantes
     */
    public function estadisticas()
    {
        $estadisticas = [
            'total_estudiantes' => Estudiante::count(),
            'por_nivel_socioeconomico' => Estudiante::selectRaw('nivel_socioeconomico, count(*) as total')
                ->groupBy('nivel_socioeconomico')
                ->pluck('total', 'nivel_socioeconomico'),
            'por_motivacion' => Estudiante::selectRaw('motivacion, count(*) as total')
                ->groupBy('motivacion')
                ->pluck('total', 'motivacion'),
            'con_recursos_completos' => Estudiante::conRecursosCompletos()->count(),
            'con_dificultades' => Estudiante::conDificultadesSocioeconomicas()->count(),
            'problemas_familiares' => Estudiante::conProblemasFamiliares()->count(),
            'promedio_horas_estudio' => Estudiante::avg('horas_estudio_semanal'),
            'promedio_faltas' => Estudiante::avg('faltas'),
        ];

        return view('colegio.estudiantes.estadisticas', compact('estadisticas'));
    }
}
