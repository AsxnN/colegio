<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('estudiantes.store') }}" method="POST">
                        @csrf
                        
                        <!-- Datos del Usuario -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Personales del Estudiante</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- DNI -->
                                <div>
                                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                                    <input type="text" name="dni" id="dni" value="{{ old('dni') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dni') border-red-500 @enderror">
                                    @error('dni')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombres -->
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
                                    @error('nombres')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                    <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellidos') border-red-500 @enderror">
                                    @error('apellidos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico (opcional)</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono -->
                                <div>
                                    <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono Personal</label>
                                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('telefono') border-red-500 @enderror">
                                    @error('telefono')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                    <input type="password" name="password" id="password" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Datos Académicos -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Académicos</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Sección -->
                                <div>
                                    <label for="seccion_id" class="block text-sm font-medium text-gray-700">Sección</label>
                                    <select name="seccion_id" id="seccion_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('seccion_id') border-red-500 @enderror">
                                        <option value="">Seleccionar sección (opcional)</option>
                                        @foreach($secciones as $seccion)
                                            <option value="{{ $seccion->id }}" {{ old('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                                {{ $seccion->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seccion_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Puedes asignar la sección más tarde</p>
                                </div>

                                <!-- Promedio Anterior -->
                                <div>
                                    <label for="promedio_anterior" class="block text-sm font-medium text-gray-700">Promedio Anterior</label>
                                    <input type="number" name="promedio_anterior" id="promedio_anterior" step="0.01" min="0" max="20" value="{{ old('promedio_anterior') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('promedio_anterior') border-red-500 @enderror">
                                    @error('promedio_anterior')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Escala de 0 a 20 (opcional)</p>
                                </div>

                                <!-- Motivación -->
                                <div>
                                    <label for="motivacion" class="block text-sm font-medium text-gray-700">Motivación</label>
                                    <select name="motivacion" id="motivacion" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('motivacion') border-red-500 @enderror">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="Alta" {{ old('motivacion') === 'Alta' ? 'selected' : '' }}>🔥 Alta</option>
                                        <option value="Media" {{ old('motivacion') === 'Media' ? 'selected' : '' }}>⚡ Media</option>
                                        <option value="Baja" {{ old('motivacion') === 'Baja' ? 'selected' : '' }}>📉 Baja</option>
                                    </select>
                                    @error('motivacion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Información Adicional (Opcional) -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información Adicional (Opcional)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Faltas -->
                                <div>
                                    <label for="faltas" class="block text-sm font-medium text-gray-700">Faltas</label>
                                    <input type="number" name="faltas" id="faltas" min="0" value="{{ old('faltas', 0) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('faltas') border-red-500 @enderror">
                                    @error('faltas')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Horas de Estudio Semanal -->
                                <div>
                                    <label for="horas_estudio_semanal" class="block text-sm font-medium text-gray-700">Horas de Estudio Semanal</label>
                                    <input type="number" name="horas_estudio_semanal" id="horas_estudio_semanal" min="0" max="168" value="{{ old('horas_estudio_semanal') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('horas_estudio_semanal') border-red-500 @enderror">
                                    @error('horas_estudio_semanal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Participación en Clases -->
                                <div>
                                    <label for="participacion_clases" class="block text-sm font-medium text-gray-700">Participación en Clases (1-10)</label>
                                    <input type="number" name="participacion_clases" id="participacion_clases" min="1" max="10" value="{{ old('participacion_clases') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('participacion_clases') border-red-500 @enderror">
                                    @error('participacion_clases')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Escala de 1 a 10</p>
                                </div>

                                <!-- Nivel Socioeconómico -->
                                <div>
                                    <label for="nivel_socioeconomico" class="block text-sm font-medium text-gray-700">Nivel Socioeconómico</label>
                                    <select name="nivel_socioeconomico" id="nivel_socioeconomico" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nivel_socioeconomico') border-red-500 @enderror">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="bajo" {{ old('nivel_socioeconomico') === 'bajo' ? 'selected' : '' }}>Bajo</option>
                                        <option value="medio" {{ old('nivel_socioeconomico') === 'medio' ? 'selected' : '' }}>Medio</option>
                                        <option value="alto" {{ old('nivel_socioeconomico') === 'alto' ? 'selected' : '' }}>Alto</option>
                                    </select>
                                    @error('nivel_socioeconomico')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Vive con -->
                                <div>
                                    <label for="vive_con" class="block text-sm font-medium text-gray-700">Vive con</label>
                                    <select name="vive_con" id="vive_con" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('vive_con') border-red-500 @enderror">
                                        <option value="">-- Seleccionar --</option>
                                        <option value="padres" {{ old('vive_con') === 'padres' ? 'selected' : '' }}>Ambos Padres</option>
                                        <option value="madre" {{ old('vive_con') === 'madre' ? 'selected' : '' }}>Solo Madre</option>
                                        <option value="padre" {{ old('vive_con') === 'padre' ? 'selected' : '' }}>Solo Padre</option>
                                        <option value="otros" {{ old('vive_con') === 'otros' ? 'selected' : '' }}>Otros Familiares</option>
                                    </select>
                                    @error('vive_con')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Checkboxes -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-900 mb-3">Situación Familiar y Recursos</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Padres Divorciados -->
                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="padres_divorciados" value="1" {{ old('padres_divorciados') ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Padres divorciados</span>
                                        </label>
                                    </div>

                                    <!-- Internet en Casa -->
                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="internet_en_casa" value="1" {{ old('internet_en_casa', true) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Tiene internet en casa</span>
                                        </label>
                                    </div>

                                    <!-- Dispositivo Propio -->
                                    <div>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="dispositivo_propio" value="1" {{ old('dispositivo_propio', true) ? 'checked' : '' }}
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-700">Tiene dispositivo propio (PC/tablet/celular)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información de creación -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-medium text-blue-800 mb-2">ℹ️ Información importante:</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Los campos marcados con (*) son obligatorios</li>
                                <li>• La sección puede asignarse más tarde desde la gestión de secciones</li>
                                <li>• La contraseña por defecto será el DNI si no se especifica</li>
                                <li>• El estudiante podrá cambiar su contraseña después del primer acceso</li>
                            </ul>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('estudiantes.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                                📝 Registrar Estudiante
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>