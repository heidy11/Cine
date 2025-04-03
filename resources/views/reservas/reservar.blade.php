<x-app-layout>
    <div class="container mx-auto p-6 bg-white rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-6">Selecciona tus butacas 🎟️</h1>

        <form method="POST" action="{{ route('reservar') }}">
            @csrf
            <input type="hidden" name="funcion_id" value="{{ $funcion_id }}">

            @foreach($butacas_izquierda as $fila)
                <div class="flex space-x-2 mb-2">
                    @foreach($fila as $asiento)
                        <label class="butaca inline-block bg-gray-300 text-black px-3 py-2 rounded cursor-pointer transition-all duration-200">
                            <input type="checkbox" name="butacas[]" value="{{ $asiento['nombre'] }}" class="hidden">
                            {{ $asiento['numero'] }}
                        </label>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="mt-4 bg-blue-600 hover:bg-blue-700 text-black px-6 py-2 rounded">
                ✅ Confirmar reserva
            </button>
        </form>
    </div>

    {{-- Script para cambiar color al seleccionar --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const labels = document.querySelectorAll('.butaca');

            labels.forEach(label => {
                const checkbox = label.querySelector('input[type="checkbox"]');

                label.addEventListener('click', () => {
                    setTimeout(() => {
                        if (checkbox.checked) {
                            label.classList.remove('bg-gray-300');
                            label.classList.add('bg-green-500', 'text-black');
                        } else {
                            label.classList.add('bg-gray-300');
                            label.classList.remove('bg-green-500', 'text-black');
                        }
                    }, 10);
                });
            });
        });
    </script>
</x-app-layout>
