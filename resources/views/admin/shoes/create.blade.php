@extends('layouts.admin')

@section('title', 'Create Shoe')

@section('content')
<div class="mb-4">
    <h2>Create Shoe</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.shoes.index') }}">Shoes</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.shoes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Shoe Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}" {{ old('category_id') == $category['id'] ? 'selected' : '' }}>
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Brand *</label>
                        <select name="brand" class="form-select @error('brand') is-invalid @enderror" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand }}" {{ old('brand') == $brand ? 'selected' : '' }}>
                                    {{ $brand }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Material</label>
                        <input type="text" name="material" class="form-control @error('material') is-invalid @enderror" 
                               value="{{ old('material') }}">
                        @error('material')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                          rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Price *</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" 
                               value="{{ old('price') }}" min="0" step="0.01" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Discount Price</label>
                        <input type="number" name="discount_price" class="form-control @error('discount_price') is-invalid @enderror" 
                               value="{{ old('discount_price') }}" min="0" step="0.01">
                        @error('discount_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                               value="{{ old('stock', 0) }}" min="0" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Available Sizes *</label>
                        <select name="sizes[]" class="form-select @error('sizes') is-invalid @enderror" multiple required>
                            @foreach($sizes as $size)
                                <option value="{{ $size }}" {{ in_array($size, old('sizes', [])) ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple sizes</small>
                        @error('sizes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" 
                               value="{{ old('color') }}">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Main Image</label>
                <input type="file" name="main_image" class="form-control @error('main_image') is-invalid @enderror" accept="image/*">
                @error('main_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured" value="1" 
                           {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured Product</label>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active">Active</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Create Shoe</button>
                <a href="{{ route('admin.shoes.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
