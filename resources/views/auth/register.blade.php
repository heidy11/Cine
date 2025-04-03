<x-guest-layout>
    <div class="flex flex-col items-center text-center mb-6">
        
        <h1 class="text-2xl font-semibold text-[#FFD700]">Crear cuenta</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4 text-left">
        @csrf

        <!-- Nombre -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Correo Electrónico -->
        <div>
            <x-input-label for="correo" :value="__('Correo')" />
            <x-text-input id="correo" class="block mt-1 w-full" type="email" name="correo" :value="old('correo')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div>
            <x-input-label for="contrasena" :value="__('Contraseña')" />
            <x-text-input id="contrasena" class="block mt-1 w-full" type="password" name="contrasena" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('contrasena')" class="mt-2" />
        </div>

        <!-- Confirmar Contraseña -->
        <div>
            <x-input-label for="contrasena_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="contrasena_confirmation" class="block mt-1 w-full" type="password" name="contrasena_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('contrasena_confirmation')" class="mt-2" />
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-200 hover:text-white" href="{{ route('login') }}">
                ¿Ya tienes una cuenta?
            </a>
            <x-primary-button class="bg-[#FFD700] text-[#220044] hover:bg-yellow-400 font-semibold">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
