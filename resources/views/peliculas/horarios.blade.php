<x-app-layout>
    <div class="container mx-auto px-4 py-8 text-center">
        <h1 class="text-3xl font-bold text-yellow-400 mb-4">🎬 Horarios para: {{ $pelicula->titulo }}</h1>

        @if($funciones->isEmpty())
            <p class="text-white">No hay funciones disponibles para esta película.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($funciones as $funcion)
                    <div class="bg-white p-4 rounded-lg shadow-lg text-black">
                        <p>🎭 <strong>Sala:</strong> {{ $funcion->sala->nombre }}</p>
                        <p>⏰ <strong>Hora:</strong> {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}</p>
                        <p>📽️ <strong>Formato:</strong> {{ $funcion->formato }}</p>
                        <a href="{{ route('butacas.show', $funcion->id_funcion) }}" class="mt-3 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-4 rounded transition">
                            Seleccionar Butacas
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
