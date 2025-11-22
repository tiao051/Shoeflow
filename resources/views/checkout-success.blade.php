@extends('layouts.app')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        
        <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-green-100 mb-6">
            <svg class="h-12 w-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <div>
            <h2 class="mt-6 text-3xl font-black text-gray-900 tracking-tight uppercase">
                Thank You!
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Your order has been placed successfully.
            </p>
        </div>

        <div class="bg-gray-50 py-6 px-4 rounded-lg border border-gray-200 mt-8">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-500">Order Number:</span>
                <span class="text-sm font-bold text-gray-900">#{{ $order->id }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-500">Date:</span>
                <span class="text-sm font-bold text-gray-900">{{ $order->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-500">Total Amount:</span>
                <span class="text-lg font-black text-gray-900">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Payment Method:</span>
                <span class="text-sm font-bold text-gray-900 uppercase">{{ $order->payment_method }}</span>
            </div>
        </div>

        <p class="text-xs text-gray-500 mt-4">
            We have sent an order confirmation email to <span class="font-bold text-gray-700">{{ $order->email }}</span>.
        </p>

        <div class="mt-8 space-y-3">
            <a href="{{ route('profile.show') }}" 
               class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition transform hover:-translate-y-0.5">
                VIEW ORDER DETAILS
            </a>

            <a href="{{ route('products.index') }}" 
               class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                CONTINUE SHOPPING
            </a>
        </div>
    </div>
</div>
@endsection