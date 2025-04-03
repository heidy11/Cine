<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎟️ Selección de Butacas</h1>
        
        <div class="text-center mb-6 text-xl text-black">
            Función: {{ $funcion->pelicula->titulo }} | Sala: {{ $funcion->sala->nombre }} | Formato: {{ $funcion->formato }}
        </div>
        
        <div class="flex justify-center mb-4">
            <div class="bg-black text-white px-2 py-1 mb-4">PANTALLA</div>
        </div>

        <form action="{{ route('reservar.store', $funcion->id_funcion) }}" method="POST">
            @csrf

            <div class="grid gap-2">
                @for ($row = 1; $row <= 13; $row++)
                    <div class="flex justify-center items-center space-x-2 mb-2">
                        {{-- Lado Izquierdo (Números impares) --}}
                        <div class="flex space-x-1">
                            @foreach (range(1, 23, 2) as $col)
                                @php
                                    $butacaId = "L-{$row}-{$col}";
                                    $isReserved = in_array($butacaId, $reservas);
                                @endphp
                                <input type="checkbox" name="butacas[]" value="{{ $butacaId }}" id="{{ $butacaId }}" {{ $isReserved ? 'disabled' : '' }}>
                                <label for="{{ $butacaId }}" class="w-8 h-8 {{ $isReserved ? 'bg-red-500' : 'bg-green-500' }} text-black rounded text-center">{{ $col }}</label>
                            @endforeach
                        </div>

                        {{-- Parte central (Letras A-H) --}}
                        <div class="flex space-x-1">
                            @foreach (range('A', 'H') as $letra)
                                @php
                                    $butacaId = "C-{$row}-{$letra}";
                                    $isReserved = in_array($butacaId, $reservas);
                                @endphp
                                <input type="checkbox" name="butacas[]" value="{{ $butacaId }}" id="{{ $butacaId }}" {{ $isReserved ? 'disabled' : '' }}>
                                <label for="{{ $butacaId }}" class="w-8 h-8 {{ $isReserved ? 'bg-red-500' : 'bg-blue-500' }} text-white rounded text-center">{{ $letra }}</label>
                            @endforeach
                        </div>

                        {{-- Lado Derecho (Números pares) --}}
                        <div class="flex space-x-1">
                            @foreach (range(2, 24, 2) as $col)
                                @php
                                    $butacaId = "R-{$row}-{$col}";
                                    $isReserved = in_array($butacaId, $reservas);
                                @endphp
                                <input type="checkbox" name="butacas[]" value="{{ $butacaId }}" id="{{ $butacaId }}" {{ $isReserved ? 'disabled' : '' }}>
                                <label for="{{ $butacaId }}" class="w-8 h-8 {{ $isReserved ? 'bg-red-500' : 'bg-green-500' }} text-black rounded text-center">{{ $col }}</label>
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                    Reservar Butacas Seleccionadas
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
