<?php
namespace App\Http\Controllers;

use App\Models\PrediccionRendimiento;
use App\Models\RecomendacionIA;
use App\Models\Estudiante;
use App\Models\Nota;
use App\Models\Asistencia;
use App\Models\RecursoEducativo;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PrediccionesController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        $predicciones = PrediccionRendimiento::with(['estudiante.usuario', 'estudiante.seccion'])
            ->orderBy('fecha_prediccion', 'desc')
            ->paginate(15);

        return view('colegio.predicciones.index', compact('predicciones'));
    }

    public function seleccionar()
    {
        $estudiantes = Estudiante::with(['usuario', 'seccion', 'notas.curso', 'predicciones'])
            ->has('notas')
            ->get();

        return view('colegio.predicciones.seleccionar', compact('estudiantes'));
    }

    public function generar(Request $request, $estudianteId)
    {
        
            // Agrega esto al inicio del método para debug
            Log::info('🎯 MÉTODO GENERAR EJECUTADO', [
                'request_all' => $request->all(),
                'estudiante_id' => $estudianteId,
                'method' => $request->method(),
                'url' => $request->url()
            ]);


        DB::beginTransaction();
        
        try {
            $estudiante = Estudiante::with(['usuario', 'seccion', 'notas.curso', 'asistencias'])
                ->findOrFail($estudianteId);

            Log::info('=== INICIANDO GENERACIÓN DE PREDICCIÓN ===', [
                'estudiante_id' => $estudianteId,
                'estudiante_nombre' => $estudiante->usuario->name
            ]);

            if ($estudiante->notas->isEmpty()) {
                return redirect()->back()->with('error', 'El estudiante no tiene notas registradas.');
            }

            $datosEstudiante = $this->prepararDatosEstudiante($estudiante);
            
            Log::info('Llamando a Gemini Service...');
            $tiempoInicio = microtime(true);
            
            $prediccionIA = $this->geminiService->generarPrediccion($datosEstudiante);
            
            $tiempoFin = microtime(true);
            $tiempoGeneracion = round($tiempoFin - $tiempoInicio, 2);
            
            Log::info('Respuesta de IA recibida', [
                'probabilidad' => $prediccionIA['probabilidad_aprobar'] ?? 'N/A',
                'tiempo_generacion' => $tiempoGeneracion . 's',
                'tiene_analisis' => !empty($prediccionIA['analisis']),
            ]);

            // Guardar predicción principal
            $prediccion = PrediccionRendimiento::create([
                'estudiante_id' => $estudiante->id,
                'fecha_prediccion' => now(),
                'probabilidad_aprobar' => $prediccionIA['probabilidad_aprobar'],
                'prediccion_binaria' => $prediccionIA['prediccion_binaria'],
                'nivel_riesgo' => $prediccionIA['nivel_riesgo'],
                'analisis' => $prediccionIA['analisis'],
                'fortalezas' => $prediccionIA['fortalezas'],
                'debilidades' => $prediccionIA['debilidades'],
                'recomendaciones_generales' => $prediccionIA['recomendaciones_generales'],
                'recursos_recomendados' => $prediccionIA['recursos_recomendados'],
                'cursos_criticos' => $prediccionIA['cursos_criticos'],
                'plan_mejora' => $prediccionIA['plan_mejora'],
                'metadatos' => [
                    'version' => '1.0',
                    'timestamp' => now()->toIso8601String(),
                    'cursos_evaluados' => $estudiante->notas->count(),
                    'promedio_general' => round($estudiante->notas->avg('promedio_final'), 2),
                    'tiempo_generacion_segundos' => $tiempoGeneracion,
                    'servicio_ia' => 'Gemini API',
                ]
            ]);

            // Crear recomendaciones detalladas
            $this->crearRecomendacionesDetalladas($prediccion, $prediccionIA, $estudiante);

            DB::commit();

            Log::info('✅ Predicción y recomendaciones guardadas exitosamente', [
                'prediccion_id' => $prediccion->id,
                'recomendaciones_creadas' => $prediccion->recomendaciones()->count()
            ]);

            return redirect()
                ->route('predicciones.show', $prediccion->id)
                ->with('success', 'Predicción generada exitosamente con IA.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('❌ Error al generar predicción', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error al generar predicción: ' . $e->getMessage());
        }
    }

    public function generarTodas(Request $request)
    {
        try {
            $estudiantes = Estudiante::with(['usuario', 'seccion', 'notas.curso', 'asistencias'])
                ->has('notas')
                ->get();

            $generadas = 0;
            $errores = 0;

            foreach ($estudiantes as $estudiante) {
                try {
                    DB::beginTransaction();

                    $datosEstudiante = $this->prepararDatosEstudiante($estudiante);
                    $prediccionIA = $this->geminiService->generarPrediccion($datosEstudiante);

                    $prediccion = PrediccionRendimiento::create([
                        'estudiante_id' => $estudiante->id,
                        'fecha_prediccion' => now(),
                        'probabilidad_aprobar' => $prediccionIA['probabilidad_aprobar'],
                        'prediccion_binaria' => $prediccionIA['prediccion_binaria'],
                        'nivel_riesgo' => $prediccionIA['nivel_riesgo'],
                        'analisis' => $prediccionIA['analisis'],
                        'fortalezas' => $prediccionIA['fortalezas'],
                        'debilidades' => $prediccionIA['debilidades'],
                        'recomendaciones_generales' => $prediccionIA['recomendaciones_generales'],
                        'recursos_recomendados' => $prediccionIA['recursos_recomendados'],
                        'cursos_criticos' => $prediccionIA['cursos_criticos'],
                        'plan_mejora' => $prediccionIA['plan_mejora'],
                        'metadatos' => [
                            'version' => '1.0',
                            'timestamp' => now()->toIso8601String(),
                            'generacion_masiva' => true,
                        ]
                    ]);

                    $this->crearRecomendacionesDetalladas($prediccion, $prediccionIA, $estudiante);

                    DB::commit();
                    $generadas++;
                    
                    // Pausa para no saturar la API
                    sleep(2);

                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('Error generando predicción para estudiante', [
                        'estudiante_id' => $estudiante->id,
                        'error' => $e->getMessage()
                    ]);
                    $errores++;
                }
            }

            return redirect()
                ->route('predicciones.index')
                ->with('success', "Se generaron {$generadas} predicciones exitosamente. Errores: {$errores}");

        } catch (\Exception $e) {
            Log::error('Error en generación masiva', [
                'error' => $e->getMessage()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    protected function crearRecomendacionesDetalladas($prediccion, $prediccionIA, $estudiante)
    {
        // 1. Recomendaciones por recursos educativos
        if (!empty($prediccionIA['recursos_recomendados'])) {
            foreach ($prediccionIA['recursos_recomendados'] as $recursoRec) {
                $curso = \App\Models\Curso::where('nombre', $recursoRec['curso'])->first();
                $recurso = null;
                
                if ($curso) {
                    $recurso = RecursoEducativo::where('curso_id', $curso->id)
                        ->where('titulo', 'LIKE', '%' . $recursoRec['recurso'] . '%')
                        ->first();
                }

                RecomendacionIA::create([
                    'prediccion_id' => $prediccion->id,
                    'tipo' => RecomendacionIA::TIPO_RECURSO,
                    'prioridad' => 'alta',
                    'titulo' => 'Recurso recomendado: ' . $recursoRec['recurso'],
                    'descripcion' => $recursoRec['razon'],
                    'curso_id' => $curso?->id,
                    'recurso_educativo_id' => $recurso?->id,
                    'dirigida_a' => 'estudiante',
                    'creado_por' => 'IA',
                    'metadatos' => $recursoRec,
                ]);
            }
        }

        // 2. Recomendaciones por cursos críticos
        if (!empty($prediccionIA['cursos_criticos'])) {
            foreach ($prediccionIA['cursos_criticos'] as $cursoCritico) {
                $curso = \App\Models\Curso::where('nombre', $cursoCritico)->first();

                RecomendacionIA::create([
                    'prediccion_id' => $prediccion->id,
                    'tipo' => RecomendacionIA::TIPO_REFUERZO,
                    'prioridad' => 'urgente',
                    'titulo' => 'Refuerzo urgente en ' . $cursoCritico,
                    'descripcion' => 'Este curso requiere atención inmediata debido al bajo rendimiento detectado.',
                    'curso_id' => $curso?->id,
                    'acciones_sugeridas' => [
                        'Programar sesiones de refuerzo',
                        'Asignar tutor especializado',
                        'Revisar material educativo',
                        'Evaluación diagnóstica'
                    ],
                    'dirigida_a' => 'docente',
                    'creado_por' => 'IA',
                ]);
            }
        }

        // 3. Recomendaciones generales
        if (!empty($prediccionIA['recomendaciones_generales'])) {
            foreach ($prediccionIA['recomendaciones_generales'] as $index => $recomendacion) {
                RecomendacionIA::create([
                    'prediccion_id' => $prediccion->id,
                    'tipo' => RecomendacionIA::TIPO_METODOLOGICA,
                    'prioridad' => 'media',
                    'titulo' => 'Recomendación ' . ($index + 1),
                    'descripcion' => $recomendacion,
                    'dirigida_a' => 'estudiante',
                    'creado_por' => 'IA',
                ]);
            }
        }

        // 4. Recomendación de tutoría si el riesgo es alto
        if ($prediccion->nivel_riesgo === 'Alto') {
            RecomendacionIA::create([
                'prediccion_id' => $prediccion->id,
                'tipo' => RecomendacionIA::TIPO_TUTORIA,
                'prioridad' => 'urgente',
                'titulo' => 'Tutoría urgente requerida',
                'descripcion' => 'Debido al alto riesgo académico detectado, se requiere intervención inmediata del tutor académico para diseñar un plan de recuperación.',
                'acciones_sugeridas' => [
                    'Reunión con tutor en máximo 48 horas',
                    'Comunicar a los padres de familia',
                    'Evaluar posibles causas externas',
                    'Diseñar plan de recuperación personalizado'
                ],
                'dirigida_a' => 'tutor',
                'creado_por' => 'IA',
            ]);
        }
    }

    protected function prepararDatosEstudiante(Estudiante $estudiante): array
    {
        // Información del estudiante
        $datosEstudiante = [
            'nombre' => $estudiante->usuario->name,
            'seccion' => $estudiante->seccion->nombre_completo ?? 'Sin sección',
            'promedio_anterior' => $estudiante->promedio_anterior ?? null,
            'motivacion' => $estudiante->motivacion ?? null,
        ];

        // Notas por curso
        $notas = $estudiante->notas->map(function ($nota) {
            return [
                'curso' => $nota->curso->nombre ?? 'Curso sin nombre',
                'bimestre1' => $nota->bimestre1,
                'bimestre2' => $nota->bimestre2,
                'bimestre3' => $nota->bimestre3,
                'bimestre4' => $nota->bimestre4,
                'promedio_final' => $nota->promedio_final,
            ];
        })->toArray();

        // Asistencias
        $totalAsistencias = $estudiante->asistencias->count();
        $asistenciasPresentes = $estudiante->asistencias->where('presente', true)->count();
        $porcentajeAsistencia = $totalAsistencias > 0 
            ? round(($asistenciasPresentes / $totalAsistencias) * 100, 2)
            : 0;

        $asistencias = [
            'total' => $totalAsistencias,
            'presentes' => $asistenciasPresentes,
            'ausentes' => $totalAsistencias - $asistenciasPresentes,
            'porcentaje' => $porcentajeAsistencia,
        ];

        // Recursos educativos disponibles
        $cursosIds = $estudiante->notas->pluck('curso_id')->unique();
        $recursos = RecursoEducativo::whereIn('curso_id', $cursosIds)
            ->with('curso')
            ->get()
            ->map(function ($recurso) {
                return [
                    'curso' => $recurso->curso->nombre ?? 'N/A',
                    'titulo' => $recurso->titulo,
                    'tipo' => $recurso->tipo,
                    'descripcion' => $recurso->descripcion,
                ];
            })
            ->toArray();

        return [
            'estudiante' => $datosEstudiante,
            'notas' => $notas,
            'asistencias' => $asistencias,
            'recursos' => $recursos,
        ];
    }

    public function show($id)
    {
        $prediccion = PrediccionRendimiento::with([
            'estudiante.usuario',
            'estudiante.seccion',
            'estudiante.notas.curso',
            'recomendaciones.curso',
            'recomendaciones.recursoEducativo'
        ])->findOrFail($id);

        return view('colegio.predicciones.show', compact('prediccion'));
    }

    public function destroy($id)
    {
        try {
            $prediccion = PrediccionRendimiento::findOrFail($id);
            $prediccion->delete();

            return redirect()
                ->route('predicciones.index')
                ->with('success', 'Predicción eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}