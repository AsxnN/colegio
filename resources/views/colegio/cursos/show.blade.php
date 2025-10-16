{{-- filepath: c:\laragon\www\colegio\resources\views\cursos\show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Curso') }}
            </h2>
            <a href="{{ route('cursos.edit', $curso) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Nombre</p>
                        <p class="text-lg font-medium">{{ $curso->nombre }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Código</p>
                        <p class="text-lg font-medium">{{ $curso->codigo ?? 'Sin código' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Docente Asignado</p>
                        <p class="text-lg font-medium">{{ $curso->docente ? $curso->docente->usuario->name : 'Sin asignar' }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Fecha de Creación</p>
                        <p class="text-lg font-medium">{{ $curso->created_at->format('d/m/Y') }}</p>
                    </div>
                    
                    @if($curso->descripcion)
                        <div class="col-span-2">
                            <p class="text-sm text-gray-600">Descripción</p>
                            <p class="text-base mt-1">{{ $curso->descripcion }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-6">
                    <a href="{{ route('cursos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>