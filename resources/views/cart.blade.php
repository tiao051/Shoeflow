@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if($cartItems->isEmpty())
        <div class="text-center py-12">
            <h2 class="text-2xl font-black text-gray-900 mb-4">YOUR CART IS EMPTY</h2>
            <p class="text-gray-600 mb-8">Continue shopping to find your perfect pair of Converse.</p>
            <a href="/products" class="inline-block bg-black text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition">
                START SHOPPING
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <h1 class="text-3xl font-black text-gray-900 mb-8 tracking-tight">SHOPPING BAG</h1>
                
                <div class="space-y-6">
                    @foreach($cartItems as $item)
                        <div class="flex gap-6 pb-6 border-b border-gray-200">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 mb-1">{{ strtoupper($item->product->name) }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $item->size }}</p>
                                
                                <!-- Quantity -->
                                <div class="flex items-center gap-3 mb-4">
                                    <button class="border border-gray-300 w-8 h-8 flex items-center justify-center hover:bg-gray-100">−</button>
                                    <input type="number" value="{{ $item->quantity }}" min="1" class="w-12 text-center border border-gray-300 py-1">
                                    <button class="border border-gray-300 w-8 h-8 flex items-center justify-center hover:bg-gray-100">+</button>
                                </div>
                                
                                <p class="font-bold text-gray-900">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</p>
                            </div>
                            
                            <button class="text-gray-400 hover:text-gray-900 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white border border-gray-200 rounded p-6 h-fit">
                <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide">ORDER SUMMARY</h2>
                
                <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>{{ number_format($shipping, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax</span>
                        <span>{{ number_format($tax, 0, ',', '.') }}₫</span>
                    </div>
                </div>
                
                <div class="flex justify-between font-black text-gray-900 text-lg mb-6">
                    <span>TOTAL</span>
                    <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
                
                <a href="#" class="block w-full bg-black text-white py-3 rounded-full font-bold text-center hover:bg-gray-800 transition mb-3">
                    CHECKOUT
                </a>
                <a href="/products" class="block w-full border-2 border-gray-900 text-gray-900 py-3 rounded-full font-bold text-center hover:bg-gray-50 transition">
                    CONTINUE SHOPPING
                </a>
            </div>
        </div>
    @endif
</div>
@endsection