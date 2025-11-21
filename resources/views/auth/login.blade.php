<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Commerce</title>
    <!-- Tải Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Custom colors based on the beach/sunset theme of background2.jpg */
        :root {
            --primary-brown: #5D4037;
            --secondary-khaki: #B8860B;
            --text-dark: #1F2937;
            --fallback-bg: #3E2723;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--fallback-bg);
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .themed-btn {
            background-color: var(--primary-brown);
            border: 2px solid var(--primary-brown);
            transition: all 0.2s ease-in-out;
        }

        .themed-btn:hover {
            background-color: #4E342E;
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.4);
        }

        .themed-focus:focus {
            --tw-ring-color: var(--secondary-khaki);
            border-color: var(--secondary-khaki);
        }

        .text-themed {
            color: var(--primary-brown);
        }

        .border-themed {
            border-color: var(--primary-brown);
        }

        .text-shadow-sm {
            text-shadow: 0.5px 0.5px 1px rgba(0, 0, 0, 0.1);
        }

        .image-column {
            background-image: url('{{ asset('images/background2.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-content {
            padding: 1.5rem;
        }

        @media (min-width: 640px) {
            .form-content {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden min-h-[500px]">
        <div class="w-full md:w-1/2 image-column flex-shrink-0 h-48 md:h-auto"></div>
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 form-content">
            <div class="w-full max-w-sm space-y-6">
                <div class="text-center">
                    <svg class="mx-auto h-9 w-auto text-themed" viewBox="0 0 200 200" fill="currentColor">
                        <polygon points="100,20 120,80 180,80 130,120 150,180 100,140 50,180 70,120 20,80 80,80" />
                    </svg>
                    <h2 class="mt-3 text-2xl font-black text-center text-text-dark uppercase tracking-tight text-shadow-sm">
                        Access Your Cart
                    </h2>
                    <p class="mt-1 text-xs text-gray-700 font-medium">
                        Log in to unlock your shopping experience.
                    </p>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Email Address</label>
                        <input id="email" type="email" name="email" required autofocus autocomplete="username"
                            class="mt-1 block w-full px-3 py-1.5 border-2 border-gray-400 rounded-lg shadow-inner placeholder-gray-400 focus:outline-none focus:ring-1 themed-focus text-sm">
                        @error('email')
                            <span class="text-secondary-khaki text-xs mt-1 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="mt-1 block w-full px-3 py-1.5 border-2 border-gray-400 rounded-lg shadow-inner placeholder-gray-400 focus:outline-none focus:ring-1 themed-focus text-sm">
                        @error('password')
                            <span class="text-secondary-khaki text-xs mt-1 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-3 w-3 text-themed focus:ring-themed border-gray-300 rounded-sm">
                            <label for="remember_me" class="ml-2 block text-xs font-medium text-gray-900">Remember me</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-gray-700 hover:text-themed transition duration-150 ease-in-out" href="{{ route('password.request') }}">
                                Forgot your password?
                            </a>
                        @endif
                    </div>
                    <div>
                        <button type="submit"
                            class="themed-btn w-full flex justify-center py-2 px-4 rounded-lg shadow-lg text-sm font-extrabold text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-themed transition duration-150 ease-in-out">
                            Log In
                        </button>
                    </div>
                </form>
                @if (Route::has('register'))
                    <div class="mt-4 text-center pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-700">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-black text-themed hover:text-secondary-khaki transition duration-150 ease-in-out">
                                Sign up here
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>