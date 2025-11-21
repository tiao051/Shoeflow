<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | E-Commerce</title>
<!-- Tải Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://www.google.com/search?q=https://fonts.googleapis.com/css2%3Ffamily%3DInter:wght%40400%3B600%3B700%3B900%26display%3Dswap" rel="stylesheet">
<style>
body {
font-family: 'Inter', sans-serif;
background-color: #1f2937; /* Dark background matching the guest layout */
}
</style>
</head>
<body class="flex items-center justify-center min-h-screen">

<div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-2xl border-b-8 border-red-600">
    <!-- Logo and Title -->
    <div class="text-center">
        <!-- Simplified Logo Placeholder -->
        <svg class="mx-auto h-10 w-auto text-red-600" viewBox="0 0 200 200" fill="currentColor">
            <polygon points="100,20 120,80 180,80 130,120 150,180 100,140 50,180 70,120 20,80 80,80"/>
        </svg>
        <h2 class="mt-4 text-3xl font-black text-center text-gray-900 uppercase tracking-tight">
            Login to View Cart
        </h2>
        <p class="mt-2 text-sm text-gray-600 font-medium">
            You need an account to access the Cart.
        </p>
    </div>

    <!-- Session Status (omitted for clean state) -->

    <!-- Login Form -->
    <form class="space-y-6" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Email Address</label>
            <input id="email" type="email" name="email" required autofocus autocomplete="username"
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-900 rounded-sm shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-600 focus:border-red-600 text-sm">
            @error('email')
                <span class="text-red-600 text-xs mt-1 block font-semibold">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full px-4 py-2 border-2 border-gray-900 rounded-sm shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-600 focus:border-red-600 text-sm">
            @error('password')
                <span class="text-red-600 text-xs mt-1 block font-semibold">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me and Forgot Password -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm font-medium text-gray-900">Remember me</label>
            </div>
            
            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-gray-700 hover:text-red-600 transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border-2 border-black rounded-sm shadow-sm text-sm font-extrabold text-white bg-black hover:bg-gray-800 uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition duration-150 ease-in-out">
                Log In
            </button>
        </div>
    </form>

    <!-- Register Link -->
    @if (Route::has('register'))
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-black text-red-600 hover:text-red-700 transition duration-150 ease-in-out">
                    Sign up here
                </a>
            </p>
        </div>
    @endif
</div>


</body>
</html>