<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎬 Editar Función</h1>

        <form action="{{ route('funciones.update', $funcion->id_funcion) }}" method="POST">
            @csrf
            @method('PUT') 

            <div>
                <label class="block text-black font-semibold">Película:</label>
                <select name="pelicula_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    @foreach($peliculas as $pelicula)
                        <option value="{{ $pelicula->id_pelicula }}" {{ $funcion->pelicula_id == $pelicula->id_pelicula ? 'selected' : '' }}>
                            {{ $pelicula->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-black font-semibold">Sala:</label>
                <select name="sala_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    @foreach($salas as $sala)
                        <option value="{{ $sala->id_sala }}" {{ $funcion->sala_id == $sala->id_sala ? 'selected' : '' }}>
                            {{ $sala->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-black font-semibold">Hora de Inicio:</label>
                <input type="datetime-local" name="hora_inicio" 
                value="{{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('Y-m-d\TH:i') }}" 
                class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
            </div>

            <div>
                <label class="block text-black font-semibold">Hora de Fin:</label>
                <input type="datetime-local" name="hora_fin" 
                    value="{{ \Carbon\Carbon::parse($funcion->hora_fin)->format('Y-m-d\TH:i') }}" 
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
            </div>

            <div>
                <label class="block text-black font-semibold">Formato:</label>
                <select name="formato" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                   
                <option value="2D" {{ $funcion->formato == '2D' ? 'selected' : '' }}>🎞️ 2D</option>
                    <option value="3D" {{ $funcion->formato == '3D' ? 'selected' : '' }}>🎥 3D</option>
                </select>
            </div>
            

            <div class="flex justify-between mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-black font-semibold py-2 px-6 rounded-lg shadow-md">
                    ✅ Actualizar
                </button>
                <a href="{{ route('funciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
