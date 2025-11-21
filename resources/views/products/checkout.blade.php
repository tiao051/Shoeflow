@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-gray-900 mb-12 tracking-tight">CHECKOUT</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Shipping & Payment -->
            <div>
                <form action="{{ route('order.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Shipping Address -->
                    <div class="bg-white p-6 rounded">
                        <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide">SHIPPING ADDRESS</h2>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <input type="text" name="first_name" placeholder="First Name" class="px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900" required>
                            <input type="text" name="last_name" placeholder="Last Name" class="px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900" required>
                        </div>

                        <input type="email" name="email" placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900 mb-4" required>

                        <input type="text" name="phone" placeholder="Phone Number" class="w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900 mb-4" required>

                        <input type="text" name="address" placeholder="Street Address" class="w-full px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900 mb-4" required>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <input type="text" name="city" placeholder="City" class="px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900" required>
                            <input type="text" name="postal_code" placeholder="Postal Code" class="px-4 py-3 border border-gray-300 rounded hover:border-gray-900 focus:outline-none focus:border-gray-900" required>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white p-6 rounded">
                        <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide">PAYMENT METHOD</h2>
                        
                        <label class="flex items-center p-3 border-2 border-gray-300 rounded cursor-pointer hover:border-gray-900 mb-3">
                            <input type="radio" name="payment_method" value="card" checked class="mr-3">
                            <span class="font-semibold text-gray-900">Credit Card</span>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-300 rounded cursor-pointer hover:border-gray-900 mb-3">
                            <input type="radio" name="payment_method" value="bank" class="mr-3">
                            <span class="font-semibold text-gray-900">Bank Transfer</span>
                        </label>

                        <label class="flex items-center p-3 border-2 border-gray-300 rounded cursor-pointer hover:border-gray-900">
                            <input type="radio" name="payment_method" value="cod" class="mr-3">
                            <span class="font-semibold text-gray-900">Cash on Delivery</span>
                        </label>
                    </div>

                    <!-- Terms -->
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-3" required>
                        <span class="text-sm text-gray-600">I agree to the Terms of Service and Privacy Policy</span>
                    </label>

                    <button type="submit" class="w-full bg-black text-white py-4 rounded-full font-bold text-lg hover:bg-gray-800 transition tracking-wide">
                        PLACE ORDER
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded h-fit">
                <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide">ORDER SUMMARY</h2>
                
                <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                    @foreach($cartItems as $item)
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ strtoupper($item->product->name) }} x{{ $item->quantity }}</span>
                            <span class="font-semibold">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</span>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-2 mb-6 pb-6 border-b border-gray-200 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>{{ number_format($shipping, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>{{ number_format($tax, 0, ',', '.') }}₫</span>
                    </div>
                </div>

                <div class="flex justify-between font-black text-gray-900 text-lg">
                    <span>TOTAL</span>
                    <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection