<x-app-layout>
    <div class="min-h-screen bg-[#220044] from-gray-900 to-black py-20 px-8">
        <div class="container mx-auto">
            <!-- Título principal -->
            <h1 class="text-6xl font-bold text-center text-yellow-400 mb-14 tracking-widest uppercase drop-shadow-[0_5px_5px_rgba(0,0,0,0.9)] animate-fade-in">
                🎬 Cartelera
            </h1>

            <!-- Mensaje de bienvenida -->
            @auth
                <div class="max-w-2xl mx-auto mb-16 bg-[#220044] bg-opacity-80 rounded-xl shadow-2xl p-6 text-center animate-fade-in-up">
                    <h2 class="text-3xl font-bold text-yellow-300 mb-2">¡Bienvenido/a, {{ Auth::user()->nombre }}! 🍿</h2>
                    <p class="text-gray-300 text-lg">Disfruta de las mejores funciones que tenemos para ti. ¡Elige tu película favorita! 🎥✨</p>
                </div>
            @else
                <div class="max-w-xl mx-auto mb-16 bg-red-500 bg-opacity-80 rounded-xl shadow-lg p-6 text-center animate-fade-in-up">
                    <p class="text-white text-2xl font-bold">Inicia sesión para reservar tus entradas 🎟️</p>
                </div>
            @endauth

            <!-- Si no hay funciones -->
            @if($peliculas->isEmpty())
                <p class="text-center text-white text-xl font-semibold">Actualmente no hay funciones disponibles.</p>
            @else
                <!-- Grid de películas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-12">
                    @foreach($peliculas as $pelicula)
                        <div class="relative group perspective animate-fade-in-up">
                            <div class="card-inner duration-700 w-full h-[500px] rounded-2xl shadow-2xl bg-white text-center transform-style">
                                <!-- Lado frontal -->
                                <div class="card-front absolute w-full h-full backface-hidden rounded-2xl overflow-hidden">
                                    @if($pelicula->imagen)
                                        <img src="{{ asset($pelicula->imagen) }}"
                                             alt="{{ $pelicula->titulo }}"
                                             class="w-full h-full object-cover object-top">
                                    @else
                                        <img src="{{ asset('images/default-movie.jpg') }}"
                                             alt="Imagen no disponible"
                                             class="w-full h-full object-cover object-top">
                                    @endif

                                    @php
                                        $formato = optional($pelicula->funciones->first())->formato;
                                    @endphp

                                    @if($formato)
                                        <div class="absolute top-3 right-3 
                                                    {{ $formato == '3D' ? 'bg-yellow-400' : 'bg-blue-400' }} 
                                                    text-[#220044] text-sm font-extrabold tracking-wider uppercase 
                                                    px-4 py-2 rounded-full shadow-lg border-2 border-white">
                                            {{ $formato }}
                                        </div>
                                    @endif

                                    <div class="absolute bottom-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent text-yellow-300 font-bold w-full p-4 text-xl tracking-wide">
                                        {{ $pelicula->titulo }}
                                    </div>
                                </div>

                                <!-- Lado trasero -->
                                <div class="card-back absolute w-full h-full bg-gradient-to-b from-[#220044] to-black text-white rounded-2xl p-6 backface-hidden rotate-y-180 flex flex-col justify-center items-center text-center space-y-6">
                                    <h2 class="text-3xl font-extrabold text-yellow-400 uppercase tracking-wide">
                                        {{ $pelicula->titulo }}
                                    </h2>

                                    <p class="text-base text-gray-300 leading-relaxed max-h-[140px] overflow-y-auto px-4">
                                        {{ Str::limit($pelicula->descripcion, 300, '...') }}
                                    </p>

                                    <a href="{{ route('pelicula.horarios', $pelicula->id_pelicula) }}"
                                       class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-[#220044] font-bold py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-110">
                                        🎟️ Ver horarios disponibles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($personal->isNotEmpty())
<section class="mb-16">
    <h2 class="text-yellow-400 text-4xl font-extrabold mb-8 text-center">Recomendaciones para ti</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
        @foreach($personal as $funcion)
        <div class="bg-gray-800 text-yellow-300 p-4 rounded-lg shadow-md flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-xl mb-2">{{ $funcion->pelicula->titulo }}</h3>
                <p><strong>Género:</strong> {{ $funcion->pelicula->genero }}</p>
                <p><strong>Director:</strong> {{ $funcion->pelicula->director }}</p>
                <p><strong>Horario:</strong> {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}</p>
            </div>
            <a href="{{ route('reservar', $funcion->id_funcion) }}" class="bg-yellow-400 text-[#220044] font-bold py-2 px-4 rounded hover:bg-yellow-500 transition">
                🎟️ Reservar
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif

@if($tendencia->isNotEmpty())
<section class="mb-16">
    <h2 class="text-yellow-400 text-4xl font-extrabold mb-8 text-center">Películas en tendencia</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
        @foreach($tendencia as $pelicula)
        <div class="bg-gray-800 text-yellow-300 p-4 rounded-lg shadow-md flex flex-col justify-between">
            <div>
                <h3 class="font-bold text-xl mb-2">{{ $pelicula->titulo }}</h3>
                <p><strong>Género:</strong> {{ $pelicula->genero }}</p>
                <p><strong>Director:</strong> {{ $pelicula->director }}</p>
            </div>
            <a href="{{ route('pelicula.horarios', $pelicula->id_pelicula) }}" class="bg-yellow-400 text-[#220044] font-bold py-2 px-4 rounded hover:bg-yellow-500 transition">
                🎥 Ver horarios
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif

        </div>
       
    </div>

    <!-- Estilos extra -->
    <style>
        .perspective {
            perspective: 1000px;
        }
        .card-inner {
            transition: transform 0.7s;
            transform-style: preserve-3d;
            position: relative;
        }
        .group:hover .card-inner {
            transform: rotateY(180deg);
        }
        .card-front, .card-back {
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .card-back {
            transform: rotateY(180deg);
        }
        /* Animaciones FadeIn */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }
        .animate-fade-in-up {
            animation: fadeIn 1.2s ease-out;
        }
    </style>
</x-app-layout>
