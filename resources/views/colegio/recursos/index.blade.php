{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\recursos\index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Recursos Educativos') }}
            </h2>
            <a href="{{ route('recursos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Agregar Recurso
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filtros -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-4">
                <form method="GET" action="{{ route('recursos.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Título del recurso..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Curso</label>
                        <select name="curso_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">Todos los cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ request('curso_id') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                        <select name="tipo" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">Todos los tipos</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Filtrar
                        </button>
                        <a href="{{ route('recursos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Grid de Recursos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($recursos as $recurso)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center">
                                    <span class="text-3xl mr-3">{{ $recurso->tipo_icono }}</span>
                                    <div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $recurso->tipo_color }}">
                                            {{ $recurso->tipo_nombre }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                {{ $recurso->titulo }}
                            </h3>

                            <p class="text-sm text-gray-600 mb-4">
                                <strong>Curso:</strong> {{ $recurso->curso->nombre }}
                            </p>

                            @if($recurso->descripcion)
                                <p class="text-sm text-gray-500 mb-4 line-clamp-3">
                                    {{ $recurso->descripcion }}
                                </p>
                            @endif

                            @if($recurso->url)
                                <div class="mb-4">
                                    <a href="{{ $recurso->url }}" target="_blank" 
                                       class="text-blue-500 hover:text-blue-700 text-sm break-all">
                                        🔗 Ver recurso
                                    </a>
                                </div>
                            @endif

                            <div class="text-xs text-gray-400 mb-4">
                                Agregado: {{ $recurso->created_at->format('d/m/Y H:i') }}
                            </div>

                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('recursos.show', $recurso) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Ver
                                </a>
                                <a href="{{ route('recursos.edit', $recurso) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 text-sm font-medium">
                                    Editar
                                </a>
                                <form action="{{ route('recursos.destroy', $recurso) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium"
                                            onclick="return confirm('¿Está seguro de eliminar este recurso?')">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500 text-lg">No se encontraron recursos educativos</p>
                        <a href="{{ route('recursos.create') }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">
                            Agregar el primer recurso
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $recursos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>