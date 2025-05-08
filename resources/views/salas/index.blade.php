<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6 text-white">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-extrabold">🎬 Salas Registradas</h1>
                <a href="{{ route('salas.create') }}"
                   class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                    ➕ Nueva Sala
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($salas as $sala)
                    <div class="bg-white text-[#220044] rounded-xl shadow-lg p-6 space-y-3">
                        <h2 class="text-2xl font-bold">{{ $sala->nombre }}</h2>
                        <p><strong>Capacidad:</strong> {{ $sala->capacidad }}</p>
                        <p><strong>Filas:</strong> {{ $sala->numero_fila }}</p>
                        <p><strong>Columnas:</strong> {{ $sala->numero_columna }}</p>

                        <div class="flex justify-between mt-4">
                            <a href="{{ route('salas.edit', $sala->id_sala) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transform hover:scale-105 transition">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('salas.destroy', $sala->id_sala) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta sala?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transform hover:scale-105 transition">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-3 text-center text-xl">No hay salas registradas.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
