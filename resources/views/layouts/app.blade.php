<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @if(app()->environment('local'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <link rel="stylesheet" href="{{ asset('build/assets/app-3uyo-f8V.css') }}">
            <script src="{{ asset('build/assets/app-DOogdlbK.js') }}" defer></script>
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <!-- Simple Toast -->
            @if(session('success'))
                <div id="toast" class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow z-50">
                    ✓ {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="ml-2">×</button>
                </div>
                <script>setTimeout(() => document.getElementById('toast')?.remove(), 3000);</script>
            @endif
        </div>
    </body>
</html>
