<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-100 rounded-lg shadow-lg">
        <h1 class="text-4xl font-extrabold mb-6 text-gray-900 text-center">🎬 Películas Disponibles</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('peliculas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-5 rounded-lg shadow-md transition-all">
                ➕ Agregar Película
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-black font-semibold px-4 py-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-500 text-black uppercase text-sm">
                    <tr>
                        <th class="py-3 px-6 text-left text-black">Título</th>
                        <th class="py-3 px-6 text-left">Género</th>
                        <th class="py-3 px-6 text-left">Duración</th>
                        <th class="py-3 px-6 text-center">Descripción</th>
                        <th class="py-3 px-6 text-center">Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($peliculas as $pelicula)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-4 px-6">{{ $pelicula->titulo }}</td>
                            <td class="py-4 px-6">{{ $pelicula->genero }}</td>
                            <td class="py-4 px-6">{{ $pelicula->duracion }} min</td>
                            <td class="py-4 px-6">{{ $pelicula->descripcion }}</td>           
                            <td class="py-4 px-6 flex justify-center space-x-3">
                                <a href="{{ route('peliculas.edit', $pelicula) }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded-lg shadow-md transition-all">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('peliculas.destroy', $pelicula) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-blue font-semibold px-4 py-2 rounded-lg shadow-md transition-all">
                                        ❌ Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
