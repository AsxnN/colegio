{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\predicciones\dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard de Predicciones') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('predicciones.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    📋 Ver Todas
                </a>
                <a href="{{ route('predicciones.seleccionar') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Nueva Predicción
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Estadísticas Principales -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Estudiantes -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Total Estudiantes</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $totalEstudiantes }}</p>
                        </div>
                    </div>
                </div>

                <!-- Con Predicción -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Con Predicción</p>
                            <p class="text-3xl font-bold text-green-600">{{ $conPrediccion }}</p>
                            <p class="text-xs text-gray-500">{{ $totalEstudiantes > 0 ? round(($conPrediccion / $totalEstudiantes) * 100, 1) : 0 }}%</p>
                        </div>
                    </div>
                </div>

                <!-- Riesgo Alto -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 mr-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Riesgo Alto</p>
                            <p class="text-3xl font-bold text-red-600">{{ $enRiesgoAlto }}</p>
                            <p class="text-xs text-gray-500">Requieren atención urgente</p>
                        </div>
                    </div>
                </div>

                <!-- Riesgo Medio -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase">Riesgo Medio</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $enRiesgoMedio }}</p>
                            <p class="text-xs text-gray-500">Necesitan seguimiento</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Distribución de Riesgo -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="text-2xl mr-2">📊</span>
                    Distribución de Niveles de Riesgo
                </h3>
                
                <div class="space-y-4">
                    <!-- Riesgo Bajo -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-green-700 flex items-center">
                                <span class="text-xl mr-2">🟢</span>
                                Riesgo Bajo (≥ 75%)
                            </span>
                            <span class="text-sm font-bold text-green-700">{{ $bajoriesgo }} estudiantes</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-green-500 h-4 rounded-full transition-all duration-500" 
                                 style="width: {{ $conPrediccion > 0 ? ($bajoriesgo / $conPrediccion) * 100 : 0 }}%">
                            </div>
                        </div>
                        <div class="text-right text-xs text-gray-500 mt-1">
                            {{ $conPrediccion > 0 ? round(($bajoriesgo / $conPrediccion) * 100, 1) : 0 }}%
                        </div>
                    </div>

                    <!-- Riesgo Medio -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-yellow-700 flex items-center">
                                <span class="text-xl mr-2">🟡</span>
                                Riesgo Medio (50-74%)
                            </span>
                            <span class="text-sm font-bold text-yellow-700">{{ $enRiesgoMedio }} estudiantes</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-yellow-500 h-4 rounded-full transition-all duration-500" 
                                 style="width: {{ $conPrediccion > 0 ? ($enRiesgoMedio / $conPrediccion) * 100 : 0 }}%">
                            </div>
                        </div>
                        <div class="text-right text-xs text-gray-500 mt-1">
                            {{ $conPrediccion > 0 ? round(($enRiesgoMedio / $conPrediccion) * 100, 1) : 0 }}%
                        </div>
                    </div>

                    <!-- Riesgo Alto -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-red-700 flex items-center">
                                <span class="text-xl mr-2">🔴</span>
                                Riesgo Alto (< 50%)
                            </span>
                            <span class="text-sm font-bold text-red-700">{{ $enRiesgoAlto }} estudiantes</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-red-500 h-4 rounded-full transition-all duration-500" 
                                 style="width: {{ $conPrediccion > 0 ? ($enRiesgoAlto / $conPrediccion) * 100 : 0 }}%">
                            </div>
                        </div>
                        <div class="text-right text-xs text-gray-500 mt-1">
                            {{ $conPrediccion > 0 ? round(($enRiesgoAlto / $conPrediccion) * 100, 1) : 0 }}%
                        </div>
                    </div>
                </div>
            </div>

            <!-- Predicciones Recientes -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <span class="text-2xl mr-2">🕐</span>
                        Predicciones Recientes
                    </h3>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @forelse($prediccionesRecientes as $prediccion)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 flex-1">
                                    <div class="text-4xl">👤</div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-900">
                                            {{ $prediccion->estudiante->usuario->name }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $prediccion->estudiante->seccion->nombre_completo ?? 'Sin sección' }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            📅 {{ $prediccion->fecha_prediccion->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-6">
                                    <!-- Probabilidad -->
                                    <div class="text-center">
                                        <div class="text-2xl font-bold
                                            @if($prediccion->probabilidad_aprobar >= 75) text-green-600
                                            @elseif($prediccion->probabilidad_aprobar >= 50) text-yellow-600
                                            @else text-red-600
                                            @endif">
                                            {{ number_format($prediccion->probabilidad_aprobar, 0) }}%
                                        </div>
                                        <div class="text-xs text-gray-500">Probabilidad</div>
                                    </div>

                                    <!-- Estado -->
                                    <div class="text-center min-w-[100px]">
                                        @if($prediccion->prediccion_binaria)
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                ✅ Aprobará
                                            </span>
                                        @else
                                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                ⚠️ En Riesgo
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Nivel de Riesgo -->
                                    <div class="text-center min-w-[80px]">
                                        <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full
                                            @if($prediccion->nivel_riesgo == 'Bajo') bg-green-100 text-green-800
                                            @elseif($prediccion->nivel_riesgo == 'Medio') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            @if($prediccion->nivel_riesgo == 'Bajo') 🟢
                                            @elseif($prediccion->nivel_riesgo == 'Medio') 🟡
                                            @else 🔴
                                            @endif
                                            {{ $prediccion->nivel_riesgo }}
                                        </span>
                                    </div>

                                    <!-- Acciones -->
                                    <div>
                                        <a href="{{ route('predicciones.show', $prediccion->id) }}" 
                                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            Ver Detalle
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="text-6xl mb-4">🤖</div>
                            <p class="text-gray-500 text-lg mb-4">No hay predicciones generadas aún</p>
                            <a href="{{ route('predicciones.seleccionar') }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                Generar Primera Predicción
                            </a>
                        </div>
                    @endforelse
                </div>

                @if($prediccionesRecientes->count() > 0)
                    <div class="p-4 bg-gray-50 text-center">
                        <a href="{{ route('predicciones.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                            Ver todas las predicciones →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Alertas y Recomendaciones -->
            @if($enRiesgoAlto > 0)
            <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <div class="text-3xl mr-4">🚨</div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-red-900 mb-2">
                            ¡Atención Requerida!
                        </h3>
                        <p class="text-red-800 mb-4">
                            Hay <strong>{{ $enRiesgoAlto }} estudiante(s)</strong> con alto riesgo de reprobar el año escolar. 
                            Se recomienda intervención inmediata del equipo docente y tutores.
                        </p>
                        <a href="{{ route('predicciones.index', ['riesgo' => 'alto']) }}" 
                           class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-block">
                            Ver Estudiantes en Riesgo Alto
                        </a>
                    </div>
                </div>
            </div>
            @endif

            @if($enRiesgoMedio > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg">
                <div class="flex items-start">
                    <div class="text-3xl mr-4">⚠️</div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-yellow-900 mb-2">
                            Seguimiento Necesario
                        </h3>
                        <p class="text-yellow-800 mb-4">
                            Hay <strong>{{ $enRiesgoMedio }} estudiante(s)</strong> con riesgo medio. 
                            Se recomienda monitoreo constante y apoyo académico preventivo.
                        </p>
                        <a href="{{ route('predicciones.index', ['riesgo' => 'medio']) }}" 
                           class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded inline-block">
                            Ver Estudiantes en Riesgo Medio
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Información sobre el sistema -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-start">
                    <div class="text-4xl mr-4">🤖</div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">
                            Sistema de Predicción con IA
                        </h3>
                        <p class="text-gray-700 mb-4">
                            Este sistema utiliza <strong>Google Gemini AI</strong> para analizar el rendimiento académico, 
                            asistencia y recursos educativos de cada estudiante, generando predicciones precisas y 
                            recomendaciones personalizadas para mejorar el desempeño estudiantil.
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-white p-4 rounded-lg">
                                <div class="text-2xl mb-2">📊</div>
                                <h4 class="font-semibold text-gray-900 mb-1">Análisis Completo</h4>
                                <p class="text-sm text-gray-600">Evalúa notas, asistencia y tendencias</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg">
                                <div class="text-2xl mb-2">💡</div>
                                <h4 class="font-semibold text-gray-900 mb-1">Recomendaciones</h4>
                                <p class="text-sm text-gray-600">Sugerencias personalizadas de mejora</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg">
                                <div class="text-2xl mb-2">📚</div>
                                <h4 class="font-semibold text-gray-900 mb-1">Recursos</h4>
                                <p class="text-sm text-gray-600">Materiales educativos recomendados</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>