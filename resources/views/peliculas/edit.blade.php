<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-gray-900 text-center">✏️ Editar Película</h1>

        <form action="{{ route('peliculas.update', $pelicula-> id_pelicula) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-gray-800 font-semibold">Título:</label>
                <input type="text" name="titulo" value="{{ $pelicula->titulo }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600" required>
            </div>

            <div>
            <label class="block text-gray-800 font-semibold">Imagen actual:</label>
            <img src="{{ asset('storage/' . $pelicula->imagen) }}" class="w-48 h-60 object-cover rounded-lg mb-4">
            </div>

            <div>
            <label class="block text-gray-800 font-semibold">Subir nueva imagen:</label>
            <input type="file" name="imagen" accept="image/*" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>
            <label class="block text-gray-800 font-semibold">Género:</label>
    <select name="genero" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-600" required>
        <option value="">-- Selecciona un género --</option>
        <option value="Acción">Acción</option>
        <option value="Comedia">Comedia</option>
        <option value="Drama">Drama</option>
        <option value="Terror">Terror</option>
        <option value="Animación">Animación</option>
        <option value="Fantasía">Fantasía</option>
        <option value="Ciencia ficción">Ciencia ficción</option>
        <option value="Romance">Romance</option>
        <option value="Documental">Documental</option>
    </select>


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
