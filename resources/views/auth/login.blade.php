<x-guest-layout>
    <div class="w-full max-w-md bg-[#220044] p-8 rounded-xl shadow-lg text-white mx-auto mt-12">
        
        <!-- Título -->
        <h2 class="text-3xl font-bold text-yellow-400 text-center mb-6">Iniciar Sesión</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Correo -->
            <div>
                <label for="correo" class="block text-sm font-semibold text-yellow-300 mb-1">Correo</label>
                <input id="correo" name="correo" type="email" required autofocus
    pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
    value="{{ old('correo') }}"
    class="w-full px-4 py-2 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400"> 
            </div>

            <!-- Contraseña -->
            <div>
                <label for="contrasena" class="block text-sm font-semibold text-yellow-300 mb-1">Contraseña</label>
                <input id="contrasena" name="contrasena" type="password" required
                    class="w-full px-4 py-2 bg-white text-black rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <x-input-error :messages="$errors->get('contrasena')" class="mt-2 text-sm text-red-400" />
            </div>

            <!-- Recordarme -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="h-4 w-4 text-yellow-400 border-gray-300 rounded focus:ring-yellow-400">
                <label for="remember_me" class="ml-2 block text-sm text-yellow-300">
                    Recordarme
                </label>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-yellow-300 hover:text-yellow-500 underline">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <button type="submit"
                    class="bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-2 px-5 rounded-lg transition duration-300">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
