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

    Route::get('/asistencias',                   [AsistenciasController::class, 'index'])->name('asistencias.index')->middleware('role:1,2');
    Route::get('/asistencias/registrar',         [AsistenciasController::class, 'registrar'])->name('asistencias.registrar')->middleware('role:1,2');
    Route::post('/asistencias/guardar-masivo',   [AsistenciasController::class, 'guardarMasivo'])->name('asistencias.guardar-masivo')->middleware('role:1,2');
    Route::resource('recursos', RecursosEducativosController::class)->names('recursos')->middleware('role:1,2');
    Route::get('/recursos/curso/{curso}', [RecursosEducativosController::class, 'porCurso'])->name('recursos.por-curso')->middleware('role:1,2,3');
});
