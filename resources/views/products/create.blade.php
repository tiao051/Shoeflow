@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Add Product</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Price</label>
            <input type="number" name="price" class="w-full border rounded px-3 py-2" value="{{ old('price') }}" step="0.01" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Sale Price</label>
            <input type="number" name="sale_price" class="w-full border rounded px-3 py-2" value="{{ old('sale_price') }}" step="0.01">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Stock</label>
            <input type="number" name="stock" class="w-full border rounded px-3 py-2" value="{{ old('stock', 0) }}" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Category</label>
            <select name="category_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Brand</label>
            <input type="text" name="brand" class="w-full border rounded px-3 py-2" value="{{ old('brand') }}">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Image</label>
            <input type="file" name="image" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="4">{{ old('description') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_active" value="1" class="form-checkbox" {{ old('is_active', 1) ? 'checked' : '' }}>
                <span class="ml-2">Active</span>
            </label>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
        <a href="{{ route('products.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
    </form>
</div>
@endsection
