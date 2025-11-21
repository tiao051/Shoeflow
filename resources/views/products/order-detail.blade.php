@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight">ORDER #{{ $order->id }}</h1>
                <p class="text-gray-600 mt-2">{{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-4 py-2 rounded-full font-bold text-sm
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                    @elseif($order->status === 'delivered') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif
                ">
                    {{ strtoupper($order->status) }}
                </span>
            </div>
        </div>

        <!-- Order Timeline -->
        <div class="bg-white rounded p-6 mb-8">
            <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide">DELIVERY STATUS</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white font-black mr-4">✓</div>
                    <div>
                        <p class="font-bold text-gray-900">Order Confirmed</p>
                        <p class="text-sm text-gray-600">{{ $order->confirmed_at ? $order->confirmed_at->format('M d, Y H:i') : 'Pending' }}</p>
                    </div>
                </div>

                <div class="flex items-center {{ $order->status !== 'pending' ? 'opacity-100' : 'opacity-50' }}">
                    <div class="w-12 h-12 rounded-full {{ $order->status !== 'pending' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white font-black mr-4">
                        {{ $order->status !== 'pending' ? '✓' : '◌' }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">Shipped</p>
                        <p class="text-sm text-gray-600">{{ $order->shipped_at ? $order->shipped_at->format('M d, Y H:i') : 'Pending' }}</p>
                    </div>
                </div>

                <div class="flex items-center {{ $order->status === 'delivered' ? 'opacity-100' : 'opacity-50' }}">
                    <div class="w-12 h-12 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} flex items-center justify-center text-white font-black mr-4">
                        {{ $order->status === 'delivered' ? '✓' : '◌' }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">Delivered</p>
                        <p class="text-sm text-gray-600">{{ $order->delivered_at ? $order->delivered_at->format('M d, Y H:i') : 'Pending' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded p-6 mb-8">
            <h2 class="text-lg font-black text-gray-900 mb-6 tracking-wide">ORDER ITEMS</h2>
            <div class="space-y-6">
                @foreach($order->items as $item)
                    <div class="flex gap-6 pb-6 border-b border-gray-200">
                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 mb-1">{{ strtoupper($item->product->name) }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $item->size }} | {{ $item->color }}</p>
                            <p class="text-gray-600">Qty: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-black text-gray-900">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shipping & Payment -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Shipping Address -->
            <div class="bg-white rounded p-6">
                <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide">SHIPPING ADDRESS</h2>
                <div class="space-y-2 text-gray-600">
                    <p class="font-bold">{{ $order->shipping_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                    <p>{{ $order->shipping_phone }}</p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded p-6">
                <h2 class="text-lg font-black text-gray-900 mb-4 tracking-wide">ORDER SUMMARY</h2>
                <div class="space-y-3 text-gray-600 pb-4 border-b border-gray-200">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span>{{ number_format($order->subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Shipping</span>
                        <span>{{ number_format($order->shipping_cost, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax</span>
                        <span>{{ number_format($order->tax, 0, ',', '.') }}₫</span>
                    </div>
                </div>
                <div class="flex justify-between font-black text-gray-900 text-lg mt-4">
                    <span>TOTAL</span>
                    <span>{{ number_format($order->total, 0, ',', '.') }}₫</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex gap-4">
            <a href="{{ route('orders.index') }}" class="flex-1 border-2 border-gray-900 text-gray-900 py-3 rounded-full font-bold text-center hover:bg-gray-50 transition">
                BACK TO ORDERS
            </a>
            <a href="/products" class="flex-1 bg-black text-white py-3 rounded-full font-bold text-center hover:bg-gray-800 transition">
                CONTINUE SHOPPING
            </a>
        </div>
    </div>
</div>
@endsection