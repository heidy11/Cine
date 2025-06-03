<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6 flex items-center justify-center">

        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
            <h1 class="text-4xl font-extrabold text-center text-[#220044] mb-8">
                ✏️ Editar Película
            </h1>

            <form action="{{ route('peliculas.update', $pelicula->id_pelicula) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Título -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $pelicula->titulo) }}" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500">
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" rows="4" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500">{{ old('descripcion', $pelicula->descripcion) }}</textarea>
                </div>

                <!-- Duración -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Duración (minutos)</label>
                    <input type="number" name="duracion" value="{{ old('duracion', $pelicula->duracion) }}" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500">
                </div>


                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Director</label>
                    <input type="text" name="director" id="director" value="{{ old('director', $pelicula->director) }}" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500">
                </div>

                <!-- Género -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Género</label>
                    <select name="genero" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full text-black">
                        <option value="">Seleccione un género</option>
                        @foreach(['Acción', 'Comedia', 'Drama', 'Terror', 'Animación', 'Fantasía', 'Ciencia ficción', 'Romance', 'Documental'] as $genero)
                            <option value="{{ $genero }}" {{ old('genero', $pelicula->genero) == $genero ? 'selected' : '' }}>
                                {{ $genero }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Imagen (opcional)</label>
                    <input type="file" name="imagen"
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full bg-white text-black">

                    @if ($pelicula->imagen)
                        <p class="text-sm text-gray-600 mt-2">Imagen actual:</p>
                        <img src="{{ asset($pelicula->imagen) }}" alt="Imagen actual" class="w-40 h-auto mt-2 rounded">
                    @endif
                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <a href="{{ route('peliculas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                        ❌ Cancelar
                    </a>
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                        ✅ Guardar cambios
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
