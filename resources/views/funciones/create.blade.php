<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎭 Agregar Nueva Función</h1>

        <form action="{{ route('funciones.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-black font-semibold">Película:</label>
                <select name="pelicula_id" id="pelicula_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    <option value="" disabled selected>Seleccione una película</option>
                    @foreach($peliculas as $pelicula)
                        <option value="{{ $pelicula->id_pelicula }}">{{ $pelicula->titulo }}</option> <!-- Guarda el ID pero muestra el nombre -->
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-black font-semibold">Sala:</label>
                <select name="sala_id" id="sala_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    <option value="" disabled selected>Seleccione una sala</option>
                    @foreach($salas as $sala)
                        <option value="{{ $sala->id_sala }}">{{ $sala->nombre }}</option> <!-- Guarda el ID pero muestra el nombre -->
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-black font-semibold">Hora de Inicio:</label>
                <input type="datetime-local" name="hora_inicio" id="hora_inicio" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-6 rounded-lg shadow-md">
                    ✅ Guardar
                </button>
                <a href="{{ route('funciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-black font-semibold py-2 px-6 rounded-lg shadow-md">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
