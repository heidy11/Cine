<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">🎬 Selecciona tus butacas</h1>

        {{-- Pantalla en la parte superior --}}
        <div class="text-center text-white bg-black py-2 rounded mb-6 font-semibold">PANTALLA</div>

        <form method="POST" action="{{ route('reservar') }}">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion_id }}">

            @php
                $letras = range('A', 'H');
                $pares = range(2, 24, 2);
            @endphp

            @foreach($butacas_izquierda as $index => $fila)
                <div class="flex items-center justify-center space-x-2 mb-2">

                    {{-- Número de fila (izquierda) --}}
                    <div class="w-8 text-center font-bold text-gray-700">
                        {{ $index + 1 }}
                    </div>

                    {{-- Lado Izquierdo (impares) --}}
                    @foreach($fila as $asiento)
                        <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition duration-200 text-sm">
                            <input type="checkbox" name="butacas[]" value="{{ $asiento['nombre'] }}" class="hidden">
                            {{ $asiento['numero'] }}
                        </label>
                    @endforeach

                    {{-- Espacio entre izquierdo y centro --}}
                    <div class="w-6"></div>

                    {{-- Centro (letras A - H) --}}
                    @foreach($letras as $letra)
                        <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition duration-200 text-sm">
                            <input type="checkbox" name="butacas[]" value="C-{{ $index + 1 }}-{{ $letra }}" class="hidden">
                            {{ $letra }}
                        </label>
                    @endforeach

                    {{-- Espacio entre centro y derecho --}}
                    <div class="w-6"></div>

                    {{-- Lado Derecho (pares) --}}
                    @foreach($pares as $numero)
                        <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition duration-200 text-sm">
                            <input type="checkbox" name="butacas[]" value="D-{{ $index + 1 }}-{{ $numero }}" class="hidden">
                            {{ $numero }}
                        </label>
                    @endforeach

                    {{-- Número de fila (derecha) --}}
                    <div class="w-8 text-center font-bold text-gray-700">
                        {{ $index + 1 }}
                    </div>
                </div>
            @endforeach

            {{-- Botón de confirmación --}}
            <div class="text-center mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    ✅ Confirmar reserva
                </button>
            </div>
        </form>
    </div>

    {{-- Script para resaltar selección --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const labels = document.querySelectorAll('.butaca');
            labels.forEach(label => {
                const checkbox = label.querySelector('input[type="checkbox"]');
                label.addEventListener('click', () => {
                    setTimeout(() => {
                        if (checkbox.checked) {
                            label.classList.remove('bg-gray-300');
                            label.classList.add('bg-green-500', 'text-black');
                        } else {
                            label.classList.remove('bg-green-500', 'text-black');
                            label.classList.add('bg-gray-300');
                        }
                    }, 10);
                });
            });
        });
    </script>
</x-app-layout>
