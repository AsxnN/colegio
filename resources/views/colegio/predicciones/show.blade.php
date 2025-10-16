<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎯 Predicción de Rendimiento - {{ $prediccion->estudiante->usuario->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('predicciones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Volver
                </a>
                <form action="{{ route('predicciones.destroy', $prediccion->id) }}" method="POST" 
                      onsubmit="return confirm('¿Estás seguro de eliminar esta predicción?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        🗑️ Eliminar
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Información del Estudiante --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="text-6xl">👨‍🎓</div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $prediccion->estudiante->usuario->name }}</h3>
                            <p class="text-gray-600">{{ $prediccion->estudiante->seccion->nombre_completo ?? 'Sin sección' }}</p>
                            <p class="text-sm text-gray-500">Predicción generada: {{ $prediccion->fecha_prediccion->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    {{-- Badge de Riesgo --}}
                    <div class="text-center">
                        <div class="text-6xl mb-2">{{ $prediccion->icono_riesgo }}</div>
                        <span class="inline-flex items-center px-6 py-3 rounded-full text-lg font-bold
                            @if($prediccion->nivel_riesgo === 'Bajo') bg-green-100 text-green-800
                            @elseif($prediccion->nivel_riesgo === 'Medio') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800
                            @endif">
                            Riesgo {{ $prediccion->nivel_riesgo }}
                        </span>
                    </div>
                </div>

                {{-- Probabilidad de Aprobar --}}
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">📊 Probabilidad de Aprobar el Año</h4>
                            <p class="text-4xl font-bold 
                                @if($prediccion->probabilidad_aprobar >= 70) text-green-600
                                @elseif($prediccion->probabilidad_aprobar >= 50) text-yellow-600
                                @else text-red-600
                                @endif">
                                {{ number_format($prediccion->probabilidad_aprobar, 2) }}%
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600 mb-1">Predicción:</p>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                                @if($prediccion->prediccion_binaria) bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($prediccion->prediccion_binaria)
                                    ✅ Aprobará el año
                                @else
                                    ⚠️ En riesgo de reprobar
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    {{-- Barra de progreso --}}
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                            <div class="h-4 rounded-full transition-all duration-500
                                @if($prediccion->probabilidad_aprobar >= 70) bg-green-500
                                @elseif($prediccion->probabilidad_aprobar >= 50) bg-yellow-500
                                @else bg-red-500
                                @endif"
                                style="width: {{ $prediccion->probabilidad_aprobar }}%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Análisis Detallado de la IA --}}
            @if($prediccion->analisis)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl">🤖</div>
                    <h3 class="text-2xl font-bold text-gray-900">Análisis Detallado por Inteligencia Artificial</h3>
                </div>
                <div class="prose max-w-none">
                    <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border-l-4 border-purple-500">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $prediccion->analisis }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Fortalezas y Debilidades --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Fortalezas --}}
                @if($prediccion->fortalezas && count($prediccion->fortalezas) > 0)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-4xl">💪</div>
                        <h3 class="text-xl font-bold text-green-700">Fortalezas Identificadas</h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach($prediccion->fortalezas as $fortaleza)
                        <li class="flex items-start gap-2 bg-green-50 p-3 rounded-lg border-l-4 border-green-500">
                            <span class="text-green-600 font-bold">✓</span>
                            <span class="text-gray-800">{{ $fortaleza }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Debilidades --}}
                @if($prediccion->debilidades && count($prediccion->debilidades) > 0)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="text-4xl">📉</div>
                        <h3 class="text-xl font-bold text-orange-700">Áreas de Mejora</h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach($prediccion->debilidades as $debilidad)
                        <li class="flex items-start gap-2 bg-orange-50 p-3 rounded-lg border-l-4 border-orange-500">
                            <span class="text-orange-600 font-bold">⚠</span>
                            <span class="text-gray-800">{{ $debilidad }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            {{-- Cursos Críticos --}}
            @if($prediccion->cursos_criticos && count($prediccion->cursos_criticos) > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl">🚨</div>
                    <h3 class="text-xl font-bold text-red-700">Cursos que Requieren Atención Urgente</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($prediccion->cursos_criticos as $curso)
                    <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                        <p class="font-bold text-red-800 text-lg">📚 {{ $curso }}</p>
                        <p class="text-sm text-red-600 mt-1">Requiere refuerzo inmediato</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recomendaciones Generales --}}
            @if($prediccion->recomendaciones_generales && count($prediccion->recomendaciones_generales) > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl">💡</div>
                    <h3 class="text-xl font-bold text-blue-700">Recomendaciones Generales</h3>
                </div>
                <div class="space-y-3">
                    @foreach($prediccion->recomendaciones_generales as $index => $recomendacion)
                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <div class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                                {{ $index + 1 }}
                            </span>
                            <p class="text-gray-800 flex-1">{{ $recomendacion }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Recursos Educativos Recomendados --}}
            @if($prediccion->recursos_recomendados && count($prediccion->recursos_recomendados) > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl">📚</div>
                    <h3 class="text-xl font-bold text-indigo-700">Recursos Educativos Recomendados</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($prediccion->recursos_recomendados as $recurso)
                    <div class="bg-indigo-50 p-5 rounded-lg border border-indigo-200 hover:shadow-lg transition-shadow">
                        <div class="flex items-start gap-3">
                            <div class="text-3xl">📖</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-indigo-900 text-lg mb-1">{{ $recurso['recurso'] }}</h4>
                                <p class="text-sm text-indigo-700 mb-2">
                                    <strong>Curso:</strong> {{ $recurso['curso'] }}
                                </p>
                                <p class="text-sm text-gray-700 bg-white p-2 rounded">
                                    <strong>Por qué:</strong> {{ $recurso['razon'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Plan de Mejora --}}
            @if($prediccion->plan_mejora)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl">🎯</div>
                    <h3 class="text-xl font-bold text-purple-700">Plan de Mejora Personalizado</h3>
                </div>
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-6 border border-purple-200">
                    <div class="prose max-w-none">
                        <p class="text-gray-800 leading-relaxed whitespace-pre-line">{{ $prediccion->plan_mejora }}</p>
                    </div>
                </div>
            </div>
            @endif

            {{-- Notas del Estudiante --}}
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-4xl">📊</div>
                    <h3 class="text-xl font-bold text-gray-900">Notas Actuales</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bim 1</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bim 2</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bim 3</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bim 4</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Promedio</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($prediccion->estudiante->notas as $nota)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $nota->curso->nombre }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $nota->bimestre1 ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $nota->bimestre2 ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $nota->bimestre3 ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">{{ $nota->bimestre4 ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="px-3 py-1 rounded-full font-bold
                                        @if($nota->promedio_final >= 14) bg-green-100 text-green-800
                                        @elseif($nota->promedio_final >= 11) bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ number_format($nota->promedio_final, 2) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No hay notas registradas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>