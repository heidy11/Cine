<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold text-center text-yellow-400 mb-10">🎬 Cartelera de Cine</h1>

        @auth
            <p class="text-center text-black mb-6">
                Bienvenido, <span class="font-semibold">{{ Auth::user()->nombre }}</span>
            </p>
        @else
            <p class="text-center text-red-400 mb-6">No hay usuario autenticado</p>
        @endauth

        @if($peliculas->isEmpty())
            <p class="text-center text-black">Actualmente no hay funciones disponibles.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($peliculas as $pelicula)
                    <div class="relative group perspective">
                        <div class="card-inner duration-700 w-full h-[450px] rounded-xl shadow-xl bg-white text-center transform-style">
                            <!-- Lado frontal -->
                            <div class="card-front absolute w-full h-full backface-hidden rounded-xl overflow-hidden">
                                <img src="{{ asset('storage/' . $pelicula->imagen) }}"
                                     alt="{{ $pelicula->titulo }}"
                                     class="w-full h-full object-cover object-top">
                                <div class="absolute bottom-0 bg-[#220044]/80 text-yellow-300 font-bold w-full p-2">
                                    {{ $pelicula->titulo }}
                                </div>
                            </div>

                            <<!-- Lado trasero -->
<div class="card-back absolute w-full h-full bg-gradient-to-b from-[#220044] to-[#110022] text-white rounded-xl p-5 backface-hidden rotate-y-180 flex flex-col justify-center items-center text-center space-y-4">

{{-- Título grande y estilizado --}}
<h2 class="text-3xl font-extrabold text-yellow-400 tracking-wide uppercase leading-tight">
    {{ $pelicula->titulo }}
</h2>

{{-- Descripción con buen espaciado y lectura --}}
<p class="text-base text-gray-300 leading-relaxed max-h-[160px] overflow-y-auto px-2">
    {{ Str::limit($pelicula->descripcion, 300, '...') }}
</p>

{{-- Botón más visible y centrado --}}
<a href="{{ route('peliculas.horarios', $pelicula->id_pelicula) }}"
   class="mt-2 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-semibold text-base px-6 py-2 rounded-full shadow-md transition-transform transform hover:scale-105">
    🎟️ Ver horarios disponibles
</a>
</div>




                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
