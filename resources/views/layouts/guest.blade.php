<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles - MUST run 'npm install && npm run dev' for this to work -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<!-- Background is a dark canvas color -->
<body class="font-sans text-gray-900 antialiased bg-gray-900 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo Section -->
        <div class="mb-4">
            <a href="/">
                <x-application-logo class="w-16 h-16 fill-current text-white" />
            </a>
        </div>

        <!-- Content Card -->
        <div class="w-full sm:max-w-md mt-6 px-8 py-6 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-lg border-b-8 border-red-600">
            {{ $slot }}
        </div>
    </div>
</body>


</html>