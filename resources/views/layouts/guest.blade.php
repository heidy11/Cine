<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Monje Campero</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Vite (Tailwind) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background-color: #220044; /* Morado oscuro */
            font-family: 'Instrument Sans', sans-serif;
            color: #FFD700; /* Dorado */
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center items-center px-4">

    <!-- Logo centrado con margen ajustado -->
    <div class="mb-4 mt-2">
        <a href="/">
            <img src="{{ asset('imagenes/logo-monje-campero.png') }}" alt="Logo Monje Campero" class="h-16 w-auto">
        </a>
    </div>

    <!-- Contenido del slot (login, register, etc.) -->
    <div class="w-full max-w-md">
        {{ $slot }}
    </div>

</body>
</html>
