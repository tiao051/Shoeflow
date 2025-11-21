<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} - Home</title>

    <!-- Tailwind CSS & Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles - MUST run 'npm install && npm run dev' -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900 dark:bg-gray-900 text-white min-h-screen flex items-center justify-center">

    <!-- Main Content Card -->
    <div class="max-w-4xl mx-auto p-8 sm:p-10 bg-white dark:bg-gray-800 shadow-2xl rounded-lg border-b-8 border-red-600">
        <header class="flex justify-between items-center mb-10">
            <div class="text-3xl font-extrabold text-red-600 uppercase tracking-widest">
                {{ config('app.name', 'E-COMMERCE') }}
            </div>
            
            <!-- Authentication Links -->
            @if (Route::has('login'))
                <nav class="-mx-3 flex flex-1 justify-end">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-sm font-bold text-gray-700 dark:text-white transition hover:text-red-600 dark:hover:text-red-500"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-sm font-bold text-gray-700 dark:text-white transition hover:text-red-600 dark:hover:text-red-500"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="ml-4 rounded-md px-3 py-2 text-sm font-bold text-white bg-red-600 border border-red-600 transition hover:bg-red-700"
                            >
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <!-- Hero Section -->
        <div class="text-center">
            <h1 class="text-6xl font-black text-gray-900 dark:text-white mb-4 uppercase tracking-tighter">
                Ready to Ship. Ready to Wear.
            </h1>
            <p class="text-xl text-gray-700 dark:text-gray-300 max-w-2xl mx-auto mb-8 font-medium">
                Explore our latest collection of premium products. Simple design, bold statement.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 border-2 border-red-600 rounded-sm font-extrabold text-sm text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150 shadow-lg">
                    Shop Now
                </a>
            </div>
        </div>

        <!-- Footer / Status Message (Optional) -->
        <footer class="mt-12 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </p>
        </footer>
    </div>

</body>


</html>