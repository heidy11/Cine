<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-extrabold mb-6 text-black text-center">🎭 Agregar Nueva Función</h1>

        {{-- Mostrar errores --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">❗ Errores encontrados:</strong>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('funciones.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Película --}}
            <div>
                <label class="block text-black font-semibold">🎬 Película:</label>
                <select name="pelicula_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    <option value="" disabled selected>Seleccione una película</option>
                    @foreach($peliculas as $pelicula)
                        <option value="{{ $pelicula->id_pelicula }}">{{ $pelicula->titulo }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sala --}}
            <div>
                <label class="block text-black font-semibold">🏛️ Sala:</label>
                <select name="sala_id" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    <option value="" disabled selected>Seleccione una sala</option>
                    @foreach($salas as $sala)
                        <option value="{{ $sala->id_sala }}">{{ $sala->nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Hora de Inicio --}}
            <div>
                <label class="block text-black font-semibold">🕒 Hora de Inicio:</label>
                <input type="datetime-local" name="hora_inicio" id="hora_inicio"
                       class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black"
                       min="{{ \Carbon\Carbon::now('America/La_Paz')->format('Y-m-d\TH:i') }}"
                       required>
            </div>

            {{-- Hora de Fin --}}
            <div>
                <label class="block text-black font-semibold">🕕 Hora de Fin:</label>
                <input type="datetime-local" name="hora_fin" id="hora_fin"
                       class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black"
                       min="{{ \Carbon\Carbon::now('America/La_Paz')->addMinutes(10)->format('Y-m-d\TH:i') }}"
                       required>
            </div>

            {{-- Formato --}}
            <div>
                <label class="block text-black font-semibold">📽️ Formato:</label>
                <select name="formato" class="border border-gray-300 rounded-lg px-4 py-2 w-full text-black" required>
                    <option value="" disabled selected>Seleccione un formato</option>
                    <option value="2D">2D</option>
                    <option value="3D">3D</option>
                </select>
            </div>

            {{-- Botones --}}
            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                    ✅ Guardar
                </button>
                <a href="{{ route('funciones.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>

    {{-- Script para sugerir hora_fin automáticamente (opcional) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inicioInput = document.getElementById('hora_inicio');
            const finInput = document.getElementById('hora_fin');

            inicioInput.addEventListener('change', () => {
                const inicio = new Date(inicioInput.value);
                if (inicio) {
                    const finSugerido = new Date(inicio.getTime() + 2 * 60 * 60 * 1000); // suma 2 horas
                    finInput.value = finSugerido.toISOString().slice(0, 16);
                    finInput.min = inicioInput.value;
                }
            });
        });
    </script>
</x-app-layout>
