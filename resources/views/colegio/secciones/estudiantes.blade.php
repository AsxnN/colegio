<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Estudiantes - ') . $seccion->nombre_completo }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('secciones.show', $seccion) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Ver Sección
                </a>
                <a href="{{ route('secciones.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Volver a Secciones
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- ASIGNAR ESTUDIANTES SIN SECCIÓN -->
            @if($estudiantesSinSeccion->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        <span class="text-green-600">📍 Asignar Estudiantes a esta Sección</span>
                    </h3>
                    <p class="text-sm text-gray-600 mb-4">Estudiantes que no tienen sección asignada:</p>
                    
                    <form action="{{ route('secciones.asignar-estudiante', $seccion) }}" method="POST" class="flex gap-4 items-end">
                        @csrf
                        <div class="flex-1">
                            <label for="estudiante_id" class="block text-sm font-medium text-gray-700">Seleccionar Estudiante</label>
                            <select name="estudiante_id" id="estudiante_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="">-- Selecciona un estudiante --</option>
                                @foreach($estudiantesSinSeccion as $estudiante)
                                    <option value="{{ $estudiante->id }}">
                                        {{ $estudiante->usuario->dni }} - {{ $estudiante->usuario->nombres }} {{ $estudiante->usuario->apellidos }}
                                        @if($estudiante->promedio_anterior)
                                            (Promedio: {{ $estudiante->promedio_anterior }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition duration-200">
                            ✅ Asignar a Sección
                        </button>
                    </form>
                    
                    <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-700">
                            💡 <strong>{{ $estudiantesSinSeccion->count() }}</strong> estudiante(s) disponible(s) para asignar
                        </p>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-center">
                    <div class="text-gray-400 mb-2">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Todos los estudiantes están asignados</h3>
                    <p class="text-sm text-gray-500">No hay estudiantes sin sección disponibles para asignar.</p>
                </div>
            </div>
            @endif

            <!-- ESTUDIANTES EN LA SECCIÓN -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">
                            👥 Estudiantes en {{ $seccion->nombre_completo }}
                        </h3>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                            {{ $seccion->estudiantes->count() }} estudiantes
                        </span>
                    </div>

                    @if($seccion->estudiantes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promedio</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivación</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($seccion->estudiantes as $estudiante)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $estudiante->usuario->dni }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $estudiante->usuario->nombres }} {{ $estudiante->usuario->apellidos }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $estudiante->usuario->email ?? 'Sin email' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($estudiante->promedio_anterior)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $estudiante->promedio_anterior >= 14 ? 'bg-green-100 text-green-800' : 
                                                       ($estudiante->promedio_anterior >= 11 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                    {{ $estudiante->promedio_anterior }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($estudiante->motivacion === 'Alta') bg-green-100 text-green-800
                                                @elseif($estudiante->motivacion === 'Media') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                @if($estudiante->motivacion === 'Alta') 🔥 
                                                @elseif($estudiante->motivacion === 'Media') ⚡ 
                                                @else 📉 @endif
                                                {{ $estudiante->motivacion }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-3">
                                                <a href="{{ route('estudiantes.show', $estudiante) }}" 
                                                   class="text-blue-600 hover:text-blue-900 transition duration-200">
                                                    👁️ Ver
                                                </a>
                                                
                                                <!-- Botón para remover -->
                                                <form action="{{ route('secciones.remover-estudiante', $seccion) }}" 
                                                      method="POST" class="inline" 
                                                      onsubmit="return confirm('¿Estás seguro de remover a {{ $estudiante->usuario->nombres }} de esta sección?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">
                                                    <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200">
                                                        ❌ Remover
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Estadísticas rápidas -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg">
                                <div class="text-sm font-medium text-green-800">Alta Motivación</div>
                                <div class="text-2xl font-bold text-green-600">
                                    {{ $seccion->estudiantes->where('motivacion', 'Alta')->count() }}
                                </div>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <div class="text-sm font-medium text-yellow-800">Media Motivación</div>
                                <div class="text-2xl font-bold text-yellow-600">
                                    {{ $seccion->estudiantes->where('motivacion', 'Media')->count() }}
                                </div>
                            </div>
                            <div class="bg-red-50 p-4 rounded-lg">
                                <div class="text-sm font-medium text-red-800">Baja Motivación</div>
                                <div class="text-2xl font-bold text-red-600">
                                    {{ $seccion->estudiantes->where('motivacion', 'Baja')->count() }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay estudiantes asignados</h3>
                            <p class="mt-1 text-sm text-gray-500">Esta sección aún no tiene estudiantes asignados.</p>
                            @if($estudiantesSinSeccion->count() > 0)
                                <p class="mt-2 text-sm text-blue-600">⬆️ Usa el formulario de arriba para asignar estudiantes</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>