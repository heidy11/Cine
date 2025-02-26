<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-md">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎟️ Reservar Boletos</h1>

        <div class="border border-gray-300 rounded-lg shadow-lg p-4 bg-white">
            <h2 class="text-xl font-bold text-black">{{ $funcion->pelicula->titulo }}</h2>
            <p class="text-gray-600">🎭 Sala: <strong class="text-black">{{ $funcion->sala->nombre }}</strong></p>
            <p class="text-gray-600">⏰ Hora: <strong class="text-black">{{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}</strong></p>
        </div>

        <form action="{{ route('reservar') }}" method="POST" class="space-y-4 mt-4">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion->id_funcion }}">

            <div>
                <label class="block text-black font-semibold">Cantidad de Boletos:</label>
                <input type="number" name="cantidad_boletos" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" min="1" required>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                    ✅ Confirmar Reserva
                </button>
                <a href="{{ route('cartelera') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
