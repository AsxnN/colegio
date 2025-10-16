<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Estudiantes') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('estudiantes.estadisticas') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Estadísticas
                </a>
                <a href="{{ route('estudiantes.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nuevo Estudiante
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Filtros -->
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                        <form method="GET" action="{{ route('estudiantes.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div>
                                <label for="seccion_id" class="block text-sm font-medium text-gray-700">Sección</label>
                                <select name="seccion_id" id="seccion_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Todas las secciones</option>
                                    @foreach($secciones as $seccion)
                                    <option value="{{ $seccion->id }}" {{ request('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                        {{ $seccion->nombre_completo }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="nivel_socioeconomico" class="block text-sm font-medium text-gray-700">Nivel Socioeconómico</label>
                                <select name="nivel_socioeconomico" id="nivel_socioeconomico" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Todos los niveles</option>
                                    <option value="bajo" {{ request('nivel_socioeconomico') === 'bajo' ? 'selected' : '' }}>Bajo</option>
                                    <option value="medio" {{ request('nivel_socioeconomico') === 'medio' ? 'selected' : '' }}>Medio</option>
                                    <option value="alto" {{ request('nivel_socioeconomico') === 'alto' ? 'selected' : '' }}>Alto</option>
                                </select>
                            </div>

                            <div>
                                <label for="motivacion" class="block text-sm font-medium text-gray-700">Motivación</label>
                                <select name="motivacion" id="motivacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Todas</option>
                                    <option value="Alta" {{ request('motivacion') === 'Alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="Media" {{ request('motivacion') === 'Media' ? 'selected' : '' }}>Media</option>
                                    <option value="Baja" {{ request('motivacion') === 'Baja' ? 'selected' : '' }}>Baja</option>
                                </select>
                            </div>

                            <div>
                                <label for="vive_con" class="block text-sm font-medium text-gray-700">Vive con</label>
                                <select name="vive_con" id="vive_con" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Todos</option>
                                    <option value="padres" {{ request('vive_con') === 'padres' ? 'selected' : '' }}>Padres</option>
                                    <option value="madre" {{ request('vive_con') === 'madre' ? 'selected' : '' }}>Madre</option>
                                    <option value="padre" {{ request('vive_con') === 'padre' ? 'selected' : '' }}>Padre</option>
                                    <option value="otros" {{ request('vive_con') === 'otros' ? 'selected' : '' }}>Otros</option>
                                </select>
                            </div>

                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Filtrar
                                </button>
                                <a href="{{ route('estudiantes.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Limpiar
                                </a>
                            </div>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sección</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promedio Anterior</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Faltas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivación</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel Socioeconómico</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($estudiantes as $estudiante)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $estudiante->usuario->dni ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $estudiante->usuario->nombres }} {{ $estudiante->usuario->apellidos }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($estudiante->seccion)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $estudiante->seccion->nombre_completo }}
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Sin sección
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $estudiante->promedio_anterior ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $estudiante->faltas > 10 ? 'bg-red-100 text-red-800' : ($estudiante->faltas > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $estudiante->faltas }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($estudiante->motivacion === 'Alta') bg-green-100 text-green-800
                                            @elseif($estudiante->motivacion === 'Media') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $estudiante->motivacion }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($estudiante->nivel_socioeconomico === 'alto') bg-green-100 text-green-800
                                            @elseif($estudiante->nivel_socioeconomico === 'medio') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($estudiante->nivel_socioeconomico) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('estudiante.perfil', $estudiante->id) }}" class="text-blue-600 hover:text-blue-900">Perfil</a>
                                            <a href="{{ route('estudiantes.edit', $estudiante) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <form action="{{ route('estudiantes.destroy', $estudiante) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este estudiante?')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No hay estudiantes registrados
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $estudiantes->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>