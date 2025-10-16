<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Estudiante: ') . $estudiante->usuario->nombres . ' ' . $estudiante->usuario->apellidos }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Datos del Usuario -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Personales del Estudiante</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- DNI -->
                                <div>
                                    <label for="dni" class="block text-sm font-medium text-gray-700">DNI</label>
                                    <input type="text" name="dni" id="dni" value="{{ old('dni', $estudiante->usuario->dni) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('dni') border-red-500 @enderror">
                                    @error('dni')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nombres -->
                                <div>
                                    <label for="nombres" class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $estudiante->usuario->nombres) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nombres') border-red-500 @enderror">
                                    @error('nombres')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label for="apellidos" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                    <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $estudiante->usuario->apellidos) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('apellidos') border-red-500 @enderror">
                                    @error('apellidos')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico (opcional)</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $estudiante->usuario->email) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Teléfono Usuario -->
                                <div>
                                    <label for="telefono_usuario" class="block text-sm font-medium text-gray-700">Teléfono Personal</label>
                                    <input type="text" name="telefono_usuario" id="telefono_usuario" value="{{ old('telefono_usuario', $estudiante->usuario->telefono) }}" 
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
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Dejar en blanco si no desea cambiar la contraseña</p>
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
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
                                        <option value="">Seleccionar sección</option>
                                        @foreach($secciones as $seccion)
                                            <option value="{{ $seccion->id }}" {{ old('seccion_id', $estudiante->seccion_id) == $seccion->id ? 'selected' : '' }}>
                                                {{ $seccion->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seccion_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Promedio Anterior -->
                                <div>
                                    <label for="promedio_anterior" class="block text-sm font-medium text-gray-700">Promedio Anterior</label>
                                    <input type="number" name="promedio_anterior" id="promedio_anterior" step="0.01" min="0" max="20" value="{{ old('promedio_anterior', $estudiante->promedio_anterior) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('promedio_anterior') border-red-500 @enderror">
                                    @error('promedio_anterior')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Escala de 0 a 20</p>
                                </div>

                                <!-- Faltas -->
                                <div>
                                    <label for="faltas" class="block text-sm font-medium text-gray-700">Faltas</label>
                                    <input type="number" name="faltas" id="faltas" min="0" value="{{ old('faltas', $estudiante->faltas) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('faltas') border-red-500 @enderror">
                                    @error('faltas')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Horas de Estudio Semanal -->
                                <div>
                                    <label for="horas_estudio_semanal" class="block text-sm font-medium text-gray-700">Horas de Estudio Semanal</label>
                                    <input type="number" name="horas_estudio_semanal" id="horas_estudio_semanal" min="0" max="168" value="{{ old('horas_estudio_semanal', $estudiante->horas_estudio_semanal) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('horas_estudio_semanal') border-red-500 @enderror">
                                    @error('horas_estudio_semanal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Participación en Clases -->
                                <div>
                                    <label for="participacion_clases" class="block text-sm font-medium text-gray-700">Participación en Clases (1-10)</label>
                                    <input type="number" name="participacion_clases" id="participacion_clases" min="1" max="10" value="{{ old('participacion_clases', $estudiante->participacion_clases) }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('participacion_clases') border-red-500 @enderror">
                                    @error('participacion_clases')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-sm text-gray-500">Escala de 1 a 10 (opcional)</p>
                                </div>

                                <!-- Motivación -->
                                <div>
                                    <label for="motivacion" class="block text-sm font-medium text-gray-700">Motivación</label>
                                    <select name="motivacion" id="motivacion" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('motivacion') border-red-500 @enderror">
                                        <option value="Alta" {{ old('motivacion', $estudiante->motivacion) === 'Alta' ? 'selected' : '' }}>Alta</option>
                                        <option value="Media" {{ old('motivacion', $estudiante->motivacion) === 'Media' ? 'selected' : '' }}>Media</option>
                                        <option value="Baja" {{ old('motivacion', $estudiante->motivacion) === 'Baja' ? 'selected' : '' }}>Baja</option>
                                    </select>
                                    @error('motivacion')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Datos Socioeconómicos -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información Socioeconómica</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nivel Socioeconómico -->
                                <div>
                                    <label for="nivel_socioeconomico" class="block text-sm font-medium text-gray-700">Nivel Socioeconómico</label>
                                    <select name="nivel_socioeconomico" id="nivel_socioeconomico" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('nivel_socioeconomico') border-red-500 @enderror">
                                        <option value="bajo" {{ old('nivel_socioeconomico', $estudiante->nivel_socioeconomico) === 'bajo' ? 'selected' : '' }}>Bajo</option>
                                        <option value="medio" {{ old('nivel_socioeconomico', $estudiante->nivel_socioeconomico) === 'medio' ? 'selected' : '' }}>Medio</option>
                                        <option value="alto" {{ old('nivel_socioeconomico', $estudiante->nivel_socioeconomico) === 'alto' ? 'selected' : '' }}>Alto</option>
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
                                        <option value="padres" {{ old('vive_con', $estudiante->vive_con) === 'padres' ? 'selected' : '' }}>Ambos Padres</option>
                                        <option value="madre" {{ old('vive_con', $estudiante->vive_con) === 'madre' ? 'selected' : '' }}>Solo Madre</option>
                                        <option value="padre" {{ old('vive_con', $estudiante->vive_con) === 'padre' ? 'selected' : '' }}>Solo Padre</option>
                                        <option value="otros" {{ old('vive_con', $estudiante->vive_con) === 'otros' ? 'selected' : '' }}>Otros Familiares</option>
                                    </select>
                                    @error('vive_con')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Padres Divorciados -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="padres_divorciados" value="1" 
                                               {{ old('padres_divorciados', $estudiante->padres_divorciados) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Padres divorciados</span>
                                    </label>
                                </div>

                                <!-- Internet en Casa -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="internet_en_casa" value="1" 
                                               {{ old('internet_en_casa', $estudiante->internet_en_casa) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Tiene internet en casa</span>
                                    </label>
                                </div>

                                <!-- Dispositivo Propio -->
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="dispositivo_propio" value="1" 
                                               {{ old('dispositivo_propio', $estudiante->dispositivo_propio) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Tiene dispositivo propio (PC/tablet/celular)</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('estudiantes.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Actualizar Estudiante
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>