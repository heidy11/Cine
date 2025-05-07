<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6 flex items-center justify-center">

        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-2xl">
            <h1 class="text-4xl font-extrabold text-center text-[#220044] mb-8">
                ➕ Agregar Nueva Película
            </h1>

            <form action="{{ route('peliculas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Título -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Título</label>
                    <input type="text" name="titulo" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500">
                </div>

                <!-- Descripción -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" rows="4" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500"></textarea>
                </div>

                <!-- Duración -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Duración (minutos)</label>
                    <input type="number" name="duracion" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500">
                </div>

                <!-- Género -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Género</label>
                    <select name="genero" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full text-black">
                        <option value="">Seleccione un género</option>
                        @foreach(['Acción', 'Comedia', 'Drama', 'Terror', 'Animación', 'Fantasía', 'Ciencia ficción', 'Romance', 'Documental'] as $genero)
                            <option value="{{ $genero }}">{{ $genero }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Imagen -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Imagen (archivo)</label>
                    <input type="file" name="imagen" accept="image/*" required
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full bg-white text-black">
                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <a href="{{ route('peliculas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                        ❌ Cancelar
                    </a>
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                        ✅ Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>
