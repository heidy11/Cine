<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6">

        <!-- Título principal -->
        <h1 class="text-4xl font-extrabold text-center text-yellow-400 mb-10">
            🏛️ Listado de Salas
        </h1>

        <!-- Botón crear sala -->
        <div class="flex justify-end mb-6">
            <a href="{{ route('salas.create') }}" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-6 rounded-2xl shadow-md transform hover:scale-105 transition">
                ➕ Crear Sala
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de salas -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow-2xl">
            <table class="min-w-full table-auto">
                <thead class="bg-[#220044] text-yellow-400">
                    <tr>
                        <th class="px-6 py-4 text-center text-lg">Nombre</th>
                        <th class="px-6 py-4 text-center text-lg">Capacidad</th>
                        <th class="px-6 py-4 text-center text-lg">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salas as $sala)
                        <tr class="border-b hover:bg-gray-100 text-center">
                            <td class="px-6 py-4 text-[#220044] font-semibold">{{ $sala->nombre }}</td>
                            <td class="px-6 py-4 text-[#220044] font-semibold">{{ $sala->capacidad }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center space-x-3">
                                    <!-- Editar -->
                                    <a href="{{ route('salas.edit', $sala) }}" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition">
                                        ✏️ Editar
                                    </a>

                                    <!-- Eliminar -->
                                    <form action="{{ route('salas.destroy', $sala) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition">
                                            ❌ Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                No hay salas registradas todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
