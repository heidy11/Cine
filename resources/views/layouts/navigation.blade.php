<nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('imagenes/logo-monje-campero.png') }}" alt="Logo" class="h-9 w-auto">
                </a>

                <!-- CRUD solo para admin -->
                @if(session('usuario_rol') == 1)
                    <a href="{{ route('salas.index') }}" class="text-sm font-medium text-gray-800 dark:text-gray-200 hover:text-yellow-500">Salas</a>
                    <a href="{{ route('peliculas.index') }}" class="text-sm font-medium text-gray-800 dark:text-gray-200 hover:text-yellow-500">Películas</a>
                    <a href="{{ route('funciones.index') }}" class="text-sm font-medium text-gray-800 dark:text-gray-200 hover:text-yellow-500">Funciones</a>
                @endif

                <!-- Cartelera -->
                <a href="{{ route('cartelera') }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-2 px-4 rounded-lg shadow">
                    🎬 Cartelera
                </a>
            </div>

            <!-- Usuario autenticado -->
            @if(Auth::check())
                <div class="relative" x-data="{ open: false }">
                    <button onclick="document.getElementById('dropdown-user').classList.toggle('hidden')"
                            class="text-sm font-semibold text-gray-800 dark:text-gray-200 hover:text-gray-500 focus:outline-none">
                        {{ Auth::user()->nombre }} <span class="ml-1">▼</span>
                    </button>

                    <div id="dropdown-user" class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 rounded-md shadow-lg hidden z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-800 dark:text-gray-300 hover:text-yellow-500">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="text-sm text-gray-800 dark:text-gray-300 hover:text-yellow-500">Registrarse</a>
                </div>
            @endif
        </div>
    </div>
</nav>

<!-- Script para cerrar el menú si haces clic afuera -->
<script>
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('dropdown-user');
        const trigger = dropdown?.previousElementSibling;

        if (dropdown && !dropdown.contains(e.target) && !trigger.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
