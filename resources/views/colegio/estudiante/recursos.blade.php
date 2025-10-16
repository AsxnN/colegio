{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\estudiante\recursos.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recursos Educativos</h1>

    @if($recursos->isEmpty())
        <p>No hay recursos educativos disponibles.</p>
    @else
        <ul class="list-group">
            @foreach($recursos as $recurso)
                <li class="list-group-item">
                    <strong>{{ $recurso->titulo }}</strong>
                    <p>{{ $recurso->descripcion }}</p>
                    <a href="{{ $recurso->enlace }}" target="_blank" class="btn btn-primary">Ver Recurso</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection