<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nueva Sección') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('secciones.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la Sección</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej: A, B, C"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror">
                                @error('nombre')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Ingresa el identificador de la sección (A, B, C, etc.)</p>
                            </div>

                            <!-- Grado -->
                            <div>
                                <label for="grado" class="block text-sm font-medium text-gray-700">Grado (Opcional)</label>
                                <input type="text" name="grado" id="grado" value="{{ old('grado') }}" placeholder="Ej: 1° Primaria, 3° Secundaria"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('grado') border-red-500 @enderror">
                                @error('grado')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500">Opcional. Puedes especificar el grado asociado</p>
                            </div>
                        </div>

                        <!-- Ejemplos comunes -->
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">Ejemplos comunes:</h4>
                            <div class="text-sm text-blue-600 space-y-1">
                                <div><strong>Primaria:</strong> 1° Primaria A, 2° Primaria B, etc.</div>
                                <div><strong>Secundaria:</strong> 1° Secundaria A, 3° Secundaria C, etc.</div>
                                <div><strong>General:</strong> Sección A (sin grado específico)</div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('secciones.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Crear Sección
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>