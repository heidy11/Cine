<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-purple-800 to-purple-900 py-10 px-4">

        <!-- Título principal -->
        <h1 class="text-4xl font-extrabold text-center text-yellow-400 mb-10 drop-shadow-md">
            🎬 Panel de Administración
        </h1>

        <!-- Tarjetas de resumen -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Películas -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
    <h2 class="text-lg font-bold text-gray-700">Películas activas</h2>
    <p class="text-4xl font-extrabold text-purple-700 mt-4">{{ $peliculas }}</p>
</div>


            <!-- Funciones -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-lg font-bold text-gray-700">Funciones programadas</h2>
                <p class="text-4xl font-extrabold text-purple-700 mt-4">{{ $funciones }}</p>
            </div>

            <!-- Entradas vendidas hoy -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-lg font-bold text-gray-700">Entradas vendidas hoy</h2>
                <p class="text-4xl font-extrabold text-purple-700 mt-4">{{ $entradasVendidasHoy }}</p>
            </div>

            <!-- Ingresos de hoy -->
            <div class="bg-white p-6 rounded-2xl shadow-lg text-center">
                <h2 class="text-lg font-bold text-gray-700">Ingresos hoy</h2>
                <p class="text-4xl font-extrabold text-purple-700 mt-4">Bs {{ number_format($ingresosHoy, 2) }}</p>
            </div>
        </div>

        <!-- Accesos rápidos -->
        

        <!-- (Opcional) Lugar para futuras gráficas -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-700 mb-4 text-center">📈 Resumen de ventas (próximamente)</h2>
            <div class="text-center text-gray-500 italic">
                Aquí puedes agregar gráficos usando Chart.js en el futuro
            </div>
        </div>

    </div>
</x-app-layout>
