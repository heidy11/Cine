<x-app-layout>

<div class="max-w-2xl mx-auto mt-12 p-8 bg-white rounded-xl shadow-md">

    <h1 class="text-3xl font-bold text-center mb-8 text-[#220044]">👤 Editar Perfil</h1>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-6 text-center font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('perfil.update') }}">
        @csrf

        <!-- Nombre -->
        <div class="mb-6">
            <label for="nombre" class="block mb-2 text-lg font-semibold text-gray-700">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required
                class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-yellow-400 focus:outline-none">
            @error('nombre')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Correo -->
        <div class="mb-6">
            <label for="correo" class="block mb-2 text-lg font-semibold text-gray-700">Correo electrónico</label>
            <input type="email" id="correo" name="correo" value="{{ old('correo', $usuario->correo) }}" required
                class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-yellow-400 focus:outline-none">
            @error('correo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Contraseña nueva -->
        <div class="mb-6">
            <label for="contrasena" class="block mb-2 text-lg font-semibold text-gray-700">Nueva contraseña (opcional)</label>
            <input type="password" id="contrasena" name="contrasena"
                class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-yellow-400 focus:outline-none">
            @error('contrasena')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirmar contraseña -->
        <div class="mb-6">
            <label for="contrasena_confirmation" class="block mb-2 text-lg font-semibold text-gray-700">Confirmar nueva contraseña</label>
            <input type="password" id="contrasena_confirmation" name="contrasena_confirmation"
                class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-yellow-400 focus:outline-none">
        </div>

        <!-- Botón de Guardar -->
        <div class="flex justify-center">
            <button type="submit"
                class="bg-[#220044] hover:bg-yellow-400 hover:text-black text-white font-bold py-3 px-8 rounded-full transition-all duration-300 shadow-md">
                Guardar cambios
            </button>
        </div>

    </form>

</div>

</x-app-layout>
