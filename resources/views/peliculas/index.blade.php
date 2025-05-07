<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6">

        <h1 class="text-5xl font-extrabold text-center text-yellow-400 mb-10">
            🎬 Películas Disponibles
        </h1>

        <!-- Botón agregar -->
        <div class="flex justify-end mb-8">
            <a href="{{ route('peliculas.create') }}" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-2xl shadow-md transform hover:scale-105 transition">
                ➕ Agregar Película
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 border border-green-400 px-6 py-4 rounded-lg mb-8 shadow-md text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow-2xl">
            <table class="min-w-full table-auto">
                <thead class="bg-[#220044] text-yellow-400">
                    <tr>
                        <th class="py-4 px-6 text-center">Título</th>
                        <th class="py-4 px-6 text-center">Género</th>
                        <th class="py-4 px-6 text-center">Duración</th>
                        <th class="py-4 px-6 text-center">Descripción</th>
                        <th class="py-4 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peliculas as $pelicula)
                        <tr class="border-b hover:bg-gray-100 text-center">
                            <td class="px-6 py-4 text-[#220044] font-semibold">{{ $pelicula->titulo }}</td>
                            <td class="px-6 py-4 text-[#220044]">{{ $pelicula->genero }}</td>
                            <td class="px-6 py-4 text-[#220044]">{{ $pelicula->duracion }} min</td>
                            <td class="px-6 py-4 text-[#220044]">{{ Str::limit($pelicula->descripcion, 50) }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-3">
                                    <a href="{{ route('peliculas.edit', $pelicula) }}" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition">
                                        ✏️ Editar
                                    </a>
                                    <form action="{{ route('peliculas.destroy', $pelicula) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition">
                                            ❌ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
