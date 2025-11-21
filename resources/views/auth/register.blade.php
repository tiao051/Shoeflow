<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Themed Store</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-red: #B91C1C;
            --secondary-dark: #1F2937;
            --fallback-bg: #400000;
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
            background-color: var(--primary-red);
            border: 2px solid var(--primary-red);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.2s ease-in-out;
        }

        .themed-btn:hover {
            background-color: #991B1B;
            box-shadow: 0 4px 15px rgba(185, 28, 28, 0.4);
        }

        .themed-focus:focus {
            --tw-ring-color: var(--primary-red);
            border-color: var(--primary-red);
        }

        .text-themed {
            color: var(--primary-red);
        }

        .image-column {
            background-image: url('{{ asset('images/background1.jpg') }}');
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

        .form-container {
            width: 100%;
            max-width: 24rem;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden min-h-[500px]">
        <div class="w-full md:w-1/2 image-column flex-shrink-0 h-48 md:h-auto">
            <div class="w-full h-full bg-black bg-opacity-10"></div>
        </div>
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 form-content">
            <div class="form-container space-y-5">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-auto text-themed" viewBox="0 0 200 200" fill="currentColor">
                        <path d="M100,20 L150,180 L20,80 L180,80 L50,180 Z" transform="scale(0.8) translate(20, 0)" />
                    </svg>
                    <h2 class="mt-4 text-3xl font-black text-center text-secondary-dark uppercase tracking-wider">
                        CREATE ACCOUNT
                    </h2>
                    <p class="mt-1 text-sm text-gray-700 font-medium">
                        Sign up to join our community!
                    </p>
                </div>
                <form class="space-y-4" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-bold text-secondary-dark uppercase tracking-wider">Full Name</label>
                        <input id="name" type="text" name="name" required autofocus autocomplete="name"
                            class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-inner placeholder-gray-400 focus:outline-none focus:ring-1 themed-focus text-sm">
                        @error('name')
                            <span class="text-themed text-xs mt-1 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-bold text-secondary-dark uppercase tracking-wider">Email Address</label>
                        <input id="email" type="email" name="email" required autocomplete="username"
                            class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-inner placeholder-gray-400 focus:outline-none focus:ring-1 themed-focus text-sm">
                        @error('email')
                            <span class="text-themed text-xs mt-1 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-xs font-bold text-secondary-dark uppercase tracking-wider">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                            class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-inner placeholder-gray-400 focus:outline-none focus:ring-1 themed-focus text-sm">
                        @error('password')
                            <span class="text-themed text-xs mt-1 block font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-secondary-dark uppercase tracking-wider">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                            class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-lg shadow-inner placeholder-gray-400 focus:outline-none focus:ring-1 themed-focus text-sm">
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="themed-btn w-full flex justify-center py-2 px-4 rounded-lg text-sm font-extrabold text-white shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">
                            REGISTER
                        </button>
                    </div>
                </form>
                <div class="mt-4 text-center pt-3 border-t border-gray-100">
                    <p class="text-sm text-gray-700">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-black text-themed hover:text-red-700 transition duration-150 ease-in-out">
                            Sign In Here
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>