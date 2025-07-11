<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-center">🛠️ Editor de Sala</h1>

        <div class="flex flex-col items-center space-y-2">
            @foreach ($matriz as $fila)
                <div class="flex space-x-1">
                    @foreach ($fila as $butaca)
                        @php
                            $color = $butaca->estado == 0 ? 'bg-gray-500' : 'bg-blue-400';
                        @endphp
                        <div
                            class="butaca w-12 sm:w-10 h-12 sm:h-10 rounded text-white font-bold flex items-center justify-center cursor-pointer {{ $color }}"
                            data-id="{{ $butaca->id_butaca }}"
                            data-numero="{{ $butaca->numero }}"
                            data-estado="{{ $butaca->estado }}"
                            title="Click para editar">
                            {{ $butaca->numero }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center">
            <div class="bg-white rounded p-6 space-y-4 w-11/12 max-w-md">

                <h2 class="text-xl font-bold text-center">Editar Butaca</h2>
                <form id="form-editar">
                    @csrf
                    <input type="hidden" name="id_butaca" id="input-id">
                    <div>
                        <label class="font-semibold">Número de butaca</label>
                        <input type="text" name="numero" id="input-numero" class="w-full border rounded px-2 py-1">
                    </div>
                    <div>
                        <label class="font-semibold">Tipo</label>
                        <select name="estado" id="input-estado" class="w-full border rounded px-2 py-1">
                            <option value="0">Asiento</option>
                            <option value="1">Pasillo</option>
                        </select>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">💾 Guardar</button>
                        <button type="button" id="cancelar" class="ml-2 text-gray-600">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-center mt-6">
    <button id="guardar-todo" class="bg-green-600 text-white font-bold px-6 py-2 rounded hover:bg-green-700">
        💾 Guardar todos los cambios
    </button>
</div>

    </div>

    <script>
    let cambiosPendientes = {};

    document.querySelectorAll('.butaca').forEach(div => {
        div.addEventListener('click', () => {
            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('input-id').value = div.dataset.id;
            document.getElementById('input-numero').value = div.dataset.numero;
            document.getElementById('input-estado').value = div.dataset.estado;
        });
    });

    document.getElementById('cancelar').addEventListener('click', () => {
        document.getElementById('modal').classList.add('hidden');
    });

    document.getElementById('form-editar').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('input-id').value;
        const numero = document.getElementById('input-numero').value;
        const estado = document.getElementById('input-estado').value;

        cambiosPendientes[id] = { id_butaca: id, numero, estado };

        // Marcar la butaca modificada visualmente
        const butacaDiv = document.querySelector(`.butaca[data-id="${id}"]`);
        butacaDiv.dataset.numero = numero;
        butacaDiv.dataset.estado = estado;
        butacaDiv.classList.remove('bg-blue-400', 'bg-gray-500');
        butacaDiv.classList.add(estado == 1 ? 'bg-blue-400' : 'bg-gray-500');
        butacaDiv.textContent = numero;

        document.getElementById('modal').classList.add('hidden');
    });

    // Enviar todos los cambios al hacer clic en Guardar Cambios
    document.getElementById('guardar-todo').addEventListener('click', () => {
        if (Object.keys(cambiosPendientes).length === 0) {
            alert('No hay cambios por guardar.');
            return;
        }

        fetch("{{ route('butaca.actualizar') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                cambios: Object.values(cambiosPendientes)
            }),
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('✅ Cambios guardados correctamente');
                location.reload();
            } else {
                alert('❌ Error al guardar');
            }
        });
    });
</script>

</x-app-layout>
