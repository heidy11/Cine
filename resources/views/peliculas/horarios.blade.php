<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-center text-yellow-500 mb-6">
            🎞️ Horarios para "{{ $pelicula->titulo }}"
        </h1>

        @if($funciones->isEmpty())
            <p class="text-center text-red-500 text-lg">No hay funciones disponibles para esta película.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($funciones as $funcion)
                    <div class="bg-white rounded-lg shadow-md p-4 text-center">
                        <p class="text-lg font-bold text-blue-700 mb-1">
                            🏛️ Sala: {{ $funcion->sala->nombre }}
                        </p>

                        <p class="text-sm text-gray-600 mb-1">
                            🕒 {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}
                            - {{ \Carbon\Carbon::parse($funcion->hora_fin)->format('H:i') }}
                        </p>

                        <p class="text-sm text-gray-600 mb-2">🎥 Formato: {{ $funcion->formato }}</p>

                        <a href="{{ route('butacas.show', $funcion->id_funcion) }}"
                           class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-4 rounded-full transition">
                            Reservar 🎟️
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="text-center mt-6">
            <a href="{{ route('cartelera') }}"
               class="inline-block mt-4 text-blue-600 hover:underline text-sm">⬅️ Volver a la cartelera</a>
        </div>
    </div>
</x-app-layout>
