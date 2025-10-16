
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Sección: ') . $seccion->nombre_completo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('secciones.update', $seccion) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Sección</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $seccion->nombre) }}" placeholder="Ej: A, B, C"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror">
                                @error('nombre')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Ingresa el identificador de la sección (A, B, C, etc.)</p>
                            </div>

                            <!-- Grado -->
                            <div>
                                <label for="grado" class="block text-sm font-medium text-gray-700">Grado (Opcional)</label>
                                <input type="text" name="grado" id="grado" value="{{ old('grado', $seccion->grado) }}" placeholder="Ej: 1° Primaria, 3° Secundaria"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('grado') border-red-500 @enderror">
                                @error('grado')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Opcional. Puedes especificar el grado asociado</p>
                            </div>
                        </div>

                        <!-- Información actual -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-800 mb-2">Información actual:</h4>
                            <div class="text-sm text-gray-600 space-y-1">
                                <div><strong>ID:</strong> {{ $seccion->id }}</div>
                                <div><strong>Estudiantes asignados:</strong> {{ $seccion->estudiantes_actuales }}</div>
                                <div><strong>Creado:</strong> {{ $seccion->created_at ? $seccion->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
                                <div><strong>Última actualización:</strong> {{ $seccion->updated_at ? $seccion->updated_at->format('d/m/Y H:i') : 'N/A' }}</div>
                            </div>
                        </div>

                        @if($seccion->estudiantes_actuales > 0)
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">¡Atención!</h3>
                                    <p class="mt-1 text-sm text-yellow-700">
                                        Esta sección tiene {{ $seccion->estudiantes_actuales }} estudiantes asignados. 
                                        Los cambios en el nombre o grado afectarán la identificación de la sección.
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('secciones.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Sección
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>