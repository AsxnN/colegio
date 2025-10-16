<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
use Illuminate\Support\Facades\Http;

Route::get('/', fn () => view('welcome'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Redirección por rol al entrar a /dashboard
    Route::get('/dashboard', function () {
        $u = Auth::user();
        return match ((int)($u->id_rol ?? 0)) {
            1 => redirect()->route('admin.dashboard'),
            2 => redirect()->route('docente.dashboard'),
            3 => redirect()->route('estudiante.dashboard'),
            default => view('dashboard'),
        };
    })->name('dashboard');

    // ===================== ADMIN =====================
    Route::middleware(['role:1'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdministradoresController::class, 'dashboard'])->name('dashboard');

        Route::resource('usuarios', UsersController::class);
        Route::resource('administradores', AdministradoresController::class);
        Route::resource('docentes', DocentesController::class);
        Route::resource('estudiantes', EstudiantesController::class);
        Route::get('/estudiantes-estadisticas', [EstudiantesController::class, 'estadisticas'])->name('estudiantes.estadisticas');

        Route::resource('secciones', SeccionesController::class);
        Route::get('/secciones/{seccione}/estudiantes', [SeccionesController::class, 'estudiantes'])->name('secciones.estudiantes');
        Route::post('/secciones/{seccione}/asignar-estudiante', [SeccionesController::class, 'asignarEstudiante'])->name('secciones.asignar-estudiante');
        Route::delete('/secciones/{seccione}/remover-estudiante', [SeccionesController::class, 'removerEstudiante'])->name('secciones.remover-estudiante');
        Route::put('/secciones/{seccione}/transferir-estudiante', [SeccionesController::class, 'transferirEstudiante'])->name('secciones.transferir-estudiante');

        // (Si quieres restringir cursos/notas/asistencias/recursos solo a admin, ponlos aquí)
    });

    // ===================== DOCENTE =====================
    Route::middleware(['role:2'])->prefix('docente')->name('docente.')->group(function () {
        Route::get('/dashboard', [DocentesController::class, 'dashboard'])->name('dashboard');

        // añade aquí más rutas de docente cuando las tengas
    });

    // ===================== ESTUDIANTE =====================
    Route::middleware(['role:3'])->prefix('estudiante')->name('estudiante.')->group(function () {
        Route::get('/dashboard', [EstudiantesController::class, 'dashboard'])->name('dashboard');

        // nombres cortos que usa el navbar
        Route::get('/perfil',        [EstudiantesController::class, 'perfil'])->name('perfil');
        Route::get('/mis-cursos',    [EstudiantesController::class, 'cursos'])->name('mis-cursos');
        Route::get('/mis-notas',     [EstudiantesController::class, 'indexEstudiante'])->name('mis-notas');
        Route::get('/mi-progreso',   [EstudiantesController::class, 'progreso'])->name('mi-progreso')
            ->middleware('throttle:30,1'); // opcional
        Route::get('/predicciones',  [EstudiantesController::class, 'predicciones'])->name('predicciones');
        Route::get('/recomendaciones',[EstudiantesController::class, 'recomendaciones'])->name('recomendaciones');
        Route::get('/recursos',      [EstudiantesController::class, 'recursos'])->name('recursos');
    });

    // ===================== MÓDULOS COMPARTIDOS =====================
    // Si son de uso general, déjalos fuera; si no, protégelos con role:1,2,3 según convenga.
    Route::resource('cursos', CursosController::class)->middleware('role:1,2');
    Route::resource('notas',  NotasController::class)->middleware('role:1,2');
    Route::get('/notas/estudiante/{estudiante}', [NotasController::class, 'porEstudiante'])->name('notas.por-estudiante')->middleware('role:1,2,3');
    Route::get('/notas/curso/{curso}',           [NotasController::class, 'porCurso'])->name('notas.por-curso')->middleware('role:1,2');

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
