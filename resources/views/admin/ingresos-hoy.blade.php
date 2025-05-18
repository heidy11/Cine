<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow">

        <!-- Formulario con calendario -->
        

        <!-- Título con fecha -->
        <h1 class="text-3xl font-bold mb-6 text-center text-[#220044]">
            💵 Ingresos del {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
        </h1>
        <form method="GET" action="{{ route('ingresos.hoy') }}" class="mb-4 text-center">
            <label for="fecha" class="mr-2 font-semibold">Seleccionar fecha:</label>
            <input type="date" id="fecha" name="fecha"
                   value="{{ \Carbon\Carbon::parse($fecha)->toDateString() }}"
                   max="{{ \Carbon\Carbon::now()->toDateString() }}"
                   class="border rounded px-2 py-1">

            <button type="submit" class="ml-2 px-4 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                Buscar
            </button>
        </form>

        @if ($ventas->isEmpty())
            <p class="text-center text-gray-600">No se registraron ingresos en esta fecha.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Película</th>
                            <th class="border px-4 py-2">Sala</th>
                            <th class="border px-4 py-2">Butaca</th>
                            <th class="border px-4 py-2">Precio</th>
                            <th class="border px-4 py-2">Hora de Venta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td class="border px-4 py-2">{{ $venta->funcion->pelicula->titulo ?? 'N/D' }}</td>
                                <td class="border px-4 py-2">{{ $venta->funcion->sala->nombre ?? 'N/D' }}</td>
                                <td class="border px-4 py-2">
                                   Butaca {{ $venta->butaca->numero}}
                                </td>
                                <td class="border px-4 py-2">Bs {{ number_format($venta->funcion->precio, 2) }}</td>
                                <td class="border px-4 py-2">{{ $venta->updated_at->format('H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-200 font-bold">
                            <td colspan="3" class="border px-4 py-2 text-right">Total:</td>
                            <td colspan="2" class="border px-4 py-2 text-left">Bs {{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
