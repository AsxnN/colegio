<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Estadísticas de Estudiantes') }}
            </h2>
            <a href="{{ route('estudiantes.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver a Estudiantes
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Resumen General -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Resumen General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 9a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-blue-600">Total Estudiantes</p>
                                    <p class="text-2xl font-bold text-blue-900">{{ $estadisticas['total_estudiantes'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-green-600">Con Recursos Completos</p>
                                    <p class="text-2xl font-bold text-green-900">{{ $estadisticas['con_recursos_completos'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-yellow-600">Con Dificultades</p>
                                    <p class="text-2xl font-bold text-yellow-900">{{ $estadisticas['con_dificultades'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-red-600">Problemas Familiares</p>
                                    <p class="text-2xl font-bold text-red-900">{{ $estadisticas['problemas_familiares'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promedios -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Promedios de Estudio</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                                <span class="text-sm font-medium text-gray-700">Horas de Estudio Semanal</span>
                                <span class="text-lg font-bold text-blue-600">{{ number_format($estadisticas['promedio_horas_estudio'], 1) }} hrs</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded">
                                <span class="text-sm font-medium text-gray-700">Promedio de Faltas</span>
                                <span class="text-lg font-bold text-red-600">{{ number_format($estadisticas['promedio_faltas'], 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Distribución por Motivación</h3>
                        <div class="space-y-3">
                            @foreach($estadisticas['por_motivacion'] as $motivacion => $cantidad)
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-700">{{ $motivacion }}</span>
                                    <div class="flex items-center">
                                        <span class="text-sm font-bold mr-2">{{ $cantidad }}</span>
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="h-2 rounded-full 
                                                @if($motivacion === 'Alta') bg-green-500
                                                @elseif($motivacion === 'Media') bg-yellow-500
                                                @else bg-red-500 @endif" 
                                                style="width: {{ ($cantidad / $estadisticas['total_estudiantes']) * 100 }}%">
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-2">{{ number_format(($cantidad / $estadisticas['total_estudiantes']) * 100, 1) }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Distribución Socioeconómica -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Distribución por Nivel Socioeconómico</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($estadisticas['por_nivel_socioeconomico'] as $nivel => $cantidad)
                            <div class="text-center">
                                <div class="mx-auto w-32 h-32 rounded-full flex items-center justify-center text-white text-2xl font-bold
                                    @if($nivel === 'alto') bg-green-500
                                    @elseif($nivel === 'medio') bg-yellow-500
                                    @else bg-red-500 @endif">
                                    {{ $cantidad }}
                                </div>
                                <h4 class="mt-4 text-lg font-medium text-gray-900">{{ ucfirst($nivel) }}</h4>
                                <p class="text-sm text-gray-500">{{ number_format(($cantidad / $estadisticas['total_estudiantes']) * 100, 1) }}% del total</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Gráficos adicionales -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Análisis de Recursos Educativos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-4">Acceso a Recursos</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Con Internet y Dispositivo</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        {{ $estadisticas['con_recursos_completos'] }} estudiantes
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Con Limitaciones</span>
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                        {{ $estadisticas['con_dificultades'] }} estudiantes
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-4">Situación Familiar</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Situación Familiar Estable</span>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        {{ $estadisticas['total_estudiantes'] - $estadisticas['problemas_familiares'] }} estudiantes
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Con Problemas Familiares</span>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                        {{ $estadisticas['problemas_familiares'] }} estudiantes
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recomendaciones -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recomendaciones</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-blue-50 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">Apoyo Tecnológico</h4>
                            <p class="text-sm text-blue-700">
                                {{ $estadisticas['con_dificultades'] }} estudiantes necesitan apoyo con recursos tecnológicos (internet o dispositivos).
                            </p>
                        </div>

                        <div class="p-4 bg-yellow-50 rounded-lg">
                            <h4 class="font-medium text-yellow-900 mb-2">Apoyo Familiar</h4>
                            <p class="text-sm text-yellow-700">
                                {{ $estadisticas['problemas_familiares'] }} estudiantes podrían beneficiarse de apoyo psicológico o programas de tutoría.
                            </p>
                        </div>

                        @if($estadisticas['promedio_horas_estudio'] < 10)
                        <div class="p-4 bg-red-50 rounded-lg">
                            <h4 class="font-medium text-red-900 mb-2">Hábitos de Estudio</h4>
                            <p class="text-sm text-red-700">
                                El promedio de horas de estudio ({{ number_format($estadisticas['promedio_horas_estudio'], 1) }} hrs/semana) es bajo. Se recomienda implementar talleres de técnicas de estudio.
                            </p>
                        </div>
                        @endif

                        @if($estadisticas['promedio_faltas'] > 5)
                        <div class="p-4 bg-orange-50 rounded-lg">
                            <h4 class="font-medium text-orange-900 mb-2">Asistencia</h4>
                            <p class="text-sm text-orange-700">
                                El promedio de faltas ({{ number_format($estadisticas['promedio_faltas'], 1) }}) requiere atención. Considerar programas de seguimiento de asistencia.
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>