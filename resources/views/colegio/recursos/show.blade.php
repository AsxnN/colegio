{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\recursos\show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle del Recurso') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('recursos.edit', $recurso) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Editar
                </a>
                <a href="{{ route('recursos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <span class="text-5xl mr-4">{{ $recurso->tipo_icono }}</span>
                        <div>
                            <span class="px-3 py-1 text-sm font-semibold rounded {{ $recurso->tipo_color }}">
                                {{ $recurso->tipo_nombre }}
                            </span>
                        </div>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $recurso->titulo }}
                    </h1>
                    
                    <p class="text-lg text-gray-600">
                        <strong>Curso:</strong> {{ $recurso->curso->nombre }}
                    </p>
                </div>

                @if($recurso->descripcion)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Descripción</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $recurso->descripcion }}</p>
                    </div>
                @endif

                @if($recurso->url)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Enlace</h3>
                        <a href="{{ $recurso->url }}" target="_blank" 
                           class="text-blue-500 hover:text-blue-700 break-all text-lg">
                            🔗 {{ $recurso->url }}
                        </a>
                        
                        <div class="mt-4">
                            <a href="{{ $recurso->url }}" target="_blank" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded inline-block">
                                Abrir Recurso
                            </a>
                        </div>
                    </div>
                @endif

                <div class="border-t pt-4 mt-6">
                    <p class="text-sm text-gray-500">
                        <strong>Creado:</strong> {{ $recurso->created_at->format('d/m/Y H:i') }}
                    </p>
                    @if($recurso->updated_at)
                        <p class="text-sm text-gray-500">
                            <strong>Última actualización:</strong> {{ $recurso->updated_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>