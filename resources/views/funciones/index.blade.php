<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6">

        <h1 class="text-5xl font-extrabold text-center text-yellow-400 mb-10">
            🎭 Funciones Disponibles
        </h1>

        <!-- Botón agregar función -->
        <div class="flex justify-end mb-8">
            <a href="{{ route('funciones.create') }}" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-3 px-6 rounded-2xl shadow-md transform hover:scale-105 transition">
                ➕ Agregar Función
            </a>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-lg mb-8 shadow-md text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 border border-red-300 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabla de funciones -->
        <div class="overflow-x-auto bg-white rounded-2xl shadow-2xl">
            <table class="min-w-full table-auto">
            <thead class="bg-[#220044] text-yellow-400 uppercase">
    <tr>
        <th class="py-4 px-6 text-center">Película</th>
        <th class="py-4 px-6 text-center">Sala</th>
        <th class="py-4 px-6 text-center">Fecha Inicio</th>
        <th class="py-4 px-6 text-center">Fecha Fin</th>
        <th class="py-4 px-6 text-center">Hora Inicio</th>
        <th class="py-4 px-6 text-center">Hora Fin</th>
        <th class="py-4 px-6 text-center">Formato</th>
        <th class="py-4 px-6 text-center">Cartelera</th>
        <th class="py-4 px-6 text-center">Acciones</th>
    </tr>
</thead>
<tbody>
    @foreach ($funciones as $funcion)
        <tr class="border-b hover:bg-yellow-50 text-center">
            <td class="px-6 py-4 text-[#220044] font-semibold">{{ $funcion->pelicula->titulo }}</td>
            <td class="px-6 py-4 text-[#220044]">{{ $funcion->sala->nombre }}</td>
            <td class="px-6 py-4 text-[#220044]">{{ \Carbon\Carbon::parse($funcion->fecha_inicio)->format('d/m/Y') }}</td>
            <td class="px-6 py-4 text-[#220044]">{{ \Carbon\Carbon::parse($funcion->fecha_fin)->format('d/m/Y') }}</td>
            <td class="px-6 py-4 text-[#220044]">{{ $funcion->hora_inicio }}</td>
<td class="px-6 py-4 text-[#220044]">{{ $funcion->hora_fin }}</td>

            <td class="px-6 py-4 text-[#220044]">{{ $funcion->formato }}</td>
            <td class="px-6 py-4 text-[#220044]">{{ $funcion->duracion_cartelera }} días</td>
            <td class="px-6 py-4">
                <div class="flex justify-center space-x-3">
                    <a href="{{ route('funciones.edit', $funcion->id_funcion) }}" class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition">
                        ✏️ Editar
                    </a>
                    <form action="{{ route('funciones.destroy', $funcion->id_funcion) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta función?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded">Eliminar</button>
                    </form>

                </div>
            </td>
        </tr>
    @endforeach
</tbody>


            </table>
        </div>

    </div>
</x-app-layout>
