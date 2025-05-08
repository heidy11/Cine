<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6">

        <div class="max-w-6xl mx-auto">

            <!-- Título de la película -->
            <h1 class="text-5xl font-extrabold text-center text-yellow-400 mb-8 drop-shadow-md">
                🎬 {{ $pelicula->titulo }}
            </h1>

            <!-- Descripción breve -->
            <p class="text-center text-lg text-gray-200 max-w-3xl mx-auto mb-12">
                {{ Str::limit($pelicula->descripcion, 250, '...') }}
            </p>

            @if($funciones->isEmpty())
                <div class="text-center text-red-400 font-bold text-2xl mt-20">
                    ❌ No hay funciones disponibles por el momento.
                </div>
            @else
                <!-- Grid de funciones -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach($funciones as $funcion)
                        <div class="bg-white p-6 rounded-2xl shadow-2xl transform hover:scale-105 transition duration-300 flex flex-col items-center text-center space-y-4">
                            <div class="text-2xl font-extrabold text-[#220044]">
                                🕒 {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}
                            </div>

                            <div class="text-lg text-gray-700">
                                🏛️ Sala: <span class="font-bold">{{ $funcion->sala->nombre }}</span>
                            </div>

                            <div class="text-lg text-gray-700">
                                📽️ Formato: <span class="font-bold">{{ $funcion->formato }}</span>
                            </div>

                            <!-- Ruta actualizada -->
                            <a href="{{ route('butacas.mostrar', $funcion->id_funcion) }}" 
                               class="mt-4 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-6 rounded-full shadow-md transform hover:scale-110 transition">
                                🎟️ Reservar
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Botón de regreso -->
            <div class="mt-16 text-center">
                <a href="{{ route('cartelera') }}" 
                   class="inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-8 rounded-full shadow-md transform hover:scale-105 transition">
                    🔙 Volver a Cartelera
                </a>
            </div>

        </div>

    </div>
</x-app-layout>
