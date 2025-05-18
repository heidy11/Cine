<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-6 text-center">📊 Historial de Ventas</h1>

        <form method="GET" action="{{ route('ventas.historial') }}" class="mb-4 text-center">
            <label for="fecha" class="mr-2 font-semibold">Seleccionar fecha:</label>
            <input type="date" id="fecha" name="fecha" value="{{ $fecha }}" max="{{ \Carbon\Carbon::now()->toDateString() }}" class="border rounded px-2 py-1">

            <button type="submit" class="ml-2 px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                Buscar
            </button>
        </form>

        @if($ventas->isEmpty())
            <p class="text-center text-gray-600">No se encontraron ventas para la fecha seleccionada.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Película</th>
                            <th class="border px-4 py-2">Sala</th>
                            <th class="border px-4 py-2">Butaca</th>
                            <th class="border px-4 py-2">Fecha de Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td class="border px-4 py-2">{{ $venta->funcion->pelicula->titulo ?? 'N/D' }}</td>
                                <td class="border px-4 py-2">{{ $venta->funcion->sala->nombre ?? 'N/D' }}</td>
                                <td class="border px-4 py-2">
                                Butaca {{ $venta->butaca->numero ?? 'N/D' }}
                                </td>
                                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($venta->updated_at)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
