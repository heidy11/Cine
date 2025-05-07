<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Reservas Pendientes
        </h2>
    </x-slot>

    <div class="container mx-auto p-6">
        @foreach($reservas as $reserva)
            <div class="border p-4 mb-4 rounded shadow bg-white">
                <p><strong>Usuario:</strong> {{ $reserva->usuario->name }}</p>
                <p><strong>Película:</strong> {{ $reserva->funcion->pelicula->titulo }}</p>
                <p><strong>Butaca:</strong> {{ $reserva->butaca->numero }}</p>
                <p><strong>Comprobante:</strong> 
                    @if($reserva->comprobante)
                        <a href="{{ asset('storage/' . $reserva->comprobante) }}" target="_blank" class="text-blue-600 underline">Ver comprobante</a>
                    @else
                        <span class="text-red-600">No enviado</span>
                    @endif
                </p>

                <!-- Botones de acción -->
                <div class="flex gap-2 mt-2">
                    <!-- Botón Confirmar -->
                    <form action="{{ route('reservas.confirmar.estado', ['id' => $reserva->id_reserva]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Confirmar</button>
                    </form>

                    <!-- Botón Rechazar -->
                    <form action="{{ route('reservas.rechazar.estado', ['id' => $reserva->id_reserva]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Rechazar</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
