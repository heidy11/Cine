<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">🎟️ Historial de Entradas</h1>

        @if($misEntradas->isEmpty())
            <p class="text-center text-gray-600">Aún no tienes entradas registradas.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Película</th>
                            <th class="border px-4 py-2">Sala</th>
                            <th class="border px-4 py-2">Fecha</th>
                            <th class="border px-4 py-2">Hora</th>
                            <th class="border px-4 py-2">Butaca</th>
                            <th class="border px-4 py-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($misEntradas as $entrada)
                            <tr>
                                <td class="border px-4 py-2">{{ $entrada->funcion->pelicula->titulo }}</td>
                                <td class="border px-4 py-2">{{ $entrada->funcion->sala->nombre }}</td>
                                <td class="border px-4 py-2">{{ $entrada->funcion->fecha_inicio }}</td>
                                <td class="border px-4 py-2">{{ substr($entrada->funcion->hora_inicio, 0, 5) }}</td>
                                <td class="border px-4 py-2">F{{ $entrada->fila_pos }} - C{{ $entrada->columna_pos }}</td>
                                <td class="border px-4 py-2">
                                    @if($entrada->estado == 2)
                                        <span class="text-green-600 font-semibold">✅ Confirmado</span>
                                    @elseif($entrada->estado == 1)
                                        <span class="text-yellow-500 font-semibold">⏳ Pendiente</span>
                                    @else
                                        <span class="text-gray-500 italic">Sin estado</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
