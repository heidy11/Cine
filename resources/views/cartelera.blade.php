<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-purple-100 to-purple-200 py-12 px-6">
        <div class="container mx-auto">
            <h1 class="text-5xl font-extrabold text-center text-yellow-500 mb-12 tracking-wide drop-shadow-lg">
                🎬 Cartelera de Cine
            </h1>

            @auth
                <p class="text-center text-black text-lg mb-8">
                    Bienvenido, <span class="font-bold text-purple-800">{{ Auth::user()->nombre }}</span>
                </p>
            @else
                <p class="text-center text-red-400 text-lg mb-8">Inicia sesión para reservar tus entradas 🎟️</p>
            @endauth

            @if($peliculas->isEmpty())
                <p class="text-center text-black text-xl font-semibold">Actualmente no hay funciones disponibles.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-10">
                    @foreach($peliculas as $pelicula)
                        <div class="relative group perspective">
                            <div class="card-inner duration-700 w-full h-[450px] rounded-2xl shadow-2xl bg-white text-center transform-style">
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



    {{-- Mostrar formato de la primera función disponible --}}
    @php
        $formato = optional($pelicula->funciones->first())->formato;
    @endphp

    @if($formato)
        <div class="absolute top-3 right-3 
                    {{ $formato == '3D' ? 'bg-yellow-400' : 'bg-blue-400' }} 
                    text-[#220044] text-sm font-extrabold tracking-wide uppercase 
                    px-4 py-2 rounded-full shadow-lg border-2 border-white">
            {{ $formato }}
        </div>
    @endif
    <div class="absolute bottom-0 bg-[#220044]/80 text-yellow-300 font-bold w-full p-2 text-lg tracking-wide">
        {{ $pelicula->titulo }}
    </div>
</div>


                                <!-- Lado trasero -->
                                <div class="card-back absolute w-full h-full bg-gradient-to-b from-[#220044] to-[#110022] text-white rounded-2xl p-6 backface-hidden rotate-y-180 flex flex-col justify-center items-center text-center space-y-5">
                                    <h2 class="text-3xl font-extrabold text-yellow-400 uppercase tracking-wide leading-tight">
                                        {{ $pelicula->titulo }}
                                    </h2>

                                    <p class="text-base text-gray-300 leading-relaxed max-h-[140px] overflow-y-auto px-2">
                                        {{ Str::limit($pelicula->descripcion, 300, '...') }}
                                    </p>

                                    <a href="{{ route('peliculas.horarios', $pelicula->id_pelicula) }}"
                                       class="mt-2 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-semibold text-base px-6 py-2 rounded-full shadow-md transition-transform transform hover:scale-110">
                                        🎟️ Ver horarios disponibles
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

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

        .card-front,
        .card-back {
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
    </style>
</x-app-layout>
