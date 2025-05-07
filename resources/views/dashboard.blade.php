<x-app-layout>
    <div class="min-h-screen bg-[#220044] py-10 px-6">

        <!-- Título principal -->
        <h1 class="text-5xl font-extrabold text-center text-yellow-400 mb-14 drop-shadow-lg animate-pulse">
            🎬 Panel de Administración
        </h1>

        <!-- Tarjetas de resumen interactivas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-14">
            
            <!-- Películas activas -->
            <a href="{{ route('peliculas.index') }}" class="block bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition duration-500 text-center">
                <div class="text-5xl text-[#220044] mb-4">🎥</div>
                <h2 class="text-xl font-bold text-[#220044]">Películas Activas</h2>
                <p class="text-4xl font-extrabold text-[#220044] mt-2">{{ $peliculas }}</p>
            </a>

            <!-- Funciones programadas -->
            <a href="{{ route('funciones.index') }}" class="block bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition duration-500 text-center">
                <div class="text-5xl text-[#220044] mb-4">🎟️</div>
                <h2 class="text-xl font-bold text-[#220044]">Funciones Programadas</h2>
                <p class="text-4xl font-extrabold text-[#220044] mt-2">{{ $funciones }}</p>
            </a>

            <!-- Entradas vendidas hoy -->
            <a href="{{ route('funciones.index') }}" class="block bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition duration-500 text-center">
                <div class="text-5xl text-[#220044] mb-4">🎫</div>
                <h2 class="text-xl font-bold text-[#220044]">Entradas Vendidas Hoy</h2>
                <p class="text-4xl font-extrabold text-[#220044] mt-2">{{ $entradasVendidasHoy }}</p>
            </a>

            <!-- Ingresos de hoy -->
            <a href="{{ route('funciones.index') }}" class="block bg-white p-8 rounded-2xl shadow-xl transform hover:scale-105 transition duration-500 text-center">
                <div class="text-5xl text-[#220044] mb-4">💵</div>
                <h2 class="text-xl font-bold text-[#220044]">Ingresos de Hoy</h2>
                <p class="text-4xl font-extrabold text-[#220044] mt-2">Bs {{ number_format($ingresosHoy, 2) }}</p>
            </a>

        </div>

        <!-- Accesos rápidos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-14">
            <a href="{{ route('peliculas.create') }}" class="block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-6 rounded-2xl text-center shadow-lg transition transform hover:scale-105">
                🎥 Nueva Película
            </a>
            <a href="{{ route('funciones.create') }}" class="block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-6 rounded-2xl text-center shadow-lg transition transform hover:scale-105">
                🎟️ Nueva Función
            </a>
            <a href="{{ route('salas.index') }}" class="block bg-yellow-400 hover:bg-yellow-300 text-[#220044] font-bold py-6 rounded-2xl text-center shadow-lg transition transform hover:scale-105">
                🏛️ Gestionar Salas
            </a>
        </div>

        <!-- Futuro: Gráficas de resumen -->
        <div class="bg-white p-8 rounded-2xl shadow-2xl text-center">
            <h2 class="text-3xl font-bold text-[#220044] mb-6">📈 Resumen de Ventas (próximamente)</h2>
            <p class="text-gray-600 italic">Aquí podrás ver gráficas dinámicas de tus ingresos y ventas por película.</p>
        </div>

    </div>
</x-app-layout>
