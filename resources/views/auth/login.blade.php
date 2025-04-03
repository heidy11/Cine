<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Título -->
        <h2 class="text-2xl font-bold text-[#320064] text-center mb-4">Iniciar sesión</h2>

        <!-- Correo -->
        <div class="text-left">
            <x-input-label for="correo" :value="__('Correo')" class="text-left text-[#ffd700]" />
            <x-text-input id="correo" class="block mt-1 w-full"
                type="email"
                name="correo"
                :value="old('correo')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('correo')" class="mt-2 text-left" />
        </div>

        <!-- Contraseña -->
        <div class="text-left">
            <x-input-label for="contrasena" :value="__('Contraseña')" class="text-left text-[#ffd700]" />
            <x-text-input id="contrasena" class="block mt-1 w-full"
                type="password"
                name="contrasena"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('contrasena')" class="mt-2 text-left" />
        </div>

        <!-- Recordarme -->
        <div class="block mt-4 text-left">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-yellow-500 text-yellow-500 shadow-sm focus:ring-yellow-500" name="remember">
                <span class="ml-2 text-sm text-yellow-300">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-yellow-300 hover:text-yellow-500" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <button type="submit" class="btn-primary">
                {{ __('Iniciar sesión') }}
            </button>
        </div>
    </form>
</x-guest-layout>
