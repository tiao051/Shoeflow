@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-black text-gray-900 mb-4 tracking-tight">{{ $category ?? 'ALL PRODUCTS' }}</h1>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <p class="text-gray-600">Showing {{ $products->count() }} products</p>
                
                <!-- Filters & Sort -->
                <div class="flex gap-4">
                    <select class="px-4 py-2 border border-gray-300 rounded hover:border-gray-900 transition font-semibold text-sm">
                        <option>Sort: New</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Most Popular</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <a href="{{ route('product.detail', $product->id) }}" class="group">
                    <div class="aspect-square bg-white rounded overflow-hidden mb-4 shadow-sm hover:shadow-lg transition">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm mb-1 group-hover:text-gray-600 transition">{{ strtoupper($product->name) }}</h3>
                    <p class="text-xs text-gray-600 mb-2">{{ $product->color ?? 'Black' }}</p>
                    <p class="font-black text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</p>
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