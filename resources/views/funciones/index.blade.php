<x-app-layout>
    <div class="container mx-auto p-6 bg-gray-100 rounded-lg shadow-lg">
        <h1 class="text-4xl font-extrabold mb-6 text-black text-center">🎭 Funciones Disponibles</h1>

        <div class="flex justify-end mb-4">
            <a href="{{ route('funciones.create') }}" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-5 rounded-lg shadow-md transition-all">
                ➕ Agregar Función
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
                        <th class="py-3 px-6 text-left text-black">Película</th>
                        <th class="py-3 px-6 text-left text-black">Sala</th>
                        <th class="py-3 px-6 text-left text-black">Hora de Inicio</th>
                        <th class="py-3 px-6 text-left text-black">Formato</th>
                        <th class="py-3 px-6 text-center text-black">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($funciones as $funcion)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-4 px-6 text-black">{{ $funcion->pelicula->titulo }}</td>
                            <td class="py-4 px-6 text-black">{{ $funcion->sala->nombre }}</td>
                            <td class="py-4 px-6 text-black">{{ $funcion->hora_inicio }}</td>
                            <td class="py-4 px-6 text-black">{{ $funcion->formato }}</td>
                            <td class="py-4 px-6 flex justify-center space-x-3">
                            <a href="{{ route('funciones.edit', ['funcion' => $funcion->id_funcion]) }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold px-4 py-2 rounded-lg shadow-md transition-all">
                                    ✏️ Editar
                                </a>
                                <form action="{{ route('funciones.destroy', $funcion->id_funcion) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-black font-semibold px-4 py-2 rounded-lg shadow-md transition-all">
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
