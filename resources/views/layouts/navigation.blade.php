<nav class="bg-[#220044] border-b-4 border-yellow-500 shadow-xl font-sans">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between items-center h-20">
            <!-- Logo y botón hamburguesa -->
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <img src="{{ asset('imagenes/logo-monje-campero.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
                </a>

                <!-- Botón hamburguesa -->
                <button id="nav-toggle" class="md:hidden text-yellow-400 text-3xl focus:outline-none">
                    ☰
                </button>
            </div>

           <!-- Menú de navegación -->
<div id="nav-menu"
     class="hidden md:flex md:flex-row flex-col md:items-center md:gap-6 absolute md:static top-20 left-0 w-full md:w-auto bg-[#220044] md:bg-transparent z-40 px-6 py-6 md:py-0 space-y-3 md:space-y-0 shadow-lg md:shadow-none rounded-b-xl md:rounded-none">

    <!-- Enlaces de Admin -->
    @if(session('usuario_rol') == 1)
        <div class="flex flex-col md:flex-row gap-3 md:gap-6 w-full md:w-auto">
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
            <a href="{{ route('ventas.historial') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
                📊 Historial de ventas
            </a>
        </div>
    @endif

    <!-- Enlaces comunes -->
    <div class="flex flex-col md:flex-row gap-3 md:gap-6 w-full md:w-auto">
        <a href="{{ route('cartelera') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
            🎞️ Ver Cartelera
        </a>
        <a href="{{ route('mis-entradas') }}" class="text-lg font-semibold tracking-wide text-white hover:text-yellow-400 transition-all duration-300">
            🏷️ Mis Entradas
        </a>
    </div>

    <!-- Usuario autenticado o no -->
    @if(Auth::check())
        <div class="relative md:ml-4 w-full md:w-auto mt-3 md:mt-0">
            <button onclick="document.getElementById('dropdown-user').classList.toggle('hidden')"
                    class="text-lg font-semibold text-white hover:text-yellow-300 transition duration-300 w-full md:w-auto text-left">
                {{ Auth::user()->nombre }} <span class="ml-2">▼</span>
            </button>
            <div id="dropdown-user"
                 class="absolute md:right-0 left-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl hidden z-50 overflow-hidden">
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
        <div class="flex flex-col md:flex-row gap-3 md:gap-6 w-full md:w-auto mt-3 md:mt-0">
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
    </div>
</nav>

<!-- Scripts -->
<script>
    // Cerrar menú del usuario al hacer clic fuera
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('dropdown-user');
        const trigger = dropdown?.previousElementSibling;

        if (dropdown && !dropdown.contains(e.target) && !trigger.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Toggle menú hamburguesa
    document.getElementById('nav-toggle').addEventListener('click', function () {
        const menu = document.getElementById('nav-menu');
        menu.classList.toggle('hidden');
    });
</script>
