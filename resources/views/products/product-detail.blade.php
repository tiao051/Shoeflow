@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <!-- Product Images -->
            <div>
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
                    <img id="mainImage" src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images ?? [$product->image] as $image)
                        <img src="{{ $image }}" alt="Product" class="aspect-square bg-gray-100 rounded cursor-pointer hover:opacity-75 transition" onclick="document.getElementById('mainImage').src = this.src">
                    @endforeach
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-4">
                    <h1 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">{{ strtoupper($product->name) }}</h1>
                    <p class="text-gray-600 text-lg">{{ $product->description }}</p>
                </div>

                <!-- Rating -->
                <div class="flex items-center mb-6">
                    <div class="flex items-center">
                        @for($i = 0; $i < 5; $i++)
                            <span class="text-yellow-400">★</span>
                        @endfor
                    </div>
                    <span class="ml-2 text-sm text-gray-600">({{ $product->reviews_count ?? 0 }} Reviews)</span>
                </div>

                <!-- Price -->
                <div class="mb-6 pb-6 border-b border-gray-200">
                    <p class="text-3xl font-black text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                    @if($product->original_price)
                        <p class="text-sm text-gray-500 line-through">{{ number_format($product->original_price, 0, ',', '.') }}₫</p>
                    @endif
                </div>

                <!-- Size Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-900 mb-3 tracking-wide">SELECT SIZE</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->sizes ?? [36, 37, 38, 39, 40, 41, 42, 43] as $size)
                            <button class="py-3 border border-gray-300 rounded hover:border-gray-900 hover:bg-gray-50 transition font-semibold text-sm" onclick="this.classList.toggle('bg-gray-900'); this.classList.toggle('text-white')">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Color Selection -->
                <div class="mb-8">
                    <label class="block text-sm font-bold text-gray-900 mb-3 tracking-wide">SELECT COLOR</label>
                    <div class="flex gap-3">
                        @foreach($product->colors ?? ['Black', 'White', 'Navy'] as $color)
                            <div class="flex flex-col items-center">
                                <button class="w-12 h-12 rounded-full border-2 border-gray-300 hover:border-gray-900 transition" 
                                    style="background-color: {{ strtolower($color) === 'black' ? '#000' : (strtolower($color) === 'white' ? '#f5f5f5' : '#001f3f') }}"
                                    title="{{ $color }}">
                                </button>
                                <span class="text-xs font-semibold mt-2 text-gray-600">{{ $color }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Add to Cart -->
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-3 mb-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="w-full bg-black text-white py-4 rounded-full font-bold text-lg hover:bg-gray-800 transition tracking-wide">
                        ADD TO CART
                    </button>
                </form>

                <!-- Wishlist -->
                <button class="w-full border-2 border-gray-900 text-gray-900 py-4 rounded-full font-bold text-lg hover:bg-gray-50 transition tracking-wide flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 22l7.682-7.318a4.5 4.5 0 00-6.364-6.364L12 7.682l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    ADD TO WISHLIST
                </button>

                <!-- Product Details -->
                <div class="mt-12 space-y-6">
                    <div class="border-t pt-6">
                        <h3 class="font-bold text-gray-900 mb-2">PRODUCT DETAILS</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $product->details ?? 'Classic Converse design with iconic rubber toe cap and ankle patch.' }}</p>
                    </div>
                    <div class="border-t pt-6">
                        <h3 class="font-bold text-gray-900 mb-2">SHIPPING & RETURNS</h3>
                        <p class="text-gray-600 text-sm">Free shipping on orders over 2 million VND. Returns within 30 days.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection