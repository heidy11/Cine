<x-app-layout>
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-xl shadow-md text-center">
        <h1 class="text-2xl font-bold text-purple-700 mb-4">🎟️ Tu Boleto Confirmado</h1>

        <div class="mb-6 text-left text-gray-700">
            <p><strong>🎬 Película:</strong> {{ $boleto->funcion->pelicula->titulo }}</p>
            <p><strong>📅 Fecha:</strong> {{ \Carbon\Carbon::parse($boleto->funcion->fecha)->locale('es')->translatedFormat('l d \d\e F Y') }}</p>
            <p><strong>🕒 Hora:</strong> {{ substr($boleto->funcion->hora_inicio, 0, 5) }}</p>
            <p><strong>🏛️ Sala:</strong> {{ $boleto->funcion->sala->nombre }}</p>
            <p><strong>🪑 Butaca:</strong> {{ $boleto->butaca->numero }} </p>
        </div>

        <div class="mt-6">
            {!! $qr !!}
            <p class="mt-2 text-sm text-gray-600">📲 Escanea este código para validar tu entrada</p>
            <br>
        </div>
        <a href="{{ route('boletos.imprimir', $boleto->id_funcion_butaca) }}"
   class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition inline-block mt-4"
   target="_blank">
   🖨️ Imprimir Boleto
</a>



    </div>
</x-app-layout>
