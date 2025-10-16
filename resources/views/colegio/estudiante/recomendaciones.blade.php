{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\estudiante\recomendaciones.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Recomendaciones Personalizadas</h1>

    @if($recomendaciones->isEmpty())
        <p>No hay recomendaciones disponibles.</p>
    @else
        <ul class="list-group">
            @foreach($recomendaciones as $recomendacion)
                <li class="list-group-item">
                    <strong>{{ $recomendacion->titulo }}</strong>
                    <p>{{ $recomendacion->contenido }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection