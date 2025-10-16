{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\estudiante\notas.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Notas del Estudiante</h1>

    @if($notas->isEmpty())
        <p>No hay notas registradas.</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Bimestre 1</th>
                    <th>Bimestre 2</th>
                    <th>Bimestre 3</th>
                    <th>Bimestre 4</th>
                    <th>Promedio Final</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notas as $nota)
                    <tr>
                        <td>{{ $nota->curso->nombre }}</td>
                        <td>{{ $nota->bimestre1 }}</td>
                        <td>{{ $nota->bimestre2 }}</td>
                        <td>{{ $nota->bimestre3 }}</td>
                        <td>{{ $nota->bimestre4 }}</td>
                        <td>{{ $nota->promedio_final }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection