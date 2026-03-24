<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistem Antrian Puskesmas') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center px-4"
             style="background: linear-gradient(135deg, #1e1b4b 0%, #312e81 25%, #4338ca 50%, #3b82f6 75%, #06b6d4 100%);">
            <a href="/" class="text-white text-2xl font-extrabold tracking-tight drop-shadow-lg mb-6">
                Sistem Antrian Puskesmas
            </a>

            <div class="w-full max-w-md bg-white/95 backdrop-blur-sm shadow-2xl rounded-2xl p-6 border border-white/30">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>
        </div>
    </body>
</html>
