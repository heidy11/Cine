<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6">

        <h1 class="text-4xl font-extrabold text-center text-yellow-400 mb-10">
            🎯 Funciones Recomendadas para Ti
        </h1>

        @if($recomendadas && count($recomendadas) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($recomendadas as $item)
                    @php
                        $funcion = $item['funcion'];
                        $pelicula = $funcion->pelicula;
                    @endphp

                    <div class="bg-white rounded-2xl shadow-2xl p-6 hover:shadow-yellow-300 transition transform hover:scale-105">
                        <h2 class="text-2xl font-bold text-[#220044] mb-2">{{ $pelicula->titulo }}</h2>
                        <p class="text-[#220044]"><strong>🎬 Género:</strong> {{ $pelicula->genero }}</p>
                        <p class="text-[#220044]"><strong>🎥 Director:</strong> {{ $pelicula->director }}</p>
                        <p class="text-[#220044]"><strong>🕒 Horario:</strong> {{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}</p>
                        
                        <a href="{{ route('funciones.mostrar', $funcion->id_funcion) }}"

                           class="mt-4 inline-block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold px-4 py-2 rounded-2xl shadow-md transition">
                            🎟️ Ver función
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-yellow-300 text-lg mt-10">
                Aún no podemos generar recomendaciones. Intenta comprar algunas entradas para personalizar tu perfil 🍿
            </p>
        @endif

    </div>
</x-app-layout>
