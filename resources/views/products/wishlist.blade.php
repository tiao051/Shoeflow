@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-gray-900 mb-8 tracking-tight">MY WISHLIST</h1>

        @if($wishlistItems->isEmpty())
            <div class="text-center py-12 bg-white rounded">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">YOUR WISHLIST IS EMPTY</h2>
                <p class="text-gray-600 mb-8">Add items to your wishlist to save them for later.</p>
                <a href="/products" class="inline-block bg-black text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition">
                    EXPLORE PRODUCTS
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($wishlistItems as $item)
                    <div class="bg-white rounded overflow-hidden group">
                        <div class="aspect-square bg-gray-100 overflow-hidden mb-4 relative">
                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            <button class="absolute top-2 right-2 bg-white p-2 rounded-full shadow hover:shadow-lg transition">
                                <svg class="w-5 h-5 text-red-600 fill-current" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 text-sm mb-1">{{ strtoupper($item->product->name) }}</h3>
                            <p class="text-xs text-gray-600 mb-3">{{ $item->product->color ?? 'Black' }}</p>
                            <p class="font-black text-gray-900 mb-3">{{ number_format($item->product->price, 0, ',', '.') }}₫</p>
                            <a href="{{ route('product.detail', $item->product->id) }}" class="block w-full bg-black text-white py-2 rounded text-center text-sm font-bold hover:bg-gray-800 transition">
                                VIEW
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection