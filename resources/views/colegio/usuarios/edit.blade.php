<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario: ') }} {{ $usuario->nombres }} {{ $usuario->apellidos }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- DNI -->
                            <div>
                                <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                                <input type="text" name="dni" id="dni" value="{{ old('dni', $usuario->dni) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dni') border-red-500 @enderror">
                                @error('dni')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nombres -->
                            <div>
                                <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $usuario->nombres) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
                                @error('nombres')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Apellidos -->
                            <div>
                                <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellidos') border-red-500 @enderror">
                                @error('apellidos')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Correo -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Rol -->
                            <div>
                                <label for="rol_id" class="block text-sm font-medium text-gray-700">Rol</label>
                                <select name="rol_id" id="rol_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('rol_id') border-red-500 @enderror">
                                    <option value="">Seleccionar rol</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}" {{ old('rol_id', $usuario->rol_id) == $rol->id ? 'selected' : '' }}>
                                            {{ $rol->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rol_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono') border-red-500 @enderror">
                                @error('telefono')
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

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('usuarios.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>