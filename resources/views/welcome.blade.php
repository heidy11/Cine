<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cine Monje Campero</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background:rgb(34, 0, 68);
                        
            background-size: cover;
            color:rgb(221, 188, 0); /* Dorado */
            font-family: 'Instrument Sans', sans-serif;
        }
        .welcome-page {
    background: rgb(34, 0, 68);
    background-size: cover;
    color: rgb(221, 188, 0); /* dorado */
    font-family: 'Instrument Sans', sans-serif;
}


        .logo {
            width: 180px;
            height: auto;
            margin-bottom: 1.5rem;
            animation: fadeIn 2s ease-in-out;
        }

        .title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            animation: glowText 2s ease-in-out;
        }

        @keyframes glowText {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .btn {
            background-color: #ffd700;
            color: #320064;
            padding: 12px 24px;
            border-radius: 9999px;
            font-weight: 600;
            margin: 10px;
            display: inline-block;
            transition: 0.3s;
        }

        .btn:hover {
            background-color:rgb(46, 0, 84);
            color: white;
            transform: scale(1.05);
        }
    </style>
</head>
<body class="welcome-page flex flex-col justify-center items-center min-h-screen text-center px-4">

    
    <!-- Logo -->
    <img src="{{ asset('imagenes/logo-monje-campero.png') }}" alt="Logo Monje Campero" class="logo">

    <!-- Texto principal -->
    <h1 class="title">Bienvenido a Cine Monje Campero</h1>
    <p class="text-lg mb-6">Gracias por visitarnos.</p>

    <!-- Botones -->
    @if (Route::has('login'))
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn">Ir al Panel</a>
            @else
                <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn">Registrarse</a>
                @endif
            @endauth
        </div>
    @endif

</body>
</html>
