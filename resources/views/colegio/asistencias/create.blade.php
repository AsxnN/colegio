{{-- filepath: c:\laragon\www\colegio\resources\views\colegio\asistencias\create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Asistencia Individual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('asistencias.store') }}">
                    @csrf

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

                    <div class="mb-4">
                        <label for="curso_id" class="block text-sm font-medium text-gray-700">Curso (Opcional)</label>
                        <select name="curso_id" id="curso_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                            <option value="">General</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('curso_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha *</label>
                        <input type="date" name="fecha" id="fecha" value="{{ old('fecha', today()->format('Y-m-d')) }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                        @error('fecha')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                        <div class="flex gap-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="presente" value="1" {{ old('presente', '1') == '1' ? 'checked' : '' }} required
                                       class="form-radio h-4 w-4 text-green-600">
                                <span class="ml-2">Presente</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="presente" value="0" {{ old('presente') == '0' ? 'checked' : '' }} required
                                       class="form-radio h-4 w-4 text-red-600">
                                <span class="ml-2">Ausente</span>
                            </label>
                        </div>
                        @error('presente')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="observacion" class="block text-sm font-medium text-gray-700">Observación</label>
                        <textarea name="observacion" id="observacion" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">{{ old('observacion') }}</textarea>
                        @error('observacion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4 mt-6">
                        <a href="{{ route('asistencias.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Registrar Asistencia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>