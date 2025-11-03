@extends('layouts.app')

@section('title', 'All Shoes - Shoeler')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">All Shoes</h2>

    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Filters</h5>
                    <form action="{{ route('shoes.index') }}" method="GET">
                        <!-- Search -->
                        <div class="mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" value="{{ $filters['search'] ?? '' }}" placeholder="Search shoes...">
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat['id'] }}" {{ ($filters['category_id'] ?? '') == $cat['id'] ? 'selected' : '' }}>
                                        {{ $cat['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand -->
                        <div class="mb-3">
                            <label class="form-label">Brand</label>
                            <select name="brand" class="form-select">
                                <option value="">All Brands</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ ($filters['brand'] ?? '') == $brand ? 'selected' : '' }}>
                                        {{ $brand }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ $filters['min_price'] ?? '' }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ $filters['max_price'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label class="form-label">Sort By</label>
                            <select name="sort" class="form-select">
                                <option value="newest" {{ ($filters['sort'] ?? '') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ ($filters['sort'] ?? '') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ ($filters['sort'] ?? '') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ ($filters['sort'] ?? '') == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        <a href="{{ route('shoes.index') }}" class="btn btn-outline-secondary w-100 mt-2">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="row g-4">
                @forelse($shoes['data'] as $shoe)
                <div class="col-md-4">
                    <div class="card product-card h-100">
                        @if($shoe->hasDiscount())
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -{{ $shoe->discount_percentage }}%
                            </span>
                        @endif
                        <img src="{{ $shoe->main_image ? asset('storage/' . $shoe->main_image) : 'https://via.placeholder.com/300x250' }}" 
                             class="card-img-top" alt="{{ $shoe->name }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $shoe->name }}</h6>
                            <p class="text-muted small">{{ $shoe->brand }}</p>
                            <div class="mb-2">
                                @if($shoe->hasDiscount())
                                    <span class="text-decoration-line-through text-muted">Rp {{ number_format($shoe->price, 0, ',', '.') }}</span>
                                    <br>
                                    <span class="fw-bold text-danger">Rp {{ number_format($shoe->discount_price, 0, ',', '.') }}</span>
                                @else
                                    <span class="fw-bold">Rp {{ number_format($shoe->price, 0, ',', '.') }}</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $shoe->rating ? '-fill' : '' }} text-warning"></i>
                                @endfor
                                <small class="text-muted">({{ $shoe->review_count }})</small>
                            </div>
                            <a href="{{ route('shoes.show', $shoe->slug) }}" class="btn btn-sm btn-outline-primary mt-auto">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">No shoes found.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($shoes['last_page']) && $shoes['last_page'] > 1)
            <div class="mt-4">
                <nav>
                    <ul class="pagination justify-content-center">
                        @for($i = 1; $i <= $shoes['last_page']; $i++)
                        <li class="page-item {{ $i == $shoes['current_page'] ? 'active' : '' }}">
                            <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $i]) }}">{{ $i }}</a>
                        </li>
                        @endfor
                    </ul>
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
