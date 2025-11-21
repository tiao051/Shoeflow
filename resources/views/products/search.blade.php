@extends('layouts.app')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">SEARCH RESULTS</h1>
            <p class="text-gray-600">Found {{ $products->count() }} results for "<strong>{{ $query }}</strong>"</p>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-12 bg-white rounded">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">NO RESULTS FOUND</h2>
                <p class="text-gray-600 mb-8">Try different keywords or browse our categories</p>
                <a href="/products" class="inline-block bg-black text-white px-8 py-3 rounded-full font-bold hover:bg-gray-800 transition">
                    BROWSE ALL PRODUCTS
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('product.detail', $product->id) }}" class="group">
                        <div class="aspect-square bg-white rounded overflow-hidden mb-4 shadow-sm hover:shadow-lg transition">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm mb-1 group-hover:text-gray-600 transition line-clamp-2">{{ strtoupper($product->name) }}</h3>
                        <p class="text-xs text-gray-600 mb-2">{{ $product->color ?? 'Black' }}</p>
                        <p class="font-black text-gray-900">{{ number_format($product->price, 0, ',', '.') }}₫</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection