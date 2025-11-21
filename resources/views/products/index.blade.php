@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Product List</h1>
        <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Product</a>
    </div>
    <table class="min-w-full bg-white dark:bg-gray-800">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Price</th>
                <th class="py-2 px-4 border-b">Stock</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td class="py-2 px-4 border-b">{{ $product->id }}</td>
                <td class="py-2 px-4 border-b">{{ $product->name }}</td>
                <td class="py-2 px-4 border-b">${{ number_format($product->price, 2) }}</td>
                <td class="py-2 px-4 border-b">{{ $product->stock }}</td>
                <td class="py-2 px-4 border-b">{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('products.show', $product) }}" class="text-blue-600 hover:underline">View</a>
                    <a href="{{ route('products.edit', $product) }}" class="text-yellow-600 hover:underline mx-2">Edit</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
