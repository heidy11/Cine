<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-purple-800 to-purple-600 py-10 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Título de la película -->
            <h1 class="text-4xl sm:text-5xl font-extrabold text-center text-yellow-500 mb-10 drop-shadow-md">
                🎬 {{ $pelicula->titulo }}
            </h1>

            <!-- Descripción breve -->
            <p class="text-center text-lg text-gray-200 max-w-3xl mx-auto mb-12">
                {{ Str::limit($pelicula->descripcion, 250, '...') }}
            </p>

            @if($funciones->isEmpty())
                <div class="text-center text-red-300 font-bold text-2xl mt-20">
                    ❌ No hay funciones disponibles por el momento.
                </div>
            @else
                <!-- Grid de horarios -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    @foreach($funciones as $funcion)
                        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition duration-300 p-6 flex flex-col items-center space-y-4">
                            <div class="text-[#220044] font-bold text-lg">
                                🕒 {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}
                            </div>
                            <div class="text-sm text-gray-600">
                                Sala: <span class="font-semibold">{{ $funcion->sala->nombre }}</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                Formato: <span class="font-semibold">{{ $funcion->formato }}</span>
                            </div>

                            <a href="{{ route('butacas.show', $funcion->id_funcion) }}" 
                               class="mt-4 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-semibold py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-110">
                                🎟️ Reservar
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Botón de regreso -->
            <div class="mt-12 text-center">
                <a href="{{ route('cartelera') }}" 
                   class="inline-block bg-[#220044] hover:bg-purple-900 text-yellow-300 font-semibold py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">
                    🔙 Volver a Cartelera
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
