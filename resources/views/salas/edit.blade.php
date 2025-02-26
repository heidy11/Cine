<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-4 text-gray-800">Editar Sala</h1>

        <form action="{{ route('salas.update', $sala) }}" method="POST" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-gray-700 font-semibold">Nombre:</label>
                <input type="text" name="nombre" value="{{ $sala->nombre }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-300 focus:border-yellow-500" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Capacidad:</label>
                <input type="number" name="capacidad" value="{{ $sala->capacidad }}" class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-yellow-300 focus:border-yellow-500" required>
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-4 rounded shadow-md">
                    ✏️ Actualizar
                </button>
                <a href="{{ route('salas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded shadow-md">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
