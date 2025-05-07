<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">🎬 Selecciona tus butacas</h1>

        {{-- Pantalla en la parte superior --}}
        <div class="text-center text-white bg-black py-2 rounded mb-6 font-semibold">PANTALLA</div>

        <form method="POST" action="{{ route('reservas.confirmar') }}">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion_id }}">

            @php
                $letras = range('A', 'H');
                $pares = range(2, 24, 2);
                $ocupadas = $butacas_ocupadas ?? [];
                $precio = $formato === '3D' ? 35 : 30;

            @endphp

            @foreach($butacas_izquierda as $index => $fila)
                <div class="flex items-center justify-center space-x-2 mb-2">

                    {{-- Número de fila (izquierda) --}}
                    <div class="w-8 text-center font-bold text-gray-700">
                        {{ $index + 1 }}
                    </div>

                    {{-- Lado Izquierdo (impares) --}}
                    @foreach($fila as $asiento)
                    @php $nombre = $asiento['nombre']; @endphp
                    @if(in_array($nombre, $ocupadas))
                        <div class="inline-block w-10 h-10 bg-red-600 rounded opacity-70 text-white text-sm flex items-center justify-center cursor-not-allowed">
                            {{ $asiento['numero'] }}
                        </div>
                        @continue
                    @endif

                    <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition duration-200 text-sm">
                        <input type="checkbox" name="butacas[]" value="{{ $nombre }}" class="hidden">
                        {{ $numero }}
                    </label>

                    @endforeach


                    {{-- Espacio entre izquierdo y centro --}}
                    <div class="w-6"></div>

                    {{-- Centro (letras A - H) --}}
                    @foreach($letras as $letra)
    @php $nombre = "C-{{ $index + 1 }}-{{ $letra }}"; @endphp
    @if(in_array($nombre, $ocupadas))
        <div class="inline-block w-10 h-10 bg-red-600 rounded opacity-70 text-white text-sm flex items-center justify-center cursor-not-allowed">
            {{ $letra }}
        </div>
        @continue
    @endif

    <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition duration-200 text-sm">
        <input type="checkbox" name="butacas[]" value="{{ $nombre }}" class="hidden">
        {{ $letra }}
    </label>
@endforeach


                    {{-- Espacio entre centro y derecho --}}
                    <div class="w-6"></div>

                    {{-- Lado Derecho (pares) --}}
                    @foreach($pares as $numero)
    @php $nombre = "D-{{ $index + 1 }}-{{ $numero }}"; @endphp
    @if(in_array($nombre, $ocupadas))
        <div class="inline-block w-10 h-10 bg-red-600 rounded opacity-70 text-white text-sm flex items-center justify-center cursor-not-allowed">
            {{ $numero }}
        </div>
        @continue
    @endif

    <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition duration-200 text-sm">
    <input type="checkbox" name="butacas[]" value="{{ $nombre }}" class="hidden peer">
    <span class="peer-checked:bg-green-500 peer-checked:text-white block text-center">
        {{ $asiento['numero'] ?? $letra ?? $numero }}
    </span>
    
</label>

@endforeach


                    {{-- Número de fila (derecha) --}}
                    <div class="w-8 text-center font-bold text-gray-700">
                        {{ $index + 1 }}
                    </div>
                </div>
            @endforeach
            {{-- Leyenda de estados --}}
<div class="flex justify-center space-x-6 mt-6 mb-4">
    <div class="flex items-center space-x-2">
        <div class="w-5 h-5 bg-gray-300 rounded border border-gray-400"></div>
        <span class="text-sm text-gray-700">Disponible</span>
    </div>
    <div class="flex items-center space-x-2">
        <div class="w-5 h-5 bg-purple-300 rounded border border-gray-400"></div>
        <span class="text-sm text-gray-700">Reservado</span>
    </div>
    <div class="flex items-center space-x-2">
        <div class="w-5 h-5 bg-green-500 rounded border border-gray-600"></div>
        <span class="text-sm text-gray-700">Seleccionado</span>
    </div>
    <div class="flex items-center space-x-2">
        <div class="w-5 h-5 bg-red-600 rounded border border-gray-600 opacity-70"></div>
        <span class="text-sm text-gray-700">Ocupado</span>
    </div>
</div>
<div class="text-center mt-4">
    <p class="text-lg font-semibold text-gray-800">
        🎟️ Butacas seleccionadas: <span id="cantidad">0</span>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        💵 Total a pagar: Bs. <span id="total">0</span>
    </p>
</div>
<input type="hidden" name="total" id="total_hidden" value="0">
<input type="hidden" name="cantidad_butacas" id="cantidad_hidden" value="0">

            {{-- Botón de confirmación --}}
            <div class="text-center mt-6">
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-[#220044] font-bold px-6 py-2 rounded">
                    ✅ Confirmar reserva
                </button>
            </div>
        </form>
    </div>

    {{-- Script para resaltar selección --}}
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
                    actualizarResumen();
                }, 10);
            });
        });

        actualizarResumen();
    });
</script>

</x-app-layout>
