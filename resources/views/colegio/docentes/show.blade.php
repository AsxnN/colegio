<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Docente') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('docentes.edit', $docente) }}" 
                   class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('docentes.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Datos del Usuario -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Usuario</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">DNI</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->usuario->dni ?: 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->usuario->nombres }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->usuario->apellidos }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->usuario->email ?: 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teléfono Personal</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->usuario->telefono ?: 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rol</label>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $docente->usuario->rol->nombre }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Datos del Docente -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Docente</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Especialidad</label>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        {{ $docente->especialidad }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Grado Académico</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->grado_academico ?: 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Teléfono de Trabajo</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->telefono ?: 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado</label>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($docente->estado === 'Activo') bg-green-100 text-green-800
                                        @elseif($docente->estado === 'Inactivo') bg-red-100 text-red-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $docente->estado }}
                                    </span>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $docente->fecha_ingreso ? $docente->fecha_ingreso->format('d/m/Y') : 'No especificado' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Última Actualización</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $docente->usuario->actualizado_en ? $docente->usuario->actualizado_en->format('d/m/Y H:i') : 'Nunca actualizado' }}
                                </p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Dirección</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $docente->direccion ?: 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>