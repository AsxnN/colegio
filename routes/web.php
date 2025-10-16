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
});
