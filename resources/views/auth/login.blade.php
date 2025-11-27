<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | E-Commerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Alpine.js for Modal Logic --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root { --primary-brown: #5D4037; --secondary-khaki: #B8860B; --text-dark: #1F2937; --fallback-bg: #3E2723; }
        body { font-family: 'Inter', sans-serif; background-color: var(--fallback-bg); display: flex; min-height: 100vh; align-items: center; justify-content: center; }
        .themed-btn { background-color: var(--primary-brown); border: 2px solid var(--primary-brown); transition: all 0.2s ease-in-out; }
        .themed-btn:hover { background-color: #4E342E; box-shadow: 0 4px 12px rgba(93, 64, 55, 0.4); }
        .themed-focus:focus { --tw-ring-color: var(--secondary-khaki); border-color: var(--secondary-khaki); }
        .text-themed { color: var(--primary-brown); }
        .text-highlight { color: var(--secondary-khaki); }
        .image-column { background-image: url('{{ asset('images/background2.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; }
        .form-content { padding: 1.5rem; }
        @media (min-width: 640px) { .form-content { padding: 2rem; } }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body>
    <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden min-h-[500px]"
         x-data="{ showForgotModal: false }">
        
        <div class="w-full md:w-1/2 image-column flex-shrink-0 h-48 md:h-auto"></div>
        
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 form-content">
            <div class="w-full max-w-sm space-y-6">
                {{-- Header --}}
                <div class="text-center">
                    <svg class="mx-auto h-9 w-auto text-themed" viewBox="0 0 200 200" fill="currentColor">
                        <polygon points="100,20 120,80 180,80 130,120 150,180 100,140 50,180 70,120 20,80 80,80" />
                    </svg>
                    <h2 class="mt-3 text-2xl font-black text-center text-text-dark uppercase tracking-tight">Access Your Cart</h2>
                </div>
                 
                <form class="space-y-4" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="mt-1 block w-full px-3 py-1.5 border-2 border-gray-400 rounded-lg shadow-inner focus:outline-none focus:ring-1 themed-focus text-sm @error('email') border-red-500 @enderror">
                        @error('email')
                            <div class="mt-1">
                                <span class="text-red-600 text-xs block font-semibold">{{ $message }}</span>
                                {{-- Trigger Modal Link --}}
                                <a @click.prevent="showForgotModal = true" href="#" class="text-xs font-bold text-highlight hover:text-themed underline mt-1 block transition-colors">
                                    Incorrect credentials? Reset password here.
                                </a>
                            </div>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="mt-1 block w-full px-3 py-1.5 border-2 border-gray-400 rounded-lg shadow-inner focus:outline-none focus:ring-1 themed-focus text-sm @error('password') border-red-500 @enderror">
                        @error('password')
                            <div class="mt-1">
                                <span class="text-red-600 text-xs block font-semibold">{{ $message }}</span>
                                {{-- Trigger Modal Link --}}
                                <a @click.prevent="showForgotModal = true" href="#" class="text-xs font-bold text-highlight hover:text-themed underline mt-1 block transition-colors">
                                    Forgot your password? Click to reset.
                                </a>
                            </div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-3 w-3 text-themed focus:ring-themed border-gray-300 rounded-sm">
                            <label for="remember_me" class="ml-2 block text-xs font-medium text-gray-900">Remember me</label>
                        </div>
                        {{-- Trigger Modal Link --}}
                        <a @click.prevent="showForgotModal = true" href="#" class="text-xs font-bold text-gray-700 hover:text-themed transition duration-150 ease-in-out">
                            Forgot your password?
                        </a>
                    </div>

                    <button type="submit" class="themed-btn w-full flex justify-center py-2 px-4 rounded-lg shadow-lg text-sm font-extrabold text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-themed transition">
                        Log In
                    </button>
                </form>

                <div class="relative flex items-center py-2">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-xs font-medium text-gray-500 uppercase">Or continue with</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <div class="mt-4">
                    <a href="{{ url('/auth/google') }}" class="flex items-center justify-center w-full px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                        <span class="text-sm font-bold text-gray-700">Sign in with Google</span>
                    </a>
                </div>

                @if (Route::has('register'))
                    <div class="mt-4 text-center pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-700">Don't have an account? <a href="{{ route('register') }}" class="font-black text-themed hover:text-secondary-khaki transition">Sign up here</a></p>
                    </div>
                @endif
                <div class="mt-6 text-center">
                    <a href="{{ url('admin/login') }}" class="inline-flex items-center text-xs font-semibold text-gray-400 hover:text-themed transition-colors duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1 group-hover:text-secondary-khaki" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Admin Portal
                    </a>
                </div>
            </div>

            {{-- FORGOT PASSWORD MODAL START --}}
            <div x-show="showForgotModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div x-show="showForgotModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showForgotModal = false"></div>

                <div x-show="showForgotModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0 pointer-events-none">
                    
                    <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full pointer-events-auto"
                         x-data="forgotPasswordHandler()">
                        
                        {{-- Modal Header --}}
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-xl font-black text-center text-text-dark uppercase" x-text="getTitle()"></h3>
                            <p class="mt-2 text-sm text-center text-gray-500" x-text="getDescription()"></p>
                            
                            {{-- Error Display --}}
                            <div x-show="errorMessage" class="mt-4 p-2 bg-red-50 text-red-600 text-xs font-bold rounded text-center" x-text="errorMessage"></div>
                            {{-- Success Display --}}
                            <div x-show="successMessage" class="mt-4 p-2 bg-green-50 text-green-600 text-xs font-bold rounded text-center" x-text="successMessage"></div>
                        </div>

                        {{-- Modal Body (Forms) --}}
                        <div class="bg-white px-4 pb-4 sm:p-6">
                            
                            {{-- STEP 1: Email Input --}}
                            <div x-show="step === 1">
                                <form @submit.prevent="sendCode">
                                    <input type="email" x-model="email" placeholder="Enter your email" required class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 themed-focus">
                                    <button type="submit" :disabled="isLoading" class="mt-4 w-full themed-btn text-white font-bold py-2 rounded-lg uppercase tracking-wider flex justify-center items-center">
                                        <span x-show="!isLoading">Send Code</span>
                                        <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </button>
                                </form>
                            </div>

                            {{-- STEP 2: Verify Code --}}
                            <div x-show="step === 2">
                                <form @submit.prevent="verifyCode">
                                    <input type="text" x-model="code" maxlength="6" placeholder="000000" required class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 themed-focus text-center text-xl font-bold tracking-widest">
                                    <div class="text-xs text-right mt-2 text-gray-500 hover:text-themed cursor-pointer" @click="step = 1">Change email?</div>
                                    <button type="submit" :disabled="isLoading" class="mt-4 w-full themed-btn text-white font-bold py-2 rounded-lg uppercase tracking-wider flex justify-center items-center">
                                        <span x-show="!isLoading">Verify Code</span>
                                        <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </button>
                                </form>
                            </div>

                            {{-- STEP 3: Reset Password --}}
                            <div x-show="step === 3">
                                <form @submit.prevent="resetPassword">
                                    <div class="space-y-3">
                                        <input type="password" x-model="password" placeholder="New Password" required class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 themed-focus">
                                        <input type="password" x-model="password_confirmation" placeholder="Confirm Password" required class="w-full px-3 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-1 themed-focus">
                                    </div>
                                    <button type="submit" :disabled="isLoading" class="mt-4 w-full themed-btn text-white font-bold py-2 rounded-lg uppercase tracking-wider flex justify-center items-center">
                                        <span x-show="!isLoading">Reset Password</span>
                                        <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" @click="showForgotModal = false" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm uppercase">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- FORGOT PASSWORD MODAL END --}}
            
        </div>
    </div>

    {{-- Script for Modal Logic --}}
    <script>
        function forgotPasswordHandler() {
            return {
                step: 1,
                email: '',
                code: '',
                password: '',
                password_confirmation: '',
                isLoading: false,
                errorMessage: '',
                successMessage: '',

                getTitle() {
                    if (this.step === 1) return 'Forgot Password?';
                    if (this.step === 2) return 'Verify Code';
                    if (this.step === 3) return 'Reset Password';
                },
                getDescription() {
                    if (this.step === 1) return 'Enter your email to receive a 6-digit code.';
                    if (this.step === 2) return 'We sent a code to ' + this.email;
                    if (this.step === 3) return 'Enter your new password below.';
                },
                resetErrors() {
                    this.errorMessage = '';
                    this.successMessage = '';
                },
                async apiCall(url, body) {
                    this.isLoading = true;
                    this.resetErrors();
                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(body)
                        });
                        const data = await response.json();
                        if (!response.ok) throw data;
                        return data;
                    } catch (error) {
                        // Extract specific error message
                        if (error.errors) {
                            this.errorMessage = Object.values(error.errors)[0][0];
                        } else {
                            this.errorMessage = error.message || 'Something went wrong.';
                        }
                        throw error;
                    } finally {
                        this.isLoading = false;
                    }
                },
                async sendCode() {
                    try {
                        await this.apiCall("{{ route('password.email') }}", { email: this.email });
                        this.step = 2; 
                        this.successMessage = 'Code sent! Check your email.';
                    } catch (e) {}
                },
                async verifyCode() {
                    try {
                        await this.apiCall("{{ route('password.code.check') }}", { email: this.email, code: this.code });
                        this.step = 3;
                        this.successMessage = 'Code verified! Set new password.';
                    } catch (e) {}
                },
                async resetPassword() {
                    if (this.password !== this.password_confirmation) {
                        this.errorMessage = 'Passwords do not match.';
                        return;
                    }
                    try {
                        await this.apiCall("{{ route('password.reset.update') }}", { 
                            email: this.email, 
                            password: this.password, 
                            password_confirmation: this.password_confirmation 
                        });
                        window.location.reload(); 
                    } catch (e) {}
                }
            }
        }
    </script>
</body>
</html>