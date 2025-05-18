<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-[#220044] to-[#110022] py-12 px-6">
        <div class="max-w-6xl mx-auto">

            <!-- Título de la película -->
            <h1 class="text-5xl font-extrabold text-center text-yellow-400 mb-4 drop-shadow-lg">
                🎬 {{ $pelicula->titulo }}
            </h1>

            <!-- Línea decorativa -->
            <div class="w-24 h-1 bg-yellow-400 mx-auto mb-10 rounded-full"></div>

            <!-- Descripción -->
            <p class="text-center text-lg text-gray-200 max-w-3xl mx-auto mb-12 leading-relaxed">
                {{ Str::limit($pelicula->descripcion, 250, '...') }}
            </p>

            @if($funciones->isEmpty())
                <div class="text-center text-red-400 font-bold text-2xl mt-20">
                    ❌ No hay funciones disponibles por el momento.
                </div>
            @else
                <!-- Funciones por fecha -->
                @foreach($funciones as $fecha => $grupo)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-yellow-300 mb-6 border-b-2 border-yellow-400 pb-2">
                            📅 {{ \Carbon\Carbon::parse($fecha)->locale('es')->translatedFormat('l d \d\e F Y') }}
                        </h2>

                        <!-- Grid de funciones -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                            @foreach($grupo as $funcion)
                                <div class="bg-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-transform transform hover:scale-105 flex flex-col items-center text-center space-y-4">
                                    <div class="text-3xl font-bold text-[#220044]">
                                        🕒 {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('H:i') }}
                                    </div>

                                    <div class="text-base text-gray-700">
                                        🏛️ Sala: <span class="font-semibold">{{ $funcion->sala->nombre }}</span>
                                    </div>

                                    <div class="text-base text-gray-700">
                                        📽️ Formato: <span class="font-semibold">{{ $funcion->formato }}</span>
                                    </div>

                                    <a href="{{ route('butacas.mostrar', $funcion->id_funcion) }}" 
                                       class="mt-4 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-6 rounded-full shadow-md transition duration-300">
                                        🎟️ Reservar
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Botón de regreso -->
            <div class="mt-16 text-center">
                <a href="{{ route('cartelera') }}" 
                   class="inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-8 rounded-full shadow-lg transform hover:scale-105 transition">
                    🔙 Volver a Cartelera
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
