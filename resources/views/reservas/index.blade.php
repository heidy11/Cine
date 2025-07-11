
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Mis Reservas
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 bg-white rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Mis Reservas</h1>

        @if($reservas->isEmpty())
            <p>No tienes reservas registradas.</p>
        @else
            <ul class="space-y-4">
                @foreach($reservas as $reserva)
                    @if($reserva->funcion && $reserva->funcion->pelicula)
                        <li class="p-4 border rounded shadow-sm bg-gray-50">
                            🎬 <strong>{{ $reserva->funcion->pelicula->titulo }}</strong><br>
                            🪑 Butaca: {{ $reserva->butaca->numero ?? 'N/A' }}<br>
                            📅 Fecha: {{ $reserva->funcion->fecha_inicio }}<br>
                            ⏰ Hora: {{ $reserva->funcion->hora_inicio }}<br>
                            🎟️ Estado: 
                            @if($reserva->estado === 'confirmada')
                                <span class="text-green-600 font-semibold">Confirmada</span>
                            @elseif($reserva->estado === 'rechazada')
                                <span class="text-red-600 font-semibold">Rechazada</span>
                            @else
                                <span class="text-yellow-600 font-semibold">Pendiente</span>
                            @endif

                            {{-- Comprobante si existe --}}
                            @if($reserva->comprobante)
                                <div class="mt-2">
                                    📄 Comprobante: 
                                    <a href="{{ asset('storage/' . $reserva->comprobante) }}" target="_blank" class="text-blue-600 underline">Ver archivo</a>
                                </div>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>

