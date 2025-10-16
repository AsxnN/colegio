{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\estudiante\predicciones.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Predicciones de Rendimiento</h1>

    @if($predicciones->isEmpty())
        <p>No hay predicciones disponibles.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Probabilidad de Aprobar</th>
                    <th>Predicción</th>
                    <th>Modelo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($predicciones as $prediccion)
                    <tr>
                        <td>{{ $prediccion->fecha_prediccion }}</td>
                        <td>{{ number_format($prediccion->probabilidad_aprobar * 100, 2) }}%</td>
                        <td>{{ $prediccion->prediccion_binaria ? 'Aprobará' : 'No Aprobará' }}</td>
                        <td>{{ $prediccion->modelo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection