<x-app-layout>
    <div class="container mx-auto max-w-lg px-6 py-8 bg-white rounded-xl shadow-md">
        <h1 class="text-2xl font-bold text-[#220044] text-center mb-6">🎬 Editar Película</h1>

        <form action="{{ route('peliculas.update', $pelicula->id_pelicula) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Título -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $pelicula->titulo) }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black">
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea name="descripcion" rows="4" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black">{{ old('descripcion', $pelicula->descripcion) }}</textarea>
            </div>

            <!-- Duración -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Duración (minutos)</label>
                <input type="number" name="duracion" value="{{ old('duracion', $pelicula->duracion) }}" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black">
            </div>

            <!-- Género -->
            <div class="mb-4">
                <label class="block text-gray-800 font-semibold mb-2">Género</label>
                <select name="genero" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    <option value="">-- Selecciona un género --</option>
                    @foreach(['Acción', 'Comedia', 'Drama', 'Terror', 'Animación', 'Fantasía', 'Ciencia ficción', 'Romance', 'Documental'] as $genero)
                        <option value="{{ $genero }}" {{ old('genero', $pelicula->genero) == $genero ? 'selected' : '' }}>{{ $genero }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Imagen -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Imagen (subir nueva si quieres cambiarla)</label>
                <input type="file" name="imagen"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white">
                @if ($pelicula->imagen)
                    <p class="text-sm text-gray-600 mt-2">Imagen actual:</p>
                    <img src="{{ asset($pelicula->imagen) }}" alt="Imagen actual" class="w-40 h-auto mt-2 rounded">
                @endif
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('peliculas.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg">Cancelar</a>
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-400 text-[#220044] font-bold py-2 px-6 rounded-lg">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
