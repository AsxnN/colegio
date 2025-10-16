{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\notas\show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles de Nota') }}
            </h2>
            <a href="{{ route('notas.edit', $nota) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-600">Estudiante</p>
                        <p class="text-lg font-medium">{{ $nota->estudiante->usuario->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Curso</p>
                        <p class="text-lg font-medium">{{ $nota->curso->nombre }}</p>
                    </div>

                    @if($nota->curso->docente)
                        <div>
                            <p class="text-sm text-gray-600">Docente</p>
                            <p class="text-lg font-medium">{{ $nota->curso->docente->usuario->name }}</p>
                        </div>
                    @endif
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Calificaciones por Bimestre</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-1">Bimestre 1</p>
                            <p class="text-2xl font-bold {{ $nota->bimestre1 >= 14 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $nota->bimestre1 ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-1">Bimestre 2</p>
                            <p class="text-2xl font-bold {{ $nota->bimestre2 >= 14 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $nota->bimestre2 ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-1">Bimestre 3</p>
                            <p class="text-2xl font-bold {{ $nota->bimestre3 >= 14 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $nota->bimestre3 ?? '-' }}
                            </p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-sm text-gray-600 mb-1">Bimestre 4</p>
                            <p class="text-2xl font-bold {{ $nota->bimestre4 >= 14 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $nota->bimestre4 ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Promedio Final</p>
                                <p class="text-3xl font-bold text-blue-900 mt-1">
                                    {{ $nota->promedio_final ?? 'Sin calcular' }}
                                </p>
                            </div>
                            <div>
                                @if($nota->promedio_final)
                                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $nota->promedio_final >= 14 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $nota->estado }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('notas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>