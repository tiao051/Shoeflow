@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Category Hero -->
        <div class="mb-12">
            <h1 class="text-5xl font-black text-gray-900 mb-4 tracking-tight">{{ strtoupper($category->name) }}</h1>
            <p class="text-lg text-gray-600 mb-8">{{ $category->description }}</p>
            
            <!-- Filter Section -->
            <div class="flex flex-col md:flex-row gap-6 mb-8">
                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-900 mb-2">FILTER BY PRICE</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">Under 1,000,000₫</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">1,000,000₫ - 2,000,000₫</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">2,000,000₫ - 3,000,000₫</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">Over 3,000,000₫</span>
                        </label>
                    </div>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-900 mb-2">SIZE</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach([36, 37, 38, 39, 40, 41, 42, 43] as $size)
                            <label class="flex items-center justify-center p-2 border border-gray-300 rounded cursor-pointer hover:border-gray-900">
                                <input type="checkbox" class="mr-0">
                                <span class="text-sm font-semibold">{{ $size }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-bold text-gray-900 mb-2">COLOR</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">Black</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">White</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">Navy</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-gray-600">Red</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('product.detail', $product->id) }}" class="group">
                    <div class="aspect-square bg-gray-100 rounded overflow-hidden mb-4 relative">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @if($product->discount)
                            <div class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-black">
                                -{{ $product->discount }}%
                            </div>
                        @endif
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1 group-hover:text-gray-600 transition line-clamp-2">{{ strtoupper($product->name) }}</h3>
                    <p class="text-xs text-gray-600 mb-2">{{ $product->color ?? 'Black' }}</p>
                    <div class="flex items-baseline gap-2">
                        <p class="font-black text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                        @if($product->original_price)
                            <p class="text-xs text-gray-500 line-through">{{ number_format($product->original_price, 0, ',', '.') }}₫</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection