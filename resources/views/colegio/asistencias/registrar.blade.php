{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\asistencias\registrar.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Asistencia Masiva') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-4">
                <form method="GET" action="{{ route('asistencias.registrar') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha *</label>
                        <input type="date" name="fecha" value="{{ $fecha }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sección *</label>
                        <select name="seccion_id" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">Seleccione una sección</option>
                            @foreach($secciones as $seccion)
                                <option value="{{ $seccion->id }}" {{ $seccionId == $seccion->id ? 'selected' : '' }}>
                                    {{ $seccion->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Curso (Opcional)</label>
                        <select name="curso_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">General</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $cursoId == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Cargar Estudiantes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Listado de estudiantes para marcar asistencia -->
            @if($estudiantes)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <form method="POST" action="{{ route('asistencias.guardar-masivo') }}">
                        @csrf
                        <input type="hidden" name="fecha" value="{{ $fecha }}">
                        <input type="hidden" name="curso_id" value="{{ $cursoId }}">
                        <input type="hidden" name="seccion_id" value="{{ $seccionId }}">

                        <div class="mb-4 flex justify-between items-center">
                            <h3 class="text-lg font-semibold">
                                Estudiantes ({{ $estudiantes->count() }})
                            </h3>
                            <div class="flex gap-2">
                                <button type="button" onclick="marcarTodos(true)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Marcar Todos Presentes
                                </button>
                                <button type="button" onclick="marcarTodos(false)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                    Marcar Todos Ausentes
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Presente</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ausente</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observación</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($estudiantes as $index => $estudiante)
                                        @php
                                            $asistenciaExistente = $estudiante->asistencias->first();
                                            $estaPresente = $asistenciaExistente ? $asistenciaExistente->presente : true;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $estudiante->usuario->name }}
                                                <input type="hidden" name="asistencias[{{ $index }}][estudiante_id]" value="{{ $estudiante->id }}">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="radio" name="asistencias[{{ $index }}][presente]" value="1" 
                                                       {{ $estaPresente ? 'checked' : '' }}
                                                       class="asistencia-radio w-4 h-4 text-green-600">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <input type="radio" name="asistencias[{{ $index }}][presente]" value="0" 
                                                       {{ !$estaPresente ? 'checked' : '' }}
                                                       class="asistencia-radio w-4 h-4 text-red-600">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="text" name="asistencias[{{ $index }}][observacion]" 
                                                       value="{{ $asistenciaExistente ? $asistenciaExistente->observacion : '' }}"
                                                       placeholder="Observación opcional"
                                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 text-sm">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end gap-4 mt-6">
                            <a href="{{ route('asistencias.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Guardar Asistencias
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                    function marcarTodos(presente) {
                        const radios = document.querySelectorAll('input[type="radio"][value="' + (presente ? '1' : '0') + '"]');
                        radios.forEach(radio => {
                            radio.checked = true;
                        });
                    }
                </script>
            @endif
        </div>
    </div>
</x-app-layout>