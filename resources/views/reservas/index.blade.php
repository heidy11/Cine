<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎟️ Mis Reservas</h1>

        @if($reservas->isEmpty())
            <p class="text-center text-gray-500">No tienes reservas.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($reservas as $reserva)
                    <div class="border border-gray-300 rounded-lg shadow-lg p-4 bg-white">
                        <h2 class="text-xl font-bold text-black">{{ $reserva->funcion->pelicula->titulo }}</h2>
                        <p class="text-gray-600">🎭 Sala: <strong class="text-black">{{ $reserva->funcion->sala->nombre }}</strong></p>
                        <p class="text-gray-600">⏰ Hora: <strong class="text-black">{{ \Carbon\Carbon::parse($reserva->funcion->hora_inicio)->format('d/m/Y H:i') }}</strong></p>
                        <p class="text-gray-600">🎫 Boletos: <strong class="text-black">{{ $reserva->cantidad_boletos }}</strong></p>
                        <p class="text-gray-600">📌 Estado: <strong class="text-black">{{ ucfirst($reserva->estado) }}</strong></p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
