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
                            <th class="border px-4 py-2">Entrada</th>

                        </tr>
                    </thead>
                   <tbody>
    @foreach($misEntradas as $entrada)
        <tr>
            {{-- Película --}}
            <td class="border px-4 py-2">
                {{ optional(optional($entrada->funcion)->pelicula)->titulo ?? 'Sin película' }}
            </td>
            
            {{-- Sala --}}
            <td class="border px-4 py-2">
                {{ optional(optional($entrada->funcion)->sala)->nombre ?? 'Sin sala' }}
            </td>
            
            {{-- Fecha --}}
            <td class="border px-4 py-2">
                {{ optional($entrada->funcion)->fecha_inicio ?? 'Sin fecha' }}
            </td>
            
            {{-- Hora --}}
            <td class="border px-4 py-2">
                {{ optional($entrada->funcion)->hora_inicio ?? 'Sin hora' }}
            </td>
            
            {{-- Butaca --}}
            <td class="border px-4 py-2">
                {{ optional($entrada->butaca)->numero ?? 'Sin butaca' }}
            </td>
            
            {{-- Estado --}}
            <td class="border px-4 py-2">
                @if($entrada->estado == 2)
                    @if($entrada->usado == 1)
                        <span class="text-gray-500 font-semibold">🎟️ Usado</span>
                    @else
                        <span class="text-green-600 font-semibold">✅ Confirmado</span>
                    @endif
                @elseif($entrada->estado == 1)
                    <span class="text-yellow-500 font-semibold">⏳ Pendiente</span>
                @else
                    <span class="text-gray-500 italic">Sin estado</span>
                @endif
            </td>
            
            {{-- Entrada --}}
            <td class="border px-4 py-2 text-center">
                @if($entrada->estado == 2 && $entrada->usado == 0)
                    <a href="{{ route('usuario.boleto.ver', $entrada->id_funcion_butaca) }}"
                        class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold text-sm py-1 px-3 rounded shadow transition">
                        📲 Ver entrada
                    </a>
                @else
                    <span class="text-gray-400 italic text-sm">No disponible</span>
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
