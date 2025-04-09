<x-guest-layout>
    <div class="w-full max-w-md bg-[#220044] p-8 rounded-xl shadow-lg text-white mx-auto mt-12">
       

        <h2 class="text-3xl font-bold text-yellow-400 text-center mb-6">Crear Cuenta</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-semibold text-yellow-300 mb-1">Nombre</label>
                <input id="nombre" name="nombre" type="text" required autofocus value="{{ old('nombre') }}"
                    class="w-full px-4 py-2 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Correo -->
            <div>
                <label for="correo" class="block text-sm font-semibold text-yellow-300 mb-1">Correo</label>
                <input id="correo" name="correo" type="email" required value="{{ old('correo') }}"
                    class="w-full px-4 py-2 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <x-input-error :messages="$errors->get('correo')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Contraseña -->
            <div>
                <label for="contrasena" class="block text-sm font-semibold text-yellow-300 mb-1">Contraseña</label>
                <input id="contrasena" name="contrasena" type="password" required
                    class="w-full px-4 py-2 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <x-input-error :messages="$errors->get('contrasena')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="contrasena_confirmation" class="block text-sm font-semibold text-yellow-300 mb-1">Confirmar Contraseña</label>
                <input id="contrasena_confirmation" name="contrasena_confirmation" type="password" required
                    class="w-full px-4 py-2 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <x-input-error :messages="$errors->get('contrasena_confirmation')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('login') }}" class="text-sm text-yellow-300 hover:text-yellow-500 underline">
                    ¿Ya tienes una cuenta?
                </a>
                <button type="submit"
                    class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-5 rounded-lg transition duration-300">
                    Registrarse
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
