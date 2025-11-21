<x-guest-layout>
<!-- Main Message -->
<div class="mb-6 text-base text-gray-700 dark:text-gray-300 font-semibold tracking-wide border-l-4 border-red-600 pl-4 py-1">
{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn&#39;t receive the email, we will gladly send you another.') }}
</div>

<!-- Success Message for Resent Link -->
@if (session('status') == 'verification-link-sent')
    <div class="mb-4 font-bold text-sm text-green-600 dark:text-green-400 p-2 bg-green-50 rounded">
        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
    </div>
@endif

<div class="mt-8 flex flex-col space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
    <!-- Request Resend Form -->
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
            <x-primary-button>
                {{ __('Resend Verification Email') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Logout Form -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="text-sm font-bold tracking-wider text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 transition duration-150 ease-in-out underline">
            {{ __('Log Out') }}
        </button>
    </form>
</div>


</x-guest-layout>