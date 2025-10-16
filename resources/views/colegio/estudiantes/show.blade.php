<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Estudiante: ') . $estudiante->usuario->nombres . ' ' . $estudiante->usuario->apellidos }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('estudiantes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Información Personal -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información Personal</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">DNI</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->usuario->dni }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombres</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->usuario->nombres }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->usuario->apellidos }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->usuario->email ?? 'Sin email' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->usuario->telefono ?? 'Sin teléfono' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->created_at ? $estudiante->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Académica -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información Académica</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sección</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($estudiante->seccion)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $estudiante->seccion->nombre_completo }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Sin sección asignada
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Promedio Anterior</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($estudiante->promedio_anterior)
                                    {{ $estudiante->promedio_anterior }}
                                    @if($estudiante->promedio_anterior >= 14)
                                        <span class="text-green-600 font-medium">(Bueno)</span>
                                    @elseif($estudiante->promedio_anterior >= 11)
                                        <span class="text-yellow-600 font-medium">(Regular)</span>
                                    @else
                                        <span class="text-red-600 font-medium">(Deficiente)</span>
                                    @endif
                                @else
                                    Sin datos
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Faltas</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $estudiante->faltas > 10 ? 'bg-red-100 text-red-800' : ($estudiante->faltas > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $estudiante->faltas }} faltas
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Horas de Estudio Semanal</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->horas_estudio_semanal }} horas</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Participación en Clases</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($estudiante->participacion_clases)
                                    {{ $estudiante->participacion_clases }}/10 
                                    <span class="text-sm text-gray-500">({{ $estudiante->participacion_texto }})</span>
                                @else
                                    No evaluado
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Motivación</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($estudiante->motivacion === 'Alta') bg-green-100 text-green-800
                                    @elseif($estudiante->motivacion === 'Media') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $estudiante->motivacion }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Socioeconómica -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información Socioeconómica</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nivel Socioeconómico</label>
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($estudiante->nivel_socioeconomico === 'alto') bg-green-100 text-green-800
                                    @elseif($estudiante->nivel_socioeconomico === 'medio') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($estudiante->nivel_socioeconomico) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Situación Familiar</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->situacion_familiar }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recursos Educativos</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $estudiante->recursos_educativos }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Internet en Casa</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($estudiante->internet_en_casa)
                                    <span class="text-green-600">✓ Sí</span>
                                @else
                                    <span class="text-red-600">✗ No</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dispositivo Propio</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($estudiante->dispositivo_propio)
                                    <span class="text-green-600">✓ Sí</span>
                                @else
                                    <span class="text-red-600">✗ No</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Padres Divorciados</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if($estudiante->padres_divorciados)
                                    <span class="text-red-600">✓ Sí</span>
                                @else
                                    <span class="text-green-600">✗ No</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Análisis de Riesgo -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Análisis de Factores de Riesgo</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Factores Positivos</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                @if($estudiante->motivacion === 'Alta')
                                    <li class="text-green-600">Motivación alta</li>
                                @endif
                                @if($estudiante->internet_en_casa)
                                    <li class="text-green-600">Acceso a internet en casa</li>
                                @endif
                                @if($estudiante->dispositivo_propio)
                                    <li class="text-green-600">Dispositivo propio para estudiar</li>
                                @endif
                                @if($estudiante->vive_con === 'padres' && !$estudiante->padres_divorciados)
                                    <li class="text-green-600">Núcleo familiar estable</li>
                                @endif
                                @if($estudiante->faltas <= 5)
                                    <li class="text-green-600">Buena asistencia</li>
                                @endif
                                @if($estudiante->horas_estudio_semanal >= 15)
                                    <li class="text-green-600">Dedicación al estudio</li>
                                @endif
                            </ul>
                        </div>

                        <div>
                            <h4 class="font-medium text-gray-900 mb-2">Factores de Riesgo</h4>
                            <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                @if($estudiante->motivacion === 'Baja')
                                    <li class="text-red-600">Motivación baja</li>
                                @endif
                                @if(!$estudiante->internet_en_casa)
                                    <li class="text-red-600">Sin acceso a internet en casa</li>
                                @endif
                                @if(!$estudiante->dispositivo_propio)
                                    <li class="text-red-600">Sin dispositivo propio</li>
                                @endif
                                @if($estudiante->nivel_socioeconomico === 'bajo')
                                    <li class="text-red-600">Nivel socioeconómico bajo</li>
                                @endif
                                @if($estudiante->padres_divorciados || $estudiante->vive_con !== 'padres')
                                    <li class="text-red-600">Situación familiar compleja</li>
                                @endif
                                @if($estudiante->faltas > 10)
                                    <li class="text-red-600">Alta inasistencia</li>
                                @endif
                                @if($estudiante->horas_estudio_semanal < 5)
                                    <li class="text-red-600">Pocas horas de estudio</li>
                                @endif
                                @if($estudiante->promedio_anterior && $estudiante->promedio_anterior < 11)
                                    <li class="text-red-600">Promedio anterior bajo</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>