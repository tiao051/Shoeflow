@extends('layouts.admin')

@section('title', 'Manage Shoes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Shoes</h2>
    <a href="{{ route('admin.shoes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Shoe
    </a>
</div>

<!-- Filter Form -->
<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('admin.shoes.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search shoes..." 
                       value="{{ $filters['search'] ?? '' }}">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat['id'] }}" {{ ($filters['category_id'] ?? '') == $cat['id'] ? 'selected' : '' }}>
                            {{ $cat['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.shoes.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shoes['data'] as $shoe)
                    <tr>
                        <td>
                            <img src="{{ $shoe->main_image ? asset('storage/' . $shoe->main_image) : 'https://via.placeholder.com/50' }}" 
                                 alt="{{ $shoe->name }}" width="50" class="rounded">
                        </td>
                        <td>{{ $shoe->name }}</td>
                        <td>{{ $shoe->brand }}</td>
                        <td>{{ $shoe->category->name }}</td>
                        <td>
                            @if($shoe->hasDiscount())
                                <span class="text-decoration-line-through text-muted">Rp {{ number_format($shoe->price, 0, ',', '.') }}</span><br>
                                <span class="text-danger fw-bold">Rp {{ number_format($shoe->discount_price, 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($shoe->price, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            @if($shoe->stock > 10)
                                <span class="badge bg-success">{{ $shoe->stock }}</span>
                            @elseif($shoe->stock > 0)
                                <span class="badge bg-warning">{{ $shoe->stock }}</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $shoe->is_active ? 'success' : 'secondary' }}">
                                {{ $shoe->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($shoe->is_featured)
                                <span class="badge bg-warning">Featured</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.shoes.edit', $shoe->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.shoes.destroy', $shoe->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No shoes found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
