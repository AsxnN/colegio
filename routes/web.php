<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\DocentesController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\SeccionesController;

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
});
