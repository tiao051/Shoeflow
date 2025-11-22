@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <div>
            <h2 class="text-2xl font-black text-gray-900 mb-6 tracking-tight">SHIPPING ADDRESS</h2>
            
            <form action="#" method="POST" id="checkout-form">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Full Name</label>
                        <input type="text" name="fullname" value="{{ auth()->user()->name ?? '' }}" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black" placeholder="Enter your full name">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black" placeholder="090xxxxxxx">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black" placeholder="email@example.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Address</label>
                        <input type="text" name="address" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black" placeholder="Street address, apartment, etc.">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">City / Province</label>
                            <select name="city" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black bg-white">
                                <option value="">Select City</option>
                                <option value="Hanoi">Hanoi</option>
                                <option value="HCM">Ho Chi Minh City</option>
                                <option value="Danang">Da Nang</option>
                                </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Payment Method</label>
                            <select name="payment_method" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black bg-white">
                                <option value="cod">COD (Cash on Delivery)</option>
                                <option value="banking">Bank Transfer</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Order Notes (Optional)</label>
                        <textarea name="note" rows="3" class="w-full border border-gray-300 p-3 rounded focus:outline-none focus:border-black" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-gray-50 p-8 rounded border border-gray-200 h-fit">
            <h2 class="text-xl font-black text-gray-900 mb-6 tracking-tight">YOUR ORDER</h2>

            <div class="space-y-4 mb-6 max-h-96 overflow-y-auto pr-2">
                @foreach($cartItems as $item)
                    <div class="flex gap-4 items-center">
                        <div class="relative">
                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded border border-gray-200">
                            <span class="absolute -top-2 -right-2 bg-black text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                {{ $item->quantity }}
                            </span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-sm text-gray-900">{{ strtoupper($item->product->name) }}</h4>
                            <p class="text-xs text-gray-500">Size: {{ $item->size }}</p>
                        </div>
                        <p class="font-bold text-sm">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</p>
                    </div>
                @endforeach
            </div>

            <hr class="border-gray-200 my-4">

            <div class="space-y-3 text-sm">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal</span>
                    <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Shipping</span>
                    <span>
                        @if($shipping == 0)
                            <span class="text-green-600 font-bold">FREE</span>
                        @else
                            {{ number_format($shipping, 0, ',', '.') }}₫
                        @endif
                    </span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Tax (10%)</span>
                    <span>{{ number_format($tax, 0, ',', '.') }}₫</span>
                </div>
            </div>

            <hr class="border-gray-200 my-4">

            <div class="flex justify-between font-black text-xl text-gray-900 mb-6">
                <span>TOTAL</span>
                <span>{{ number_format($total, 0, ',', '.') }}₫</span>
            </div>

            <button type="submit" form="checkout-form" class="block w-full bg-black text-white py-4 rounded font-bold text-center hover:bg-gray-800 transition shadow-lg">
                PLACE ORDER
            </button>
            
            <a href="{{ route('cart.index') }}" class="block text-center text-sm text-gray-500 mt-4 hover:text-black underline">
                Return to Cart
            </a>
        </div>
    </div>
</div>
@endsection