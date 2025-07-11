<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg">
            <h1 class="text-4xl font-extrabold text-center text-[#220044] mb-8">
                ➕ Crear Nueva Sala
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('salas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nombre -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Nombre:</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500" required>
                </div>

                <!-- Capacidad -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Capacidad:</label>
                    <input type="number" name="capacidad" value="{{ old('capacidad') }}"
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500" required>
                </div>

                <!-- Número de filas -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Número de filas:</label>
                    <input type="number" name="numero_fila" value="{{ old('numero_fila') }}"
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500" required>
                </div>

                <!-- Número de columnas -->
                <div>
                    <label class="block text-[#220044] font-semibold mb-2">Número de columnas:</label>
                    <input type="number" name="numero_columna" value="{{ old('numero_columna') }}"
                        class="border border-gray-300 rounded-lg px-4 py-3 w-full focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500" required>
                </div>

                <!-- Botones -->
                <div class="flex justify-between">
                    <button type="submit" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                        ✅ Guardar
                    </button>
                    <a href="{{ route('salas.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transform hover:scale-105 transition">
                        ❌ Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
