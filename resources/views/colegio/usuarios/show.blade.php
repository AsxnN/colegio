<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Usuario') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('usuarios.edit', $usuario) }}" 
                   class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('usuarios.index') }}" 
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">DNI</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->dni ?: 'No especificado' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombres</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->nombres }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->apellidos }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->email ?: 'No especificado' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rol</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    {{ $usuario->rol->nombre }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->telefono ?: 'No especificado' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Creación</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->creado_en ? $usuario->creado_en->format('d/m/Y H:i') : 'No especificado' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última Actualización</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $usuario->actualizado_en ? $usuario->actualizado_en->format('d/m/Y H:i') : 'Nunca actualizado' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>