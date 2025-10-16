{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\estudiante\cursos.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cursos del Estudiante</h1>

    @if($cursos->isEmpty())
        <p>No hay cursos asignados.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Docente</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                    <tr>
                        <td>{{ $curso->nombre }}</td>
                        <td>{{ $curso->docente->usuario->nombres }} {{ $curso->docente->usuario->apellidos }}</td>
                        <td>{{ $curso->descripcion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection