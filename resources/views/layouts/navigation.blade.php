<nav class="bg-[#220044] border-b-4 border-yellow-500 shadow-xl font-sans">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between items-center h-20">
            <!-- Sección izquierda -->
            <div class="flex items-center gap-10">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('imagenes/logo-monje-campero.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
                </a>

                <!-- CRUD solo para admin -->
                @if(session('usuario_rol') == 1)
                    <a href="{{ route('salas.index') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                        🎟️ Salas
                    </a>
                    <a href="{{ route('peliculas.index') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                        🎬 Películas
                    </a>
                    <a href="{{ route('funciones.index') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                        📅 Funciones
                    </a>
                    <a href="{{ route('admin.comprobantes') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                        📄 Comprobantes
                    </a>
                    <a href="{{ route('admin.comprobantes') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                        Mis entradas
                    </a>
                   
                @endif

                <!-- Cartelera igual que los demás -->
                <a href="{{ route('cartelera') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                    🎞️ Ver Cartelera
                </a>
            </div>

            <!-- Sección derecha -->
            @if(Auth::check())
                <div class="relative" x-data="{ open: false }">
                    <button onclick="document.getElementById('dropdown-user').classList.toggle('hidden')"
                        class="text-lg font-semibold text-white hover:text-yellow-300 transition duration-300">
                        {{ Auth::user()->nombre }} <span class="ml-2">▼</span>
                    </button>

                    <div id="dropdown-user" class="absolute right-0 mt-3 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-50 overflow-hidden">
                    <a href="{{ route('perfil.edit') }}" 
        class="block w-full text-left px-5 py-3 text-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
        👤 Perfil
    </a>   
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-5 py-3 text-md font-medium text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                🚪 Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-6">
                    <a href="{{ route('login') }}" class="text-lg font-semibold text-white hover:text-yellow-400 transition duration-300">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="text-lg font-semibold text-white hover:text-yellow-400 transition duration-300">
                        Registrarse
                    </a>
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
