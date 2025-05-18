<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-xl shadow text-center">
        <h2 class="text-2xl font-bold text-purple-700 mb-4">🎫 Validación de Boleto</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="text-left text-gray-700 space-y-2">
            <p><strong>Película:</strong> {{ $boleto->funcion->pelicula->titulo }}</p>
            <p><strong>Fecha de la función:</strong> {{ $boleto->funcion->fecha }}</p>
            <p><strong>Hora:</strong> {{ substr($boleto->funcion->hora_inicio, 0, 5) }}</p>
            <p><strong>Sala:</strong> {{ $boleto->funcion->sala->nombre }}</p>
            <p><strong>Butaca:</strong> 
                {{ $boleto->butaca->numero ?? 'F'.$boleto->butaca->fila_pos.' - C'.$boleto->butaca->columna_pos }}
            </p>
            <p><strong>Estado:</strong> 
                @if($boleto->usado)
                    <span class="text-red-600 font-semibold">❌ Ya validado</span>
                @else
                    <span class="text-green-600 font-semibold">🆗 Aún no usado</span>
                @endif
            </p>
        </div>

        @if($boleto->usado == 0)
            <form method="POST" action="{{ route('admin.marcar.usado', $boleto->id_funcion_butaca) }}" class="mt-6">
                @csrf
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    ✅ Validar QR (Marcar como usado)
                </button>
            </form>
        @else
            <p class="mt-6 text-gray-500 italic">Este boleto ya fue escaneado y validado.</p>
        @endif
    </div>
</x-app-layout>
