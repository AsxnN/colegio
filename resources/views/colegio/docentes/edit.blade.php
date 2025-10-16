<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Docente: ') }} {{ $docente->usuario->nombres }} {{ $docente->usuario->apellidos }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('docentes.update', $docente) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Datos del Usuario -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Usuario</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- DNI -->
                                <div>
                                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                                    <input type="text" name="dni" id="dni" value="{{ old('dni', $docente->usuario->dni) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dni') border-red-500 @enderror">
                                    @error('dni')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombres -->
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $docente->usuario->nombres) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
                                    @error('nombres')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                    <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $docente->usuario->apellidos) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellidos') border-red-500 @enderror">
                                    @error('apellidos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $docente->usuario->email) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono Usuario -->
                                <div>
                                    <label for="telefono_usuario" class="block text-sm font-medium text-gray-700">Teléfono Personal</label>
                                    <input type="text" name="telefono_usuario" id="telefono_usuario" value="{{ old('telefono_usuario', $docente->usuario->telefono) }}" 
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

                        <!-- Datos del Docente -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos del Docente</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Especialidad -->
                                <div>
                                    <label for="especialidad" class="block text-sm font-medium text-gray-700">Especialidad</label>
                                    <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad', $docente->especialidad) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('especialidad') border-red-500 @enderror">
                                    @error('especialidad')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Grado Académico -->
                                <div>
                                    <label for="grado_academico" class="block text-sm font-medium text-gray-700">Grado Académico</label>
                                    <select name="grado_academico" id="grado_academico" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('grado_academico') border-red-500 @enderror">
                                        <option value="">Seleccionar...</option>
                                        <option value="Bachiller" {{ old('grado_academico', $docente->grado_academico) === 'Bachiller' ? 'selected' : '' }}>Bachiller</option>
                                        <option value="Licenciado" {{ old('grado_academico', $docente->grado_academico) === 'Licenciado' ? 'selected' : '' }}>Licenciado</option>
                                        <option value="Magíster" {{ old('grado_academico', $docente->grado_academico) === 'Magíster' ? 'selected' : '' }}>Magíster</option>
                                        <option value="Doctor" {{ old('grado_academico', $docente->grado_academico) === 'Doctor' ? 'selected' : '' }}>Doctor</option>
                                    </select>
                                    @error('grado_academico')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono Docente -->
                                <div>
                                    <label for="telefono_docente" class="block text-sm font-medium text-gray-700">Teléfono de Trabajo</label>
                                    <input type="text" name="telefono_docente" id="telefono_docente" value="{{ old('telefono_docente', $docente->telefono) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono_docente') border-red-500 @enderror">
                                    @error('telefono_docente')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Fecha de Ingreso -->
                                <div>
                                    <label for="fecha_ingreso" class="block text-sm font-medium text-gray-700">Fecha de Ingreso</label>
                                    <input type="date" name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso', $docente->fecha_ingreso->format('Y-m-d')) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('fecha_ingreso') border-red-500 @enderror">
                                    @error('fecha_ingreso')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select name="estado" id="estado" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('estado') border-red-500 @enderror">
                                        <option value="Activo" {{ old('estado', $docente->estado) === 'Activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="Inactivo" {{ old('estado', $docente->estado) === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="Licencia" {{ old('estado', $docente->estado) === 'Licencia' ? 'selected' : '' }}>En Licencia</option>
                                    </select>
                                    @error('estado')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Dirección -->
                                <div class="md:col-span-2">
                                    <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                                    <textarea name="direccion" id="direccion" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $docente->direccion) }}</textarea>
                                    @error('direccion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('docentes.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Docente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>