<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl">
            <h1 class="text-4xl font-extrabold text-center text-[#220044] mb-8">🎭 Agregar Nueva Función</h1>

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

            <form action="{{ route('funciones.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Película --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">🎬 Película:</label>
                    <select name="pelicula_id" required class="form-select">
                        <option value="" disabled selected>Seleccione una película</option>
                        @foreach($peliculas as $pelicula)
                            <option value="{{ $pelicula->id_pelicula }}">{{ $pelicula->titulo }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Sala --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">🏛️ Sala:</label>
                    <select name="sala_id" required class="form-select">
                        <option value="" disabled selected>Seleccione una sala</option>
                        @foreach($salas as $sala)
                            <option value="{{ $sala->id_sala }}">{{ $sala->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Nueva selección de fechas con Flatpickr --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">📅 Fechas en que estará disponible:</label>
                    <input type="text" id="fechas" name="fechas" class="form-input" placeholder="Selecciona una o más fechas" required>
                </div>

                {{-- Hora inicio y fin --}}
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-[#220044] font-semibold mb-2">🕒 Hora de Inicio:</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-input" required>
                    </div>
                    <div class="w-1/2">
                        <label class="block text-[#220044] font-semibold mb-2">🕕 Hora de Fin:</label>
                        <input type="time" name="hora_fin" id="hora_fin" class="form-input" required>
                    </div>
                </div>

                {{-- Formato --}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">📽️ Formato:</label>
                
                    <select name="formato" required class="form-select">
                        <option value="" disabled selected>Seleccione un formato</option>
                        <option value="2D">2D</option>
                        <option value="3D">3D</option>
                    </select>
                </div>
                {{--PRecio--}}
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">💵 Precio:</label>
                    <input type="number" name="precio" class="form-input" placeholder="Precio de la entrada" required>
                </div>

                {{-- Botones --}}
                <div class="flex justify-between">
                    <button type="submit" class="btn-yellow">✅ Guardar</button>
                    <a href="{{ route('funciones.index') }}" class="btn-gray">❌ Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Flatpickr (para fechas múltiples) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#fechas", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            minDate: "today",
        });

        // Sugerir hora_fin automáticamente
        document.addEventListener('DOMContentLoaded', () => {
            const horaInicio = document.getElementById('hora_inicio');
            const horaFin = document.getElementById('hora_fin');

            horaInicio.addEventListener('change', () => {
                if (horaInicio.value) {
                    const [h, m] = horaInicio.value.split(':');
                    let hora = new Date();
                    hora.setHours(parseInt(h));
                    hora.setMinutes(parseInt(m) + 90);

                    const hh = String(hora.getHours()).padStart(2, '0');
                    const mm = String(hora.getMinutes()).padStart(2, '0');

                    horaFin.value = `${hh}:${mm}`;
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
