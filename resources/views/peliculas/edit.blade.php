<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-gray-900 text-center">✏️ Editar Película</h1>

        <form action="{{ route('peliculas.update', $pelicula) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-gray-800 font-semibold">Título:</label>
                <input type="text" name="titulo" value="{{ $pelicula->titulo }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600" required>
            </div>

            <div>
                <label class="block text-gray-800 font-semibold">Género:</label>
                <input type="text" name="genero" value="{{ $pelicula->genero }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600" required>
            </div>

            <div>
                <label class="block text-gray-800 font-semibold">Duración (min):</label>
                <input type="number" name="duracion" value="{{ $pelicula->duracion }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600" required>
            </div>

            <div>
                <label class="block text-gray-800 font-semibold">Descripción:</label>
                <textarea name="descripcion" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600" required>{{ $pelicula->descripcion }}</textarea>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-2 px-6 rounded-lg shadow-md transition-all">
                    ✏️ Actualizar
                </button>
                <a href="{{ route('peliculas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-all">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
