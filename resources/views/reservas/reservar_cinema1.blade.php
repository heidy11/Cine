<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">🎥 CINEMA 1 - Selecciona tus butacas</h1>

        {{-- Pantalla --}}
        <div class="text-center text-white bg-black py-2 rounded mb-6 font-semibold">PANTALLA</div>

        <form method="POST" action="{{ route('reservas.confirmar') }}">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion_id }}">

            @php
                $filas = range(26, 1);
                $impares = range(19, 1, -2);
                $pares = range(2, 20, 2);
                $letras = range('A', 'J');
                $ocupadas = $butacas_ocupadas ?? [];
                $precio = $formato === '3D' ? 35 : 30;


                // ⛔️ Lista de butacas a ocultar manualmente (puedes agregar más si deseas)
                $butacas_omitidas = ['I-26-19','I-26-17','I-25-19','I-25-17', 'D-26-18','D-26-20','D-25-18','D-25-20'];
            @endphp

            @foreach($filas as $fila)
                <div class="flex items-center space-x-2 mb-2 justify-center">

                    {{-- Número de fila al inicio --}}
                    <div class="w-8 text-center font-bold text-gray-700">
                        {{ $fila }}
                    </div>

                    @foreach($impares as $num)
    @php $nombre = "I-{$fila}-{$num}"; @endphp

    @if(in_array($nombre, $ocupadas))
        <div class="inline-block w-10 h-10 bg-red-600 rounded opacity-70 text-white text-sm flex items-center justify-center cursor-not-allowed">
            {{ $num }}
        </div>
        @continue
    @endif

    @if(in_array($nombre, $butacas_omitidas))
        <div class="inline-block w-10 h-10 bg-gray-200 rounded opacity-30"></div>
        @continue
    @endif

    <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition-all duration-200 text-sm">
        <input type="checkbox" name="butacas[]" value="{{ $nombre }}" class="hidden">
        {{ $num }}
    </label>
@endforeach


                    {{-- Espacio visual --}}
                    <div class="w-4"></div>

                    {{-- Butacas del Centro (ocultar fila 6 a 1) --}}
                    @foreach($letras as $letra)
    @php $nombre = "C-{$fila}-{$letra}"; @endphp

    @if($fila <= 6)
        <div class="inline-block w-10 h-10"></div>
        @continue
    @endif

    @if(in_array($nombre, $ocupadas))
        <div class="inline-block w-10 h-10 bg-red-600 rounded opacity-70 text-white text-sm flex items-center justify-center cursor-not-allowed">
            {{ $letra }}
        </div>
        @continue
    @endif

    @if(in_array($nombre, $butacas_omitidas))
        <div class="inline-block w-10 h-10 bg-gray-200 rounded opacity-30"></div>
        @continue
    @endif

    <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition-all duration-200 text-sm">
        <input type="checkbox" name="butacas[]" value="{{ $nombre }}" class="hidden">
        {{ $letra }}
    </label>
@endforeach

                    {{-- Espacio visual --}}
                    <div class="w-4"></div>
                

                    {{-- Butacas Derecha --}}
                    @foreach($pares as $num)
    @php $nombre = "D-{$fila}-{$num}"; @endphp

    @if(in_array($nombre, $ocupadas))
        <div class="inline-block w-10 h-10 bg-red-600 rounded opacity-70 text-white text-sm flex items-center justify-center cursor-not-allowed">
            {{ $num }}
        </div>
        @continue
    @endif

    @if(in_array($nombre, $butacas_omitidas))
        <div class="inline-block w-10 h-10 bg-gray-200 rounded opacity-30"></div>
        @continue
    @endif

    <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition-all duration-200 text-sm">
        <input type="checkbox" name="butacas[]" value="{{ $nombre }}" class="hidden">
        {{ $num }}
    </label>
@endforeach


                    {{-- Número de fila al final --}}
                    <div class="w-8 text-center font-bold text-gray-700">
                        {{ $fila }}
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

            <div class="text-center mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    ✅ Confirmar reserva
                </button>
            </div>
        </form>
    </div>

    {{-- Script para cambiar color al seleccionar --}}
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

        // ✅ Pintar las seleccionadas al volver a cargar
        document.querySelectorAll('.butaca input[type="checkbox"]:checked').forEach(input => {
            const label = input.closest('.butaca');
            label.classList.remove('bg-gray-300');
            label.classList.add('bg-green-500', 'text-black');
        });

        actualizarResumen();
    });
</script>


</x-app-layout>
