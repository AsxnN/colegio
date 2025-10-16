<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🎯 Predicciones de Rendimiento con IA
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('predicciones.seleccionar') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    ➕ Nueva Predicción
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
                <p class="font-bold">✓ Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                <p class="font-bold">✗ Error</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if($predicciones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sección</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Probabilidad</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Riesgo</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Predicción</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($predicciones as $prediccion)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-2xl mr-3">👨‍🎓</div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $prediccion->estudiante->usuario->name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $prediccion->estudiante->seccion->nombre_completo ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    {{ $prediccion->fecha_prediccion->format('d/m/Y') }}<br>
                                    <span class="text-xs text-gray-400">{{ $prediccion->fecha_prediccion->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-2xl font-bold
                                        @if($prediccion->probabilidad_aprobar >= 70) text-green-600
                                        @elseif($prediccion->probabilidad_aprobar >= 50) text-yellow-600
                                        @else text-red-600
                                        @endif">
                                        {{ number_format($prediccion->probabilidad_aprobar, 1) }}%
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if($prediccion->nivel_riesgo === 'Bajo') bg-green-100 text-green-800
                                        @elseif($prediccion->nivel_riesgo === 'Medio') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $prediccion->icono_riesgo }} {{ $prediccion->nivel_riesgo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($prediccion->prediccion_binaria)
                                        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                            ✅ Aprobará
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                            ⚠️ En Riesgo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('predicciones.show', $prediccion->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 mr-3">
                                        👁️ Ver
                                    </a>
                                    <form action="{{ route('predicciones.destroy', $prediccion->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('¿Eliminar esta predicción?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50">
                    {{ $predicciones->links() }}
                </div>

                @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🤖</div>
                    <p class="text-gray-600 text-lg mb-2">No hay predicciones generadas aún</p>
                    <p class="text-gray-500 text-sm mb-4">Comienza generando predicciones para tus estudiantes</p>
                    <a href="{{ route('predicciones.seleccionar') }}" 
                       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        ➕ Generar Primera Predicción
                    </a>
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>