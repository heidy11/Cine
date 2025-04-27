<x-app-layout>
    <div class="container mx-auto max-w-lg px-6 py-8 bg-white rounded-xl shadow-md">
        <h1 class="text-2xl font-bold text-[#220044] text-center mb-6">🎬 Agregar Nueva Película</h1>

        <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Título -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Título</label>
                <input type="text" name="titulo" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black">
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Descripción</label>
                <textarea name="descripcion" rows="4" required
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black"></textarea>
            </div>

            <!-- Duración -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Duración (en minutos)</label>
                <input type="number" name="duracion" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black">
            </div>

            <!-- Género -->
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Género</label>
                <select name="genero" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black">
                    <option value="">Seleccione un género</option>
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

            <!-- Imagen -->
            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Imagen (sube un archivo)</label>
                <input type="file" name="imagen" accept="image/*" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white">
            </div>

            <!-- Botones -->
            <div class="flex justify-between">
                <a href="{{ route('peliculas.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg">Cancelar</a>
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-400 text-[#220044] font-bold py-2 px-6 rounded-lg">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
