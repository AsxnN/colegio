<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\SeccionesController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\AsistenciasController;
use App\Http\Controllers\RecursosEducativosController;
use App\Http\Controllers\PrediccionesController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['role:administrador'])->group(function () {

    // Rutas para el módulo de usuarios
    Route::resource('usuarios', UsersController::class);

    // Rutas para el módulo de administradores
    Route::resource('administradores', AdministradoresController::class);

    // Rutas para el módulo de docentes
    Route::resource('docentes', DocentesController::class);

    // Rutas para el módulo de estudiantes
    Route::resource('estudiantes', EstudiantesController::class);
    Route::get('/estudiantes-estadisticas', [EstudiantesController::class, 'estadisticas'])->name('estudiantes.estadisticas');

    // Rutas para el módulo de secciones
    Route::resource('secciones', SeccionesController::class);
    Route::get('/secciones/{seccione}/estudiantes', [SeccionesController::class, 'estudiantes'])->name('secciones.estudiantes');
    Route::post('/secciones/{seccione}/asignar-estudiante', [SeccionesController::class, 'asignarEstudiante'])->name('secciones.asignar-estudiante');
    Route::delete('/secciones/{seccione}/remover-estudiante', [SeccionesController::class, 'removerEstudiante'])->name('secciones.remover-estudiante');
    Route::put('/secciones/{seccione}/transferir-estudiante', [SeccionesController::class, 'transferirEstudiante'])->name('secciones.transferir-estudiante');
    });

    // Rutas para el estudiante
    Route::middleware(['role:estudiante'])->group(function () {
        Route::get('/estudiantes/{id}/perfil', [EstudiantesController::class, 'perfil'])->name('estudiante.perfil');
        Route::get('/estudiantes/{id}/cursos', [EstudiantesController::class, 'cursos'])->name('estudiante.cursos');
        Route::get('/estudiantes/{id}/notas', [EstudiantesController::class, 'notas'])->name('estudiante.notas');
        Route::get('/estudiantes/{id}/predicciones', [EstudiantesController::class, 'predicciones'])->name('estudiante.predicciones');
        Route::get('/estudiantes/{id}/recomendaciones', [EstudiantesController::class, 'recomendaciones'])->name('estudiante.recomendaciones');
        Route::get('/estudiantes/{id}/recursos', [EstudiantesController::class, 'recursos'])->name('estudiante.recursos');
    });

    // Rutas para el módulo de cursos
    Route::resource('cursos', CursosController::class);

    // Rutas para el módulo de notas
    Route::resource('notas', NotasController::class);
    Route::get('/notas/estudiante/{estudiante}', [NotasController::class, 'porEstudiante'])->name('notas.por-estudiante');
    Route::get('/notas/curso/{curso}', [NotasController::class, 'porCurso'])->name('notas.por-curso');

    // Rutas para el módulo de asistencias
    Route::get('/asistencias', [AsistenciasController::class, 'index'])->name('asistencias.index');
    Route::get('/asistencias/registrar', [AsistenciasController::class, 'registrar'])->name('asistencias.registrar');
    Route::post('/asistencias/guardar-masivo', [AsistenciasController::class, 'guardarMasivo'])->name('asistencias.guardar-masivo');
    Route::get('/asistencias/create', [AsistenciasController::class, 'create'])->name('asistencias.create');
    Route::post('/asistencias', [AsistenciasController::class, 'store'])->name('asistencias.store');
    Route::get('/asistencias/{asistencia}/edit', [AsistenciasController::class, 'edit'])->name('asistencias.edit');
    Route::put('/asistencias/{asistencia}', [AsistenciasController::class, 'update'])->name('asistencias.update');
    Route::delete('/asistencias/{asistencia}', [AsistenciasController::class, 'destroy'])->name('asistencias.destroy');
    Route::get('/asistencias/estudiante/{estudiante}', [AsistenciasController::class, 'porEstudiante'])->name('asistencias.por-estudiante');
    Route::get('/asistencias/curso/{curso}', [AsistenciasController::class, 'porCurso'])->name('asistencias.por-curso');
    Route::get('/asistencias/reporte-mensual', [AsistenciasController::class, 'reporteMensual'])->name('asistencias.reporte-mensual');

    // Rutas para el módulo de recursos educativos
    Route::resource('recursos', RecursosEducativosController::class)->names('recursos');
    Route::get('/recursos/curso/{curso}', [RecursosEducativosController::class, 'porCurso'])->name('recursos.por-curso');

    // Rutas para el módulo de predicciones
    Route::prefix('predicciones')->name('predicciones.')->group(function () {
        Route::get('/', [PrediccionesController::class, 'index'])->name('index');
        Route::get('/seleccionar', [PrediccionesController::class, 'seleccionar'])->name('seleccionar');
        Route::post('/generar/{estudiante}', [PrediccionesController::class, 'generar'])->name('generar');
        Route::post('/generar-todas', [PrediccionesController::class, 'generarTodas'])->name('generar-todas');
        Route::get('/{id}', [PrediccionesController::class, 'show'])->name('show');
        Route::delete('/{id}', [PrediccionesController::class, 'destroy'])->name('destroy');
    });

    
    //-----------------------------------------------------------END ADMINISTRADOR-----------------------------------------------------------------------//

    //-----------------------------------------------------------START DOCENTE-----------------------------------------------------------------------//
    //-----------------------------------------------------------END DOCENTE-----------------------------------------------------------------------//

    //-----------------------------------------------------------START ESTUDIANTE-----------------------------------------------------------------------//
    //-----------------------------------------------------------END ESTUDIANTE-----------------------------------------------------------------------//



    // Ruta para listar modelos disponibles de Gemini
    Route::get('/gemini-models', function() {
        $apiKey = config('services.gemini.api_key');
        $baseUrl = config('services.gemini.base_url');
        
        try {
            $response = Http::timeout(10)
                ->get("{$baseUrl}/models?key={$apiKey}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                // Filtrar solo modelos que soporten generateContent
                $modelos = collect($data['models'] ?? [])->filter(function($model) {
                    return in_array('generateContent', $model['supportedGenerationMethods'] ?? []);
                })->map(function($model) {
                    return [
                        'name' => $model['name'],
                        'displayName' => $model['displayName'] ?? 'N/A',
                        'description' => $model['description'] ?? 'N/A',
                    ];
                })->values();
                
                return response()->json([
                    'success' => true,
                    'total' => $modelos->count(),
                    'modelos' => $modelos
                ], 200, [], JSON_PRETTY_PRINT);
            }
            
            return response()->json([
                'success' => false,
                'error' => $response->body()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    });

    // Ruta de prueba para Gemini
    Route::get('/test-gemini', function() {
        $service = new \App\Services\GeminiService();
        
        $config = [
            'api_key_configured' => $service->verificarConfiguracion(),
            'api_key_length' => strlen(config('services.gemini.api_key')),
            'api_key_preview' => substr(config('services.gemini.api_key'), 0, 10) . '...',
        ];
        
        $testConexion = $service->testConexion();
        
        return response()->json([
            'configuracion' => $config,
            'test_conexion' => $testConexion,
        ]);
    });
});
