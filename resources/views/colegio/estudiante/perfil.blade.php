{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\estudiante\perfil.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Perfil del Estudiante</h1>

    {{-- Información del estudiante --}}
    <div class="card mb-4">
        <div class="card-header">Información Personal</div>
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $estudiante->usuario->nombres }} {{ $estudiante->usuario->apellidos }}</p>
            <p><strong>DNI:</strong> {{ $estudiante->usuario->dni }}</p>
            <p><strong>Email:</strong> {{ $estudiante->usuario->email }}</p>
            <p><strong>Teléfono:</strong> {{ $estudiante->usuario->telefono }}</p>
            <p><strong>Sección:</strong> {{ $estudiante->seccion->grado }}{{ $estudiante->seccion->nombre }}</p>
        </div>
    </div>

    {{-- Enlaces a las demás vistas --}}
    <div class="list-group">
        <a href="{{ route('estudiante.cursos') }}" class="list-group-item list-group-item-action">Cursos</a>
        <a href="{{ route('estudiante.notas') }}" class="list-group-item list-group-item-action">Notas</a>
        <a href="{{ route('estudiante.predicciones') }}" class="list-group-item list-group-item-action">Predicciones</a>
        <a href="{{ route('estudiante.recomendaciones') }}" class="list-group-item list-group-item-action">Recomendaciones IA</a>
        <a href="{{ route('estudiante.recursos') }}" class="list-group-item list-group-item-action">Recursos Educativos</a>
    </div>
</div>
@endsection