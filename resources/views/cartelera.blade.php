<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold text-center text-yellow-400 mb-10">🎬 Cartelera de Cine</h1>

        @auth
            <p class="text-center text-gray mb-6">Bienvenido, <span class="font-semibold">{{ Auth::user()->nombre }}</span></p>
        @else
            <p class="text-center text-red-400 mb-6">No hay usuario autenticado</p>
        @endauth

        @if($funciones->isEmpty())
            <p class="text-center text-white">Actualmente no hay funciones disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($funciones as $funcion)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                        <!-- Imagen -->
                        <div class="aspect-[2/3] overflow-hidden">
                            @if($funcion->pelicula->imagen)
                                <img src="{{ asset('storage/' . $funcion->pelicula->imagen) }}"
                                     alt="{{ $funcion->pelicula->titulo }}"
                                     class="w-full h-full object-cover object-center transition-transform duration-300 hover:scale-105">
                            @else
                                <img src="{{ asset('images/default-movie.jpg') }}"
                                     alt="Imagen no disponible"
                                     class="w-full h-full object-cover object-center">
                            @endif
                        </div>

                        <!-- Detalles -->
                        <div class="p-4 text-gray-800">
                            <h2 class="text-lg font-bold truncate mb-2 text-[#220044]">{{ $funcion->pelicula->titulo }}</h2>
                            <p class="text-sm mb-1">🎭 <span class="font-medium">Sala:</span> {{ $funcion->sala->nombre }}</p>
                            <p class="text-sm mb-1">⏰ <span class="font-medium">Hora:</span> {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}</p>
                            <p class="text-sm mb-4">📽️ <span class="font-medium">Formato:</span>
                                <span class="inline-block bg-yellow-400 text-[#220044] px-2 py-0.5 rounded-full text-xs font-semibold">
                                    {{ $funcion->formato }}
                                </span>
                            </p>

                            <!-- Botón -->
                            <a href="{{ route('butacas.show', $funcion->id_funcion) }}"
                               class="block text-center bg-[#220044] hover:bg-[#3a006e] text-yellow-400 font-semibold py-2 rounded-md transition duration-300">
                                🎟️ Reservar
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
