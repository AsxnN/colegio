
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de Sección: ') . $seccion->nombre_completo }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('secciones.estudiantes', $seccion) }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                    Gestionar Estudiantes
                </a>
                <a href="{{ route('secciones.edit', $seccion) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('secciones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Información de la Sección -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la Sección</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $seccion->nombre }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Grado</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $seccion->grado ?? 'Sin grado específico' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $seccion->nombre_completo }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total de Estudiantes</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $seccion->estudiantes_actuales > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $seccion->estudiantes_actuales }} estudiantes
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $seccion->created_at ? $seccion->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última Actualización</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $seccion->updated_at ? $seccion->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Estudiantes -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Estudiantes en esta Sección</h3>
                        @if($seccion->estudiantes->count() > 0)
                            <span class="text-sm text-gray-500">{{ $seccion->estudiantes->count() }} estudiantes</span>
                        @endif
                    </div>

                    @if($seccion->estudiantes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promedio Anterior</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivación</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($seccion->estudiantes as $estudiante)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $estudiante->usuario->dni }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $estudiante->usuario->nombres }} {{ $estudiante->usuario->apellidos }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $estudiante->usuario->email ?? 'Sin email' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $estudiante->promedio_anterior ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($estudiante->motivacion === 'Alta') bg-green-100 text-green-800
                                                @elseif($estudiante->motivacion === 'Media') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ $estudiante->motivacion }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('estudiantes.show', $estudiante->id) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay estudiantes</h3>
                            <p class="mt-1 text-sm text-gray-500">Esta sección aún no tiene estudiantes asignados.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>