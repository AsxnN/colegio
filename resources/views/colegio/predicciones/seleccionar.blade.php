{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\predicciones\seleccionar.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Generar Predicción de Rendimiento') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('predicciones.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    ← Volver a Predicciones
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Mensajes de sesión -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-bold">✓ Éxito</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p class="font-bold">✗ Error</p>
                <p>{{ session('error') }}</p>
            </div>
            @endif

            <!-- Instrucciones -->
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg">
                <div class="flex items-start">
                    <div class="text-3xl mr-4">🤖</div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">
                            ¿Cómo funciona la predicción con IA?
                        </h3>
                        <p class="text-blue-800 mb-2">
                            Nuestro sistema utiliza <strong>Inteligencia Artificial</strong> para analizar el rendimiento académico de cada estudiante y generar predicciones personalizadas.
                        </p>
                        <ul class="text-sm text-blue-700 space-y-1 ml-4 list-disc">
                            <li>Analiza notas por curso y detecta tendencias</li>
                            <li>Evalúa el registro de asistencias</li>
                            <li>Identifica cursos críticos que requieren atención</li>
                            <li>Recomienda recursos educativos específicos</li>
                            <li>Genera un plan de mejora personalizado</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Selector de Estudiantes -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-2xl mr-2">👨‍🎓</span>
                    Selecciona un Estudiante
                </h3>
                
                @if($estudiantes->count() > 0)
                    <!-- Buscador -->
                    <div class="mb-6">
                        <input type="text" 
                               id="searchStudent" 
                               placeholder="🔍 Buscar estudiante por nombre..."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Botón para generar todas -->
                    <div class="mb-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">¿Quieres generar predicciones para todos?</h4>
                                <p class="text-sm text-gray-600">
                                    Genera predicciones automáticas para todos los estudiantes con notas registradas.
                                </p>
                            </div>
                            <form action="{{ route('predicciones.generar-todas') }}" method="POST" 
                                  onsubmit="return confirm('⚠️ ¿Generar predicciones para todos los estudiantes?\n\nEsto puede tomar varios minutos y consumirá tokens de la API.\n\n¿Deseas continuar?')">
                                @csrf
                                <button type="submit" 
                                        class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg whitespace-nowrap">
                                    🚀 Generar Todas
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Grid de estudiantes -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="studentsGrid">
                        @foreach($estudiantes as $estudiante)
                            <div class="student-card border border-gray-200 rounded-lg p-4 hover:shadow-lg transition-shadow duration-200 bg-gradient-to-br from-white to-gray-50"
                                 data-student-name="{{ strtolower($estudiante->usuario->name) }}"
                                 data-student-id="{{ $estudiante->id }}">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="text-4xl mr-3">👤</div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 text-lg">
                                                {{ $estudiante->usuario->name }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                📚 {{ $estudiante->seccion->nombre_completo ?? 'Sin sección' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información adicional -->
                                <div class="mt-3 pt-3 border-t border-gray-200 space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">📝 Cursos con notas:</span>
                                        <span class="font-semibold text-gray-900">{{ $estudiante->notas->count() }}</span>
                                    </div>
                                    
                                    @php
                                        $promedioGeneral = $estudiante->notas->avg('promedio_final');
                                    @endphp
                                    
                                    @if($promedioGeneral)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">📊 Promedio actual:</span>
                                            <span class="font-bold
                                                @if($promedioGeneral >= 17) text-green-600
                                                @elseif($promedioGeneral >= 14) text-blue-600
                                                @elseif($promedioGeneral >= 11) text-yellow-600
                                                @else text-red-600
                                                @endif">
                                                {{ number_format($promedioGeneral, 2) }}
                                            </span>
                                        </div>
                                    @endif

                                    @php
                                        $ultimaPrediccion = $estudiante->predicciones()->latest('fecha_prediccion')->first();
                                    @endphp

                                    @if($ultimaPrediccion)
                                        <div class="mt-2 p-2 bg-blue-50 rounded text-xs text-blue-800">
                                            <strong>Última predicción:</strong><br>
                                            {{ $ultimaPrediccion->fecha_prediccion->diffForHumans() }}
                                            ({{ number_format($ultimaPrediccion->probabilidad_aprobar, 1) }}% probabilidad)
                                        </div>
                                    @endif
                                </div>

                                <!-- Botón para generar predicción -->
                                <form action="{{ route('predicciones.generar', $estudiante->id) }}" 
                                      method="POST" 
                                      class="mt-4 form-generar"
                                      data-nombre="{{ $estudiante->usuario->name }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                                        @if($ultimaPrediccion)
                                            🔄 Regenerar Predicción
                                        @else
                                            🎯 Generar Predicción
                                        @endif
                                    </button>
                                </form>

                                @if($ultimaPrediccion)
                                    <a href="{{ route('predicciones.show', $ultimaPrediccion->id) }}" 
                                       class="block w-full text-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg mt-2">
                                        👁️ Ver Última Predicción
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Mensaje cuando no hay resultados de búsqueda -->
                    <div id="noResults" class="hidden text-center py-8">
                        <div class="text-6xl mb-4">🔍</div>
                        <p class="text-gray-600 text-lg">No se encontraron estudiantes con ese nombre</p>
                    </div>

                @else
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">📚</div>
                        <p class="text-gray-600 text-lg mb-2">No hay estudiantes con notas registradas</p>
                        <p class="text-gray-500 text-sm">Primero debes registrar notas para los estudiantes</p>
                        <a href="{{ route('notas.index') }}" class="inline-block mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ir a Notas
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Buscador de estudiantes
            const searchInput = document.getElementById('searchStudent');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const cards = document.querySelectorAll('.student-card');
                    const noResults = document.getElementById('noResults');
                    const studentsGrid = document.getElementById('studentsGrid');
                    let visibleCount = 0;

                    cards.forEach(card => {
                        const studentName = card.getAttribute('data-student-name');
                        if (studentName.includes(searchTerm)) {
                            card.style.display = 'block';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Mostrar mensaje si no hay resultados
                    if (visibleCount === 0 && searchTerm !== '') {
                        noResults.classList.remove('hidden');
                        studentsGrid.classList.add('hidden');
                    } else {
                        noResults.classList.add('hidden');
                        studentsGrid.classList.remove('hidden');
                    }
                });
            }

            // Manejo de formularios de generación
            const forms = document.querySelectorAll('.form-generar');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const nombre = this.getAttribute('data-nombre');
                    const button = this.querySelector('button[type="submit"]');
                    
                    console.log('=== FORMULARIO ENVIADO ===');
                    console.log('Estudiante:', nombre);
                    console.log('Action:', this.action);
                    
                    if (!confirm(`🤖 ¿Generar predicción con IA para ${nombre}?\n\nEsto analizará todas sus notas y generará un reporte completo.`)) {
                        e.preventDefault();
                        console.log('❌ Usuario canceló');
                        return false;
                    }
                    
                    console.log('✅ Generando predicción...');
                    
                    // Deshabilitar botón y mostrar loading
                    button.disabled = true;
                    button.innerHTML = '⏳ Generando predicción con IA...';
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                });
            });
        });
    </script>
</x-app-layout>