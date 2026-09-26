@props([
    'title' => null,
    'description' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ filled($title ?? null) && $title !== config('app.name') ? $title.' | '.config('app.name') : config('app.name') }}</title>

        <x-site-verification />

        <meta name="description" content="{{ $description ?? __('BisonBar is het afreken- en verkoopsysteem van '.config('bisonbar.organisation').'. Hier vind je uitleg over de werking van de applicatie en ons privacybeleid.') }}">

        <link rel="canonical" href="{{ url()->current() }}">

        <link rel="icon" href="{{ url('assets/img/favicon.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ url('assets/img/apple-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/scss/app.scss', 'resources/js/app.js', 'resources/scss/soft-ui-dashboard.scss'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 d-flex flex-column">
            <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center space-x-3 sm:space-x-8">
                            <a href="{{ route('info') }}" class="shrink-0 flex items-center">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                            </a>

                            <div class="hidden sm:flex sm:items-center sm:space-x-8">
                                <x-nav-link :href="route('info')" :active="request()->routeIs('info')">
                                    {{ config('app.name') }}
                                </x-nav-link>
                                <x-nav-link :href="route('privacy')" :active="request()->routeIs('privacy')">
                                    {{ __('Privacybeleid') }}
                                </x-nav-link>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <a href="{{ route('login') }}" class="btn bg-gradient-dark btn-sm mb-0">
                                {{ __('Inloggen') }}
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 mt-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm text-gray-600 dark:text-gray-400">
                        <p class="mb-0">
                            &copy; {{ date('Y') }} {{ config('bisonbar.organisation') }} &mdash; {{ config('app.name') }}
                        </p>

                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="{{ route('info') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                                    {{ __('Over de applicatie') }}
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ route('privacy') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                                    {{ __('Privacybeleid') }}
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="mailto:{{ config('bisonbar.contact_email') }}" class="text-gray-600 dark:text-gray-400 hover:underline">
                                    {{ __('Contact') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>

        <x-loading-overlay />
    </body>
</html>
