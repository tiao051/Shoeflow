@extends('layouts.app')

@section('content')
<div class="bg-red-50">
    <!-- Sale Banner -->
    <div class="bg-red-600 text-white py-8 text-center">
        <h1 class="text-5xl font-black mb-2 tracking-tight">SALE UP TO 50%</h1>
        <p class="text-lg">Limited time offers on selected items</p>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Filter & Sort -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
            <p class="text-gray-600">Showing {{ $products->count() }} products on sale</p>
            <select class="px-4 py-2 border border-gray-300 rounded hover:border-gray-900 transition font-semibold text-sm">
                <option>Sort: Biggest Discount</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Newest</option>
            </select>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('product.detail', $product->id) }}" class="group">
                    <div class="aspect-square bg-white rounded overflow-hidden mb-4 relative shadow-sm hover:shadow-lg transition">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        <div class="absolute top-3 right-3 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-black">
                            -{{ $product->discount }}%
                        </div>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1 line-clamp-2">{{ strtoupper($product->name) }}</h3>
                    <p class="text-xs text-gray-600 mb-2">{{ $product->color ?? 'Black' }}</p>
                    <div class="flex items-baseline gap-2">
                        <p class="font-black text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                        <p class="text-xs text-gray-500 line-through">{{ number_format($product->original_price, 0, ',', '.') }}₫</p>
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