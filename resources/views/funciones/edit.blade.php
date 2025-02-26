<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">✏️ Editar Función</h1>

        <form action="{{ route('funciones.update', $funcion) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-black font-semibold">Película:</label>
                <select name="pelicula_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600 text-black" required>
                    @foreach($peliculas as $pelicula)
                        <option value="{{ $pelicula->id }}" {{ $pelicula->id == $funcion->pelicula_id ? 'selected' : '' }}>
                            {{ $pelicula->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-black font-semibold">Sala:</label>
                <select name="sala_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600 text-black" required>
                    @foreach($salas as $sala)
                        <option value="{{ $sala->id }}" {{ $sala->id == $funcion->sala_id ? 'selected' : '' }}>
                            {{ $sala->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-black font-semibold">Hora de Inicio:</label>
                <input type="datetime-local" name="hora_inicio" value="{{ $funcion->hora_inicio }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-500 focus:border-yellow-600 text-black" required>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-2 px-6 rounded-lg shadow-md transition-all">
                    ✏️ Actualizar
                </button>
                <a href="{{ route('funciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-black font-semibold py-2 px-6 rounded-lg shadow-md transition-all">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
