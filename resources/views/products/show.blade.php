@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Product Details</h1>
        <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Back to List</a>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
        <div class="mb-4">
            <strong>Name:</strong> {{ $product->name }}
        </div>
        <div class="mb-4">
            <strong>Price:</strong> ${{ number_format($product->price, 2) }}
        </div>
        <div class="mb-4">
            <strong>Sale Price:</strong> ${{ number_format($product->sale_price, 2) }}
        </div>
        <div class="mb-4">
            <strong>Stock:</strong> {{ $product->stock }}
        </div>
        <div class="mb-4">
            <strong>Category:</strong> {{ $product->category->name ?? '-' }}
        </div>
        <div class="mb-4">
            <strong>Brand:</strong> {{ $product->brand }}
        </div>
        <div class="mb-4">
            <strong>Status:</strong> {{ $product->is_active ? 'Active' : 'Inactive' }}
        </div>
        <div class="mb-4">
            <strong>Description:</strong>
            <div>{{ $product->description }}</div>
        </div>
        <div class="mb-4">
            <strong>Image:</strong><br>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="h-32 mt-2">
            @else
                <span>No image</span>
            @endif
        </div>
    </div>
</div>
@endsection
