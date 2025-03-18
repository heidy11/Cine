<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎬 Cartelera de Cine</h1>
        @if(Auth::check())
    <p class="text-green-500">✅ Usuario autenticado: {{ Auth::user()->nombre ?? Auth::user()->email }}</p>
@else
    <p class="text-red-500">❌ No hay usuario autenticado</p>
@endif


        @if($funciones->isEmpty())
            <p class="text-center text-gray-500">No hay funciones disponibles en este momento.</p>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($funciones as $funcion)
        <div class="border border-gray-300 rounded-lg shadow-lg p-4 bg-white">
            @if($funcion->pelicula->imagen)
                <img src="{{ asset('storage/' . $funcion->pelicula->imagen) }}" class="w-48 h-60 object-cover rounded-lg mb-4">
            @else
                <img src="{{ asset('images/default-movie.jpg') }}" class="w-48 h-72 object-cover rounded-lg mb-4 mx-auto">
            @endif

            <h2 class="text-xl font-bold text-black">{{ $funcion->pelicula->titulo }}</h2>
            <p class="text-gray-600">🎭 Sala: <strong class="text-black">{{ $funcion->sala->nombre }}</strong></p>
            <p class="text-gray-600">⏰ Hora: <strong class="text-black">{{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('d/m/Y H:i') }}</strong></p>
            <div class="absolute top-2 right-2 px-2 py-1 rounded 
                {{ $funcion->formato == '3D' ? 'bg-red-500' : 'bg-blue-500' }} 
                text-white text-xs font-bold">
                {{ $funcion->formato }}
            </div>

            <div class="mt-4">
                <a href="{{ route('reservar.form', $funcion->id_funcion) }}" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-4 rounded-lg shadow-md w-full block text-center">
                    🎟️ Reservar
                </a>
            </div>
        </div>
    </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>