<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-center text-black">Seleccionar Butacas - {{ $funcion->pelicula->titulo }}</h1>
        <div class="text-center mb-4 text-black">🎥 Pantalla</div>

        @if($sala == 'Cinema 1')
            {{-- Renderizado para Cinema 1 --}}
            <div class="flex justify-center space-x-8">
                {{-- Izquierda (Impares) --}}
                <div class="flex flex-col space-y-1">
                    @foreach($butacas['izquierda'] as $numero)
                        <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $numero }}</button>
                    @endforeach
                </div>

                {{-- Centro (Letras) --}}
                <div class="grid grid-cols-8 gap-2">
                    @for($i = 1; $i <= 13; $i++)
                        @foreach($butacas['centro'] as $letra)
                            <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $letra }}{{ $i }}</button>
                        @endforeach
                    @endfor
                </div>

                {{-- Derecha (Pares) --}}
                <div class="flex flex-col space-y-1">
                    @foreach($butacas['derecha'] as $numero)
                        <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $numero }}</button>
                    @endforeach
                </div>
            </div>

        @elseif($sala == 'Cinema 2')
            {{-- Renderizado para Cinema 2 --}}
            <div class="flex justify-center space-x-8">
                {{-- Izquierda (Frontal y Resto) --}}
                <div class="flex flex-col space-y-1">
                    {{-- Asientos frontales --}}
                    @foreach($butacas['izquierda']['frontal'] as $numero)
                        <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $numero }}</button>
                    @endforeach

                    {{-- Resto de asientos --}}
                    @foreach($butacas['izquierda']['resto'] as $numero)
                        <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $numero }}</button>
                    @endforeach
                </div>

                {{-- Centro (Letras) --}}
                <div class="grid grid-cols-8 gap-2">
                    @for($i = 1; $i <= 13; $i++)
                        @foreach($butacas['centro'] as $letra)
                            <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $letra }}{{ $i }}</button>
                        @endforeach
                    @endfor
                </div>

                {{-- Derecha (Frontal y Resto) --}}
                <div class="flex flex-col space-y-1">
                    {{-- Asientos frontales --}}
                    @foreach($butacas['derecha']['frontal'] as $numero)
                        <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $numero }}</button>
                    @endforeach

                    {{-- Resto de asientos --}}
                    @foreach($butacas['derecha']['resto'] as $numero)
                        <button class="bg-green-500 text-white py-1 px-2 rounded-md mb-1">{{ $numero }}</button>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="flex justify-center mt-6">
            <a href="{{ route('funciones.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-lg shadow-md">Volver</a>
        </div>
    </div>
</x-app-layout>
