<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">🎬 Selecciona tus butacas</h1>

        <div class="text-center text-white bg-black py-2 rounded mb-6 font-semibold">PANTALLA</div>

        <form method="POST" action="{{ route('reservas.confirmar') }}">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion_id }}">

            <div class="flex flex-col items-center space-y-2">
                @foreach ($matriz as $fila)
                    <div class="flex items-center space-x-1">
                        @foreach ($fila as $butaca)
                            @php
                                $estado = $butaca['estado_funcion']; // null, 0, 1, 2
                                $clase = match ($estado) {
                                    1 => 'bg-green-500 text-white cursor-not-allowed opacity-70', // reservado
                                    2 => 'bg-purple-400 text-white cursor-not-allowed opacity-70', // ocupado
                                    default => 'bg-gray-300 text-black hover:bg-yellow-300', // disponible
                                };
                            @endphp

                            @if($estado === 1 || $estado === 2)
                                <div class="w-10 h-10 text-sm rounded flex items-center justify-center {{ $clase }}">
                                    {{ $butaca['numero'] }}
                                </div>
                            @else
                                <label class="butaca w-10 h-10 rounded flex items-center justify-center text-sm cursor-pointer transition {{ $clase }}">
                                    <input type="checkbox" name="butacas[]" value="{{ $butaca['id'] }}" class="hidden peer">
                                    <span class="peer-checked:bg-yellow-400 peer-checked:text-black block text-center w-full h-full leading-10 rounded">
                                        {{ $butaca['numero'] }}
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>

            {{-- Leyenda --}}
            <div class="flex justify-center space-x-6 mt-6 mb-4">
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 bg-gray-300 rounded border border-gray-400"></div>
                    <span class="text-sm text-gray-700">Disponible</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 bg-green-500 rounded border border-gray-600"></div>
                    <span class="text-sm text-gray-700">Reservado</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 bg-purple-400 rounded border border-gray-600"></div>
                    <span class="text-sm text-gray-700">Ocupado</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-5 h-5 bg-yellow-400 rounded border border-gray-600"></div>
                    <span class="text-sm text-gray-700">Seleccionado</span>
                </div>
            </div>

            {{-- Resumen --}}
            <div class="text-center mt-4">
                <p class="text-lg font-semibold text-gray-800">
                    🎟️ Butacas seleccionadas: <span id="cantidad">0</span>
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    💵 Total a pagar: Bs. <span id="total">0</span>
                </p>
            </div>

            <input type="hidden" name="total" id="total_hidden" value="0">
            <input type="hidden" name="cantidad_butacas" id="cantidad_hidden" value="0">

            {{-- Botón --}}
            <div class="text-center mt-6">
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-[#220044] font-bold px-6 py-2 rounded">
                    ✅ Confirmar reserva
                </button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        const precioEntrada = Number('{{ $precio }}');

        function actualizarResumen() {
            const seleccionadas = document.querySelectorAll('.butaca input[type="checkbox"]:checked');
            document.getElementById('cantidad').textContent = seleccionadas.length;
            document.getElementById('total').textContent = seleccionadas.length * precioEntrada;
            document.getElementById('total_hidden').value = seleccionadas.length * precioEntrada;
            document.getElementById('cantidad_hidden').value = seleccionadas.length;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.butaca').forEach(label => {
                const checkbox = label.querySelector('input[type="checkbox"]');
                label.addEventListener('click', () => {
                    setTimeout(() => actualizarResumen(), 10);
                });
            });

            actualizarResumen();
        });
    </script>
</x-app-layout>
