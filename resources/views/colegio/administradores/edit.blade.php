<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Administrador: ') }} {{ $administradore->usuario->nombres }} {{ $administradore->usuario->apellidos }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('administradores.update', $administradore) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Datos del Usuario -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Usuario</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- DNI -->
                                <div>
                                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                                    <input type="text" name="dni" id="dni" value="{{ old('dni', $administradore->usuario->dni) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dni') border-red-500 @enderror">
                                    @error('dni')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombres -->
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $administradore->usuario->nombres) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
                                    @error('nombres')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                    <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $administradore->usuario->apellidos) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellidos') border-red-500 @enderror">
                                    @error('apellidos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $administradore->usuario->email) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono Usuario -->
                                <div>
                                    <label for="telefono_usuario" class="block text-sm font-medium text-gray-700">Teléfono Personal</label>
                                    <input type="text" name="telefono_usuario" id="telefono_usuario" value="{{ old('telefono_usuario', $administradore->usuario->telefono) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono_usuario') border-red-500 @enderror">
                                    @error('telefono_usuario')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña (opcional)</label>
                                    <input type="password" name="password" id="password" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
                                    <p class="mt-1 text-sm text-gray-500">Deja en blanco si no deseas cambiar la contraseña</p>
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Datos del Administrador -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Administrador</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Cargo -->
                                <div>
                                    <label for="cargo" class="block text-sm font-medium text-gray-700">Cargo</label>
                                    <input type="text" name="cargo" id="cargo" value="{{ old('cargo', $administradore->cargo) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('cargo') border-red-500 @enderror">
                                    @error('cargo')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono Administrativo -->
                                <div>
                                    <label for="telefono_admin" class="block text-sm font-medium text-gray-700">Teléfono Administrativo</label>
                                    <input type="text" name="telefono_admin" id="telefono_admin" value="{{ old('telefono_admin', $administradore->telefono) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono_admin') border-red-500 @enderror">
                                    @error('telefono_admin')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dirección -->
                                <div class="md:col-span-2">
                                    <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                    <textarea name="direccion" id="direccion" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $administradore->direccion) }}</textarea>
                                    @error('direccion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('administradores.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Administrador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>