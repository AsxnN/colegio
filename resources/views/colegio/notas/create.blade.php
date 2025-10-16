{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\notas\create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nueva Nota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('notas.store') }}">
                    @csrf

                    <!-- Estudiante -->
                    <div class="mb-4">
                        <label for="estudiante_id" class="block text-sm font-medium text-gray-700">Estudiante *</label>
                        <select name="estudiante_id" id="estudiante_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">Seleccione un estudiante</option>
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->usuario->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('estudiante_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Curso -->
                    <div class="mb-4">
                        <label for="curso_id" class="block text-sm font-medium text-gray-700">Curso *</label>
                        <select name="curso_id" id="curso_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">Seleccione un curso</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre_completo }}
                                </option>
                            @endforeach
                        </select>
                        @error('curso_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <!-- Bimestre 1 -->
                        <div>
                            <label for="bimestre1" class="block text-sm font-medium text-gray-700">Bimestre 1 (0-20)</label>
                            <input type="number" name="bimestre1" id="bimestre1" value="{{ old('bimestre1') }}" 
                                   step="0.01" min="0" max="20"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            @error('bimestre1')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bimestre 2 -->
                        <div>
                            <label for="bimestre2" class="block text-sm font-medium text-gray-700">Bimestre 2 (0-20)</label>
                            <input type="number" name="bimestre2" id="bimestre2" value="{{ old('bimestre2') }}" 
                                   step="0.01" min="0" max="20"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            @error('bimestre2')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bimestre 3 -->
                        <div>
                            <label for="bimestre3" class="block text-sm font-medium text-gray-700">Bimestre 3 (0-20)</label>
                            <input type="number" name="bimestre3" id="bimestre3" value="{{ old('bimestre3') }}" 
                                   step="0.01" min="0" max="20"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            @error('bimestre3')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bimestre 4 -->
                        <div>
                            <label for="bimestre4" class="block text-sm font-medium text-gray-700">Bimestre 4 (0-20)</label>
                            <input type="number" name="bimestre4" id="bimestre4" value="{{ old('bimestre4') }}" 
                                   step="0.01" min="0" max="20"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            @error('bimestre4')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                        <p class="text-sm text-blue-700">
                            <strong>Nota:</strong> El promedio final se calculará automáticamente con las notas ingresadas.
                        </p>
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('notas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Registrar Nota
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>