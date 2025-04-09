<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-gray-900 text-center">🎥 Agregar Nueva Película</h1>

        <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-800 font-semibold">Título:</label>
                <input type="text" name="titulo" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-600" required>
            </div>

            <div>
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
</div>


            <div>
                <label class="block text-gray-800 font-semibold">Duración (min):</label>
                <input type="number" name="duracion" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-600" required>
            </div>

            <div>
                <label class="block text-gray-800 font-semibold">Descripción:</label>
                <textarea name="descripcion" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-blue-500 focus:border-blue-600" required></textarea>
            </div>
            <div>
            <label class="block text-gray-800 font-semibold">Imagen de la Película:</label>
            <input type="file" name="imagen" accept="image/*" class="border border-gray-300 rounded-lg px-4 py-2 w-full">
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-6 rounded-lg shadow-md transition-all">
                    ✅ Guardar
                </button>
                <a href="{{ route('peliculas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition-all">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
