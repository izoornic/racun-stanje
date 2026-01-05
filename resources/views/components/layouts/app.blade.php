<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upravnik zgrade stanje</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
        @livewireStyles
    </head>
    <body>
        <div x-data="{ dark: localStorage.getItem('darkMode') === 'true' || false, init() {this.$watch('dark', value => localStorage.setItem('darkMode', value))}}" 
                    :class="{ 'dark': dark }">
            <div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors">
                <!-- Header -->
                <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-10">
                    <div class="px-4 py-1 flex items-center justify-between max-w-md mx-auto">
                        <x-icon-logo-large class="w-30 h-12" />
                        <h1 class="text-xl text-gray-900 dark:text-white">
                            Dobrodošli
                        </h1>
                        <button 
                            @click="dark = !dark"
                            type="button"
                            class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <svg x-show="!dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg x-show="dark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </div>
                </header>
                {{ $slot }}
                <livewire:modal />
            </div>
        </div>
        @livewireScripts
    </body>
</html>