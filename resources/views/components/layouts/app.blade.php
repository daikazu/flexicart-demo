<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function applyTheme() {
                const storedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (storedTheme === 'dark' || (!storedTheme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            }
            applyTheme();
            function toggleDarkMode() {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            }
            document.addEventListener('livewire:navigating', () => {
                window.__darkMode = document.documentElement.classList.contains('dark');
            });
            document.addEventListener('livewire:navigated', () => {
                if (window.__darkMode) {
                    document.documentElement.classList.add('dark');
                }
            });
        </script>
        <title>{{ $title ?? 'FlexiCart Demo' }} - FlexiCart for Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-gray-50 text-gray-900 antialiased transition-colors duration-300 dark:bg-gray-900 dark:text-gray-100">
        <div class="flex min-h-screen flex-col">
            <!-- Header -->
            <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/80 backdrop-blur-lg dark:border-gray-800 dark:bg-gray-900/80">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <!-- Logo -->
                        <a href="/" class="flex items-center gap-3" wire:navigate>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/25">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xl font-bold tracking-tight">FlexiCart</span>
                                <span class="ml-1 rounded bg-indigo-100 px-1.5 py-0.5 text-xs font-medium text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300">Demo</span>
                            </div>
                        </a>

                        <!-- Navigation -->
                        <nav class="hidden items-center gap-1 md:flex">
                            <a href="/" wire:navigate class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                                Products
                            </a>
                            <a href="/cart" wire:navigate class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                                Cart Demo
                            </a>
                            <a href="/features" wire:navigate class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                                Features
                            </a>
                            <a href="/docs" wire:navigate class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                                Docs
                            </a>
                            <a href="https://github.com/daikazu/flexicart" target="_blank" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-600 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100">
                                GitHub
                            </a>
                        </nav>

                        <!-- Right Side -->
                        <div class="flex items-center gap-3">
                            <!-- Dark Mode Toggle -->
                            <button
                                onclick="toggleDarkMode()"
                                class="rounded-lg p-2 text-gray-500 transition-colors hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-100"
                                aria-label="Toggle dark mode"
                            >
                                <svg class="h-5 w-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                <svg class="hidden h-5 w-5 dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>

                            <!-- Cart Button -->
                            <livewire:cart-button />
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-200 bg-white py-8 dark:border-gray-800 dark:bg-gray-900">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">FlexiCart for Laravel</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="https://github.com/daikazu/flexicart" target="_blank" class="text-sm text-gray-500 transition-colors hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300">
                                GitHub
                            </a>
                            <a href="https://packagist.org/packages/daikazu/flexicart" target="_blank" class="text-sm text-gray-500 transition-colors hover:text-gray-900 dark:text-gray-500 dark:hover:text-gray-300">
                                Packagist
                            </a>
                            <span class="text-sm text-gray-400 dark:text-gray-600">Built with Laravel & Livewire</span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Cart Drawer -->
        <livewire:cart-drawer />

        @livewireScripts
    </body>
</html>
