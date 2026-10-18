@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ filled($title ?? null) && $title !== config('app.name') ? $title.' | '.config('app.name') : config('app.name') }}</title>

        <x-site-verification />

        <link rel="icon" href="{{ url('assets/img/favicon.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ url('assets/img/apple-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js', 'resources/scss/soft-ui-dashboard.scss'])
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Content -->
            <main>

                {{ $slot }}
            </main>

            <x-loading-overlay />
        </div>

        @livewireScripts
    </body>
</html>
