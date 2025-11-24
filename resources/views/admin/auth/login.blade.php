<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="bg-black p-6 text-center">
            <h1 class="text-2xl font-bold text-white uppercase">SHOES DEL REY</h1>
            <p class="text-gray-400 text-xs mt-1 uppercase">Admin Portal</p>
        </div>
        <div class="p-8">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required autofocus class="w-full px-4 py-3 rounded border border-gray-300 focus:border-black focus:ring-1 focus:ring-black outline-none">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded border border-gray-300 focus:border-black focus:ring-1 focus:ring-black outline-none">
                </div>
                <button type="submit" class="w-full bg-black text-white font-bold py-3 rounded hover:bg-gray-800 transition uppercase">Login</button>
            </form>
        </div>
    </div>
</body>
</html>