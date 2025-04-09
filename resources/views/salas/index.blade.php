<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4 text-white-800">Listado de Salas</h1>

        <a href="{{ route('salas.create') }}" class="bg-blue-600 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded shadow-md">
            ➕ Crear Sala
        </a>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-6 border-collapse border border-gray-300 shadow-lg">
            <thead>
                <tr class="bg-gray-300 text-gray-800">
                    <th class="border border-gray-400 px-4 py-2">Nombre</th>
                    <th class="border border-gray-400 px-4 py-2">Capacidad</th>
                    <th class="border border-gray-400 px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salas as $sala)
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $sala->nombre }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">{{ $sala->capacidad }}</td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="{{ route('salas.edit', $sala) }}" class="bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1 rounded shadow-md mr-2">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('salas.destroy', $sala) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow-md">
                                    ❌ Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
