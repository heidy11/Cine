<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl">
            <h1 class="text-4xl font-extrabold text-center text-[#220044] mb-8">✏️ Editar Función</h1>

            {{-- Validación de errores --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 shadow-md">
                    <strong class="font-bold">❗ Errores encontrados:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('funciones.update', $funcion->id_funcion) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Película --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">🎬 Película:</label>
                    <select name="pelicula_id" required class="form-select">
                        @foreach($peliculas as $pelicula)
                            <option value="{{ $pelicula->id_pelicula }}" {{ $funcion->pelicula_id == $pelicula->id_pelicula ? 'selected' : '' }}>
                                {{ $pelicula->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sala --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">🏛️ Sala:</label>
                    <select name="sala_id" required class="form-select">
                        @foreach($salas as $sala)
                            <option value="{{ $sala->id_sala }}" {{ $funcion->sala_id == $sala->id_sala ? 'selected' : '' }}>
                                {{ $sala->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha única --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">📅 Fecha:</label>
                    <input type="text" id="fecha" name="fecha" class="form-input" value="{{ $funcion->fecha_inicio }}" required>
                </div>

                {{-- Hora inicio y fin --}}
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-[#220044] font-semibold mb-2">🕒 Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-input" value="{{ \Carbon\Carbon::parse($funcion->hora_inicio)->format('H:i') }}" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-[#220044] font-semibold mb-2">🕕 Hora de Fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-input" value="{{ \Carbon\Carbon::parse($funcion->hora_fin)->format('H:i') }}" required>
                    </div>
                </div>

                {{-- Formato --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">📽️ Formato:</label>
                    <select name="formato" required class="form-select">
                        <option value="2D" {{ $funcion->formato == '2D' ? 'selected' : '' }}>2D</option>
                        <option value="3D" {{ $funcion->formato == '3D' ? 'selected' : '' }}>3D</option>
                    </select>
                </div>
                {{-- Precio --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">💵 Precio:</label>
                    <input type="number" name="precio" class="form-input" value="{{ $funcion->precio }}" required>

                {{-- Botones --}}
                <div class="flex justify-between">
                    <button type="submit" class="btn-yellow">💾 Actualizar</button>
                    <a href="{{ route('funciones.index') }}" class="btn-gray">↩️ Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#fecha", {
            dateFormat: "Y-m-d",
            minDate: "today",
            defaultDate: "{{ \Carbon\Carbon::parse($funcion->fecha_inicio)->format('Y-m-d') }}"

        });

        // Sugerencia automática de hora fin
        document.addEventListener('DOMContentLoaded', () => {
            const inicio = document.getElementById('hora_inicio');
            const fin = document.getElementById('hora_fin');

            inicio.addEventListener('change', () => {
                if (inicio.value) {
                    const [h, m] = inicio.value.split(':');
                    let hora = new Date();
                    hora.setHours(parseInt(h));
                    hora.setMinutes(parseInt(m) + 90);

                    const hh = String(hora.getHours()).padStart(2, '0');
                    const mm = String(hora.getMinutes()).padStart(2, '0');

                    fin.value = `${hh}:${mm}`;
                }
            });
        });
    </script>

    {{-- Estilos --}}
    <style>
        .form-input {
            @apply border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500;
        }
        .form-select {
            @apply border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500;
        }
        .btn-yellow {
            @apply bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition;
        }
        .btn-gray {
            @apply bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition;
        }
    </style>
</x-app-layout>
