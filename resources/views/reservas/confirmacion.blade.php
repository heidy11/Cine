<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold text-center text-[#220044] mb-6">
            ✅ Confirmación de Reserva
        </h1>

        {{-- Mensaje de tiempo restante --}}
        <div class="text-center text-lg text-red-600 font-semibold mb-4">
            ⏳ Tienes <span id="timer">20:00</span> minutos para subir tu comprobante antes de que tus entradas sean liberadas.
        </div>

        {{-- Información de la función --}}
        <div class="mb-4">
            <p><strong>🎬 Película:</strong> {{ $funcion->pelicula->titulo }}</p>
            <p><strong>🕒 Hora:</strong> {{ $funcion->hora_inicio }} - {{ $funcion->hora_fin }}</p>
            <p><strong>📅 Fecha:</strong> {{ $funcion->fecha_inicio }}</p>
            <p><strong>🎥 Formato:</strong> {{ $funcion->formato }}</p>
            
        </div>

        {{-- Lista de butacas --}}
        <div class="mb-4">
            <p><strong>🪑 Butacas seleccionadas:</strong></p>
            <ul class="list-disc list-inside text-gray-700">
            @foreach($butacas as $butaca)
    <li>Butaca: {{$butaca->numero}}</li>
    <input type="hidden" name="butacas[]" value="{{ $butaca->id_butaca }}">
@endforeach

            </ul>
        </div>

        {{-- Total --}}
        <div class="mb-4 text-lg font-semibold">
            💵 Total a pagar: Bs. {{ $total }} ({{ count($butacas) }} entradas)
        </div>

        {{-- QR de pago --}}
        <div class="mt-6 text-center">
            <h2 class="text-lg font-semibold mb-2">📱 Escanea este QR con YaSta y paga exactamente:</h2>
            <p class="text-2xl font-bold text-green-700 mb-4">Bs {{ $total }}</p>
            <img src="{{ asset('imagenes/qrsimple.jpeg') }}" alt="QR YaSta" class="mx-auto w-60 h-60 rounded border shadow">
        </div>
        

        {{-- Formulario para subir comprobante --}}
        <form action="{{ route('funcion.butaca.comprobante') }}" method="POST" enctype="multipart/form-data" class="mt-8">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion->id_funcion }}">

            @foreach($butacas as $fb)
                <input type="hidden" name="butacas[]" value="{{ $fb->id_butaca }}"> {{-- ID de funcion_butaca --}}
            @endforeach

            <input type="hidden" name="total" value="{{ $total }}">

            <div class="mb-4">
                <label for="comprobante" class="block font-medium mb-1">📎 Subir comprobante de pago (JPG, PNG o PDF):</label>
                <input type="file" name="comprobante" id="comprobante" required
                    class="block w-full border border-gray-300 rounded px-3 py-2">
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded">
                    📤 Enviar comprobante
                </button>
            </div>
        </form>
    </div>

    {{-- Script para cuenta regresiva --}}
    <script>
        const limite = new Date("{{ \Carbon\Carbon::now()->addMinutes(20)->format('Y-m-d H:i:s') }}").getTime();

        function startTimer() {
            const timerEl = document.getElementById('timer');

            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = limite - now;

                if (distance < 0) {
                    clearInterval(interval);
                    timerEl.innerText = "00:00";
                    alert("⚠️ El tiempo para pagar ha expirado. Debes volver a seleccionar tus butacas.");
                    window.location.href = "{{ route('cartelera') }}";
                    return;
                }

                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                timerEl.innerText = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', startTimer);
    </script>
</x-app-layout>
