<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">📄 Comprobantes de Reservas Confirmadas</h1>

        @if($comprobantes->isEmpty())
            <p class="text-center text-gray-600">No hay comprobantes registrados aún.</p>
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
                            <th class="border px-4 py-2">Usuario</th>
                            <th class="border px-4 py-2">Comprobante</th>
                            <th class="border px-4 py-2">Validar</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comprobantes as $c)
                            <tr>
                                <td class="border px-4 py-2">{{ $c->pelicula }}</td>
                                <td class="border px-4 py-2">{{ $c->sala }}</td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</td>
                                <td class="border px-4 py-2">{{ substr($c->hora, 0, 5) }}</td>
                                <td class="border px-4 py-2">{{ $c->butaca }}</td>
                                <td class="border px-4 py-2">{{ $c->usuario }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ asset('storage/' . $c->comprobante) }}" target="_blank" class="text-blue-600 underline">Ver</a>
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    @if($c->estado == 1)
                                        <form action="{{ route('admin.comprobantes.aceptar', $c->id_funcion_butaca) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="bg-green-500 text-white px-2 py-1 rounded">Aceptar</button>
                                        </form>
                                        <form action="{{ route('admin.comprobantes.rechazar', $c->id_funcion_butaca) }}" method="POST" class="inline ml-2">
                                            @csrf
                                            <button class="bg-red-500 text-white px-2 py-1 rounded">Rechazar</button>
                                        </form>
                                    @elseif($c->estado == 2)
                                        <span class="text-green-600 font-semibold">✅ Comprobante aceptado</span>
                                    @else
                                        <span class="text-gray-500 italic">Sin acción</span>
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
