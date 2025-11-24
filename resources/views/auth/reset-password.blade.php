<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --primary-brown: #5D4037; --secondary-khaki: #B8860B; --text-dark: #1F2937; --fallback-bg: #3E2723; }
        body { font-family: 'Inter', sans-serif; background-color: var(--fallback-bg); display: flex; min-height: 100vh; align-items: center; justify-content: center; }
        .themed-btn { background-color: var(--primary-brown); border: 2px solid var(--primary-brown); transition: all 0.2s; }
        .themed-btn:hover { background-color: #4E342E; box-shadow: 0 4px 12px rgba(93, 64, 55, 0.4); }
        .themed-focus:focus { --tw-ring-color: var(--secondary-khaki); border-color: var(--secondary-khaki); }
        .form-content { padding: 2rem; background: white; border-radius: 1rem; width: 100%; max-width: 400px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
    </style>
</head>
<body>
    <div class="form-content">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-black text-text-dark uppercase tracking-tight">Set New Password</h2>
            <p class="mt-2 text-xs text-gray-600">Please enter your new password below.</p>
        </div>

        <form method="POST" action="{{ route('password.reset.update') }}" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-xs font-bold text-gray-700 uppercase">New Password</label>
                <input id="password" type="password" name="password" required class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-1 themed-focus text-sm">
                @error('password') <span class="text-red-600 text-xs mt-1 block font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full px-3 py-2 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-1 themed-focus text-sm">
            </div>
            
            <button type="submit" class="themed-btn w-full py-2 rounded-lg text-sm font-extrabold text-white uppercase tracking-widest">Update Password</button>
        </form>
    </div>
</body>
</html>